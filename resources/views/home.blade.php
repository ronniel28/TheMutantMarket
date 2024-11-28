@extends('layouts.app')

@section('content')
<div class="container text-center my-5">
    <h1 class="display-4">Welcome to Our Online Store</h1>
    <p class="lead">Your one-stop shop for the best products at unbeatable prices. Browse, shop, and have your items delivered right to your door.</p>

    <div class="my-4">
        <p>At our store, we offer a wide range of high-quality products, including electronics, fashion, home goods, and much more. Our mission is to provide excellent customer service and make your shopping experience seamless and enjoyable.</p>

        <p>Start exploring our collection today!</p>
    </div>

    <div class="mt-5">
        <a href="{{ route('cart.index') }}" class="btn btn-primary btn-lg">Go to Cart</a>
    </div>
    <div class="mt-5">
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Start Shopping</a>
    </div>
</div>
@endsection