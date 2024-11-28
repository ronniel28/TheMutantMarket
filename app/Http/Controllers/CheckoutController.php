<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Charge;


class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = $cart->items->sum(fn($item) => $item->quantity * $item->product->price);

        return view('checkout.index', compact('cart', 'total'));
    }

    public function store(Request $request)
{
    // Validate the stripe token to ensure it exists
    $request->validate([
        'stripeToken' => 'required',
    ]);

    // Get the authenticated user's cart
    $cart = Auth::user()->cart;

    // If the cart is empty, redirect with an error
    if (!$cart || $cart->items->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
    }

    // Calculate the total price of the cart items
    $total = $cart->items->sum(fn($item) => $item->quantity * $item->product->price);

    // Set the Stripe API key
    Stripe::setApiKey(env('STRIPE_SECRET'));

    try {
        // Attempt to charge the user
        $charge = Charge::create([
            'amount' => $total * 100, // Stripe expects amount in cents
            'currency' => 'usd',
            'description' => 'Order payment',
            'source' => $request->stripeToken, // The token received from Stripe.js
        ]);
        
        // The charge object can be useful for tracking payment details (optional)
        // You could store it in the order if necessary:
        // $chargeId = $charge->id;

    } catch (\Exception $e) {
        // If there's an error with the payment, redirect back with the error message
        return back()->with('error', $e->getMessage());
    }

    // After payment is successful, create the order
    $order = Order::create([
        'user_id' => Auth::id(),
        'total_price' => $total,
        'stripe_charge_id' => $charge->id, // Optional: store the Stripe charge ID for reference
        // You can add additional order fields, such as shipping_address if needed
    ]);

    // Add items to the order from the cart
    foreach ($cart->items as $item) {
        $order->items()->create([
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->product->price,
        ]);
    }

    // Clear the cart after the order is placed
    $cart->items()->delete();

    // Optionally, you can update the order status, for example:
    // $order->update(['status' => 'paid']);

    // Redirect the user to the order confirmation page
    return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
}
}
