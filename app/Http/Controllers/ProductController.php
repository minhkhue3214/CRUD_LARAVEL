<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            
            $product = Product::orderBy('created_at', 'DESC')->get();
            // dd($product);
            return view('dashboard',compact('product'));
        }

    }

    public function searchProducts(Request $request)
    {
        if($request->search){
            $product = Product::where("name","LIKE","%".$request->search."")->latest();
            return view('dashboard',compact('product'));
        }else{
            return redirect()->back()->with("message","empty search");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "title" =>"required",
            "price" =>"required",  
            "product_code" =>"required",  
            "description" =>"required",  
        ]);
        $data = $request->except(['_token']);
        Product::create($data);

        // Product::create($request->all());

        return redirect()
            ->route('products')
            ->with('success', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->except(['_token']); // Loại bỏ trường _token ra khỏi dữ liệu
        
        $product->update($data); // Sử dụng dữ liệu đã loại bỏ _token
        
        return redirect()->route('products')->with('success', "Product updated successfully");
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products')->with('success',"product deleted successfully");
    }
}
