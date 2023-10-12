<?php

namespace App\Repositories;
use App\Models\Product;

class ProductRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Product();
    }

    public function create($payload) {
        return $this->model->create([
            'title'=> $payload['title'],
            'price'=> $payload['price'],
            'product_code'=> $payload['product_code'],
            'description'=> $payload['description'],
        ]);
    }

    public function edit($payload) {
        return $this->model->update([
            'title'=> $payload['title'],
            'price'=> $payload['price'],
            'product_code'=> $payload['product_code'],
            'description'=> $payload['description'],
        ]);
    }
}
