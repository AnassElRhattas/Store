<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:1000',
            'payment_method' => 'required|string|in:card,cash',
            'selectedItems' => 'required|array'
        ]);

        try {
            DB::beginTransaction();

            $cartItems = Cart::whereIn('id', $request->selectedItems)
                ->where('user_id', Auth::id())
                ->with('product')
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Please select items to checkout');
            }

            $total = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'status' => 'pending'
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }

            // Cart items will be kept until order confirmation
            // Cart::whereIn('id', $request->selectedItems)->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Commande créée avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la création de la commande');
        }
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }

        return inertia('Orders/Show', [
            'order' => $order->load(['items.product', 'user'])
        ]);
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return inertia('Orders/Index', compact('orders'));
    }

    public function adminIndex()
    {
        $orders = Order::with(['items.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return inertia('Admin/Orders/Index', [
            'orders' => $orders->items()
        ]);
    }

    public function updateStatus(Order $order, Request $request)
    {
        \Log::info('Update order status', ['order_id' => $order->id, 'status' => $request->status]);
        
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|string|in:approved,rejected'
        ]);

        try {
            $order->update([
                'status' => $request->status
            ]);

            if ($request->status === 'approved') {
                // Delete cart items after order is approved
                Cart::where('user_id', $order->user_id)
                    ->whereIn('product_id', $order->items->pluck('product_id'))
                    ->delete();
            }

            return redirect()->back()
                ->with('success', $request->status === 'approved' ? 'تم قبول الطلب بنجاح' : 'تم رفض الطلب بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء تحديث حالة الطلب');
        }

        
    }

    public function storeDirect(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
            'products' => 'required|array|min:1'
        ]);
    
        try {
            DB::beginTransaction();
    
            $products = Product::whereIn('id', $request->products)
                             ->where('is_active', true)
                             ->get();
            
            if ($products->isEmpty()) {
                return redirect()->back()
                    ->with('error', 'المنتجات المحددة غير متوفرة');
            }
            
            // Calculer le total comme dans l'ancienne méthode
            $total = $products->sum('price');
    
            // Créer la commande d'abord
            $order = new Order();
            $order->user_id = null;
            $order->total_amount = $total;
            $order->shipping_address = $request->address;
            $order->customer_name = $request->first_name . ' ' . $request->last_name;
            $order->customer_phone = $request->phone;
            $order->status = 'pending';
            $order->payment_method = 'cash';
            $order->save();
    
            // Créer les items de commande
            foreach ($products as $product) {
                if ($product->stock <= 0) {
                    throw new \Exception("المنتج {$product->name} غير متوفر في المخزون");
                }

                // Créer l'item de commande
                $orderItem = new OrderItem([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $product->price
                ]);
                $order->items()->save($orderItem);

                // Mettre à jour le stock
                $product->decrement('stock', 1);
            }
    
            DB::commit();
            
            return redirect()->back()
                ->with('success', 'تم إنشاء طلبك بنجاح');
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إنشاء طلبك');
        }
    }
}