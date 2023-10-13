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

    public function create(Request $request) {
        $payload = [
            'title'=> $request->input('title'),
            'price'=> $request->input('price'),
            'product_code'=> $request->input('product_code'),
            'description'=> $request->input('description'),
        ];

        return $this->productRepo->create($payload);
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

        return $this->productRepo->edit($payload);
    }

    public function delete(Request $request){
        // dd($request->product->id);

        return $this->productRepo->delete($request->product->id);
    }
}