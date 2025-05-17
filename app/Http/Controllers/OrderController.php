<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
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
}