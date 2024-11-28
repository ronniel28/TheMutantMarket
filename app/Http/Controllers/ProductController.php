<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        // Add middleware to protect admin routes
        $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        // Paginate products, you can adjust the number per page (10 in this case)
        $products = Product::paginate(10);

        // Return views based on user roles
        $view = auth()->user()->hasRole('admin') ? 'admin.products.index' : 'products.index';
        
        return view($view, compact('products'));

    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(ProductRequest $request) // Use ProductRequest
    {
        Product::create($request->validated()); // Use validated data

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product) // Use ProductRequest
    {
        $product->update($request->validated()); // Use validated data

        return redirect()->route('products.index')->with('success', 'Product updated!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Product deleted!');
    }

}
