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
        $cart = Auth::user()->cart;
        return view('cart.index', compact('cart'));
    }

    public function add(Product $product)
    {
        $cart = Auth::user()->cart ?? Cart::create(['user_id' => Auth::id()]);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        // Either increment the existing quantity or create a new cart item
        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $cart->items()->create(['product_id' => $product->id, 'quantity' => 1]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }
}
