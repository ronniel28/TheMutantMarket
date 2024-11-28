@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Details</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Order #{{ $order->id }}</h5>
            <p class="card-text"><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y, g:i a') }}</p>
            <p class="card-text"><strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}</p>
        </div>
    </div>

    <h3 class="mt-4">Order Items</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total:</th>
                <th>${{ number_format($order->total_price, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
</div>
@endsection
