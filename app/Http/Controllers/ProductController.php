<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\Create;
use App\Http\Requests\Product\Update;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $search = $request['search'] ?? "";
        $products = $this->productService->index($request);
        $data = compact("products","search");
        return view('dashboard')->with($data);
    }

    public function create()
    {
        return view('products.create');
    }

    public function show(Request $request){
        $product = $request->product;
        return view('products.show',compact("product"));
    }

    public function store(create $request)
    {
        $product = $this->productService->store($request);
        // dd($product->title);
        return redirect()
            ->route('products.index')
            ->with('success', $product->title.' added successfully');
    }

    public function edit(request $request)
    {
        $product = $request->product;
        return view('products.edit',compact('product'));
    }

    public function update(Update $request)
    {
        $this->productService->update($request);
        return redirect()->route('products.index')->with('success', $request->product->title." updated successfully");  
    }

    public function destroy(Request $request)
    {

        $this->productService->delete($request);
        return redirect()->route('products.index')->with('success',"product deleted successfully");
    }
}
