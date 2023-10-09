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
    public function index(Request $request)
    {
        if (Auth::check()) {
            $search = $request['search'] ?? "";
            if($search != ""){
                $products = Product::where("title","LIKE","%$search%")->orWhere("product_code","LIKE","%$search%")->orderBy('created_at', 'DESC')->paginate(5);
            }else{
                $products = Product::orderBy('created_at', 'DESC')->paginate(5); 
            }
            
            $data = compact("products","search");
            return view('dashboard')->with($data);
        }else{
            return redirect('login')->withErrors(['error' => 'please login to access the dashboard page']);
        }

    }

    // public function searchProducts()
    // {
    //     $search_text = $_GET["query"];
    //     $products = Product::Where("name","LIKE","%".$search_text."%")->get(); 
    //     return view('dashboard',compact('products'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check()) {
            return view('products.create');
        }else{
            return redirect('login')->withErrors(['error' => 'please login to access the dashboard page']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        
        $request->validate([
            "title" =>"required",
            "price" =>"required|integer",  
            "product_code" =>"required",  
            "description" =>"required",  
        ]);

        // $this->data['errorMessage'] = "Vui lòng kiểm tra lại thông tin";

        //handle add product to database
        Product::create([
            'title'=> $request->input('title'),
            'price'=> $request->input('price'),
            'product_code'=> $request->input('product_code'),
            'description'=> $request->input('description'),
        ]);

        return redirect()
            ->route('products')
            ->with('success', 'Product added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::check()) {
            $product = Product::findOrFail($id);
            return view('products.edit',compact('product'));
        }else{
            return redirect('login')->withErrors(['error' => 'please login to access the dashboard page']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            "title" =>"required",
            "price" =>"required",  
            "product_code" =>"required",  
            "description" =>"required",  
        ]);
        
        $product->update([
            'title'=> $request->input('title'),
            'price'=> $request->input('price'),
            'product_code'=> $request->input('product_code'),
            'description'=> $request->input('description'),
        ]); 
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
