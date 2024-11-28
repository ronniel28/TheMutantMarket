<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        // Ensure the authenticated user owns the order
        $this->authorize('view', $order);

        return view('orders.show', compact('order'));

    }
    
    public function store(Request $request)
    {
        $cart = Auth::user()->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Your cart is empty!');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $cart->items->sum(fn($item) => $item->quantity * $item->product->price),
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        $cart->items()->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
    }
}
