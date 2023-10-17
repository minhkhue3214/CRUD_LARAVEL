<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageProduct\Create;
use App\Http\Requests\PackageProduct\Update;
use App\Models\Product;
use App\Models\product_relationship;
use App\Models\Package;
use App\Services\PackageService;
use App\Services\ProductRelationService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    protected packageService $packageService;
    protected ProductService $productService;
    protected ProductRelationService $productRelationService;

    public function __construct(ProductService $productService,PackageService $packageService,ProductRelationService $productRelationService) {
        $this->packageService = $packageService;
        $this->productService = $productService;
        $this->productRelationService = $productRelationService;
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
        $Package = $this->packageService->store($request);

        return redirect()
        ->route('packages.index')
        ->with('success', 'Product Package added successfully');
    }

    public function show(Request $request)
    {
        $package = $request->package;
        // $productsRelation = $this->productRelationService->productsRelation($request);
        // $products = $this->productService->productInPackage($productsRelation);
        $products = $this->packageService->show($request);
        // dd($products['product']);

        $data = compact("package","products");
        return view('productspackage.show')->with($data);
    }

    public function destroy(Request $request)
    {
        // dd("testing");
        
        $this->packageService->delete($request);
        return redirect()
        ->route('packages.index')
        ->with('success', 'Product Package deleted successfully');
    }

    public function edit(Request $request)
    { 
            //lấy thông tin gói sản phẩm
            $package = $request->package;
            //lấy thông tin các sản phẩm
            $products = $this->productService->getListProduct();
            $selectedProducts = $this->packageService->show($request);
            $productIds = collect($selectedProducts)->pluck('id')->toArray();
    
            $data = compact("package","productIds","products");
            return view('productspackage.edit')->with($data);
    }

    public function update(Update $request){
        $this->packageService->update($request);

        return redirect()
        ->route('packages.index')
        ->with('success', 'Product Package deleted successfully'); 
    }

}
