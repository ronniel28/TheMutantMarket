@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Products</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($products->isEmpty())
            <div class="alert alert-warning">
                No products available at the moment.
            </div>
        @else
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text"><strong>${{ $product->price }}</strong></p>
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="pagination mt-3">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
