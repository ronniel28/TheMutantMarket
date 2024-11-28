@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Cart</h1>
    @if($cart && $cart->items->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ $item->product->price }}</td>
                        <td>${{ $item->quantity * $item->product->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a  class="btn btn-success" href="{{ route('checkout.index') }}">
           Checkout
        </a>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
