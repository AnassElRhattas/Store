<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return inertia('Cart', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }

    public function addToCart(Request $request, Product $product)
    {
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Ce produit est en rupture de stock');
        }

        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingCart) {
            $existingCart->quantity += 1;
            if ($existingCart->quantity > $product->stock) {
                return redirect()->back()->with('error', 'La quantité demandée dépasse le stock disponible');
            }
            $existingCart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès');
    }

    public function updateQuantity(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->firstOrFail();

        if ($request->quantity > $product->stock) {
            return redirect()->back()->with('error', 'La quantité demandée dépasse le stock disponible');
        }

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->back()->with('success', 'Quantité mise à jour avec succès');
    }

    public function removeFromCart(Cart $cart)
    {
        $cart->delete();

        return redirect()->back()->with('success', 'Produit retiré du panier');
    }
}