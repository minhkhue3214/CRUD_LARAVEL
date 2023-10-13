<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\Create;
use App\Http\Requests\Product\Update;
use App\Models\Product;
use App\Models\product_relationship;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request['search'] ?? "";
        // if($search != ""){
        //     $products = Product::where("title","LIKE","%$search%")->orWhere("product_code","LIKE","%$search%")->orderBy('created_at', 'DESC')->paginate(5);
        // }else{
        //     $products = Product::orderBy('created_at', 'DESC')->paginate(5); 
        // }
        
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
    public function store(Create $request)
    {
        $products = $this->productService->create($request);

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
        // $products = $this->productService->update($request);
        // $product = $request->product;
        
        // dd($product);
        // $product->update([
        //     'title'=> $request->input('title'),
        //     'price'=> $request->input('price'),
        //     'product_code'=> $request->input('product_code'),
        //     'description'=> $request->input('description'),
        // ]);

        // dd($request->product->id);
        // dd($productUpdated);
        $productUpdated = $this->productService->update($request);
        return redirect()->route('products.index')->with('success', "Product updated successfully");  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // dd($request->product->id);
        // $product = $request->product;
        // $product->delete();
        product_relationship::where('product_id', $request->product->id)->delete();

        $this->productService->delete($request);
        return redirect()->route('products.index')->with('success',"product deleted successfully");
    }
}
