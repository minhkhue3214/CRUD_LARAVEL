<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\ProductRepository;

class ProductService
{
    protected ProductRepository $productRepo;

    public function __construct(ProductRepository $productRepo) {
        $this->productRepo = $productRepo;
    }

    public function index(Request $request)
    {
        $search = $request['search'] ?? "";
        return $this->productRepo->index($search);
    }

    public function getListProduct(){
        return $this->productRepo->getListProduct();
    }

    public function Store(Request $request) {
        $payload = [
            'title'=> $request->input('title'),
            'price'=> $request->input('price'),
            'product_code'=> $request->input('product_code'),
            'description'=> $request->input('description'),
        ];

        return $this->productRepo->store($payload);
    }

    public function update(Request $request) {
        // dd($request);
        $payload = [
            "id"=>$request->product->id,
            'title'=> $request->input('title'),
            'price'=> $request->input('price'),
            'product_code'=> $request->input('product_code'),
            'description'=> $request->input('description'),
        ];

        return $this->productRepo->update($payload);
    }

    public function delete(Request $request){
        // dd($request->product->id);
        return $this->productRepo->delete($request->product->id);
    }

    public function productInPackage($productsRelation){
        // dd($productsRelation);
        foreach ($productsRelation as $item) {
           $productPackageIds[] = $item['product_id'];
        }
        // dd($request->product->id);
        return $this->productRepo->productInPackage($productPackageIds);
    }
}