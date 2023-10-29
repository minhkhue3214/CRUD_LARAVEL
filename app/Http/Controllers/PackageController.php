<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageProduct\Create;
use App\Http\Requests\PackageProduct\Update;
use App\Services\PackageService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    protected packageService $packageService;
    protected ProductService $productService;

    public function __construct(ProductService $productService,PackageService $packageService) {
        $this->packageService = $packageService;
        $this->productService = $productService;
    }
    

    public function index(Request $request){

        $search = $request['search'] ?? "";
        $packages = $this->packageService->index($request);
        // dd($packages);
        $data = compact("packages","search");
        return view('productspackage.table')->with($data);
    }

    public function create()
    {
            $products = $this->productService->getListProduct();
            $data = compact("products");    
            return view('productspackage.create')->with($data);        
    }

    public function store(Create $request)
    {
        $this->packageService->store($request);

        return redirect()
        ->route('packages.index')
        ->with('success', 'Product Package added successfully');
    }

    public function show(Request $request)
    {
        $package = $request->package;
        $products = $this->packageService->show($request);

        $data = compact("package","products");
        return view('productspackage.show')->with($data);
    }

    public function destroy(Request $request)
    {        
        $this->packageService->delete($request);
        return redirect()
        ->route('packages.index')
        ->with('success', 'Product Package deleted successfully');
    }

    public function edit(Request $request)
    { 
            $package = $request->package;
            $products = $this->productService->getListProduct();
            $selectedProducts = $this->packageService->show($request);
            $productIds = collect($selectedProducts)->pluck('id')->toArray();
    
            return view('productspackage.edit', compact("package","productIds","products"));
    }

    public function update(Update $request){
        $this->packageService->update($request);

        return redirect()
        ->route('packages.index')
        ->with('success', 'Product Package deleted successfully'); 
    }

}
