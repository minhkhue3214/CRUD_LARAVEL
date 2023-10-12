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
        $payload = [
            'title'=> $request->input('title'),
            'price'=> $request->input('price'),
            'product_code'=> $request->input('product_code'),
            'description'=> $request->input('description'),
        ];

        return $this->productRepo->edit($payload);
    }
}