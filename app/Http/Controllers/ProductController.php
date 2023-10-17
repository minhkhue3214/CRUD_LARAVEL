<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\Create;
use App\Http\Requests\Product\Update;
use App\Models\Product;
use App\Models\product_relationship;
use App\Services\ProductService;
use App\Services\ProductRelationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected ProductService $productService;
    protected ProductRelationService $productRelationService;

    public function __construct(ProductService $productService,ProductRelationService $productRelationService) {
        $this->productService = $productService;
        $this->productRelationService = $productRelationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request['search'] ?? "";
        $products = $this->productService->index($request);
        $data = compact("products","search");
        return view('dashboard')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    public function show(Request $request){

        $product = $request->product;
        return view('products.show',compact("product"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(create $request)
    {
       
        $products = $this->productService->store($request);
        return redirect()
            ->route('products.index')
            ->with('success', 'Product added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(request $request)
    {
        $product = $request->product;
        return view('products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        $productUpdated = $this->productService->update($request);
        return redirect()->route('products.index')->with('success', "Product updated successfully");  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $this->productService->delete($request);
        // $this->productRelationService->delete($request);
        return redirect()->route('products.index')->with('success',"product deleted successfully");
    }
}
