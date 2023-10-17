<?php

namespace App\Repositories;
use App\Models\ProductPackage;

class ProductRelationRepository
{
    protected $model;

    public function __construct()
    {
        // $this->model = new product_relationship();
    }

    public function productsRelation($payload){
        return $this->model->where('product_package_id', '=',$payload )->get();
    }

    public function findProductById($payload){
        // dd($payload);
        return $this->model->where('product_package_id', $payload['product_package_id'])->where('product_id', $payload['product_id'])->first();
    }

    public function getSelectedProduct($payload){
        // dd($payload);
        return $this->model->where('product_package_id', $payload)->get();
    }

    public function store($payload)
    {
        return $this->model->create([
            'product_id'=> $payload['product_id'],
            'product_package_id'=> $payload['product_package_id'],
        ]);    
    }

    public function delete($payload){
        // dd($payload);
        return $this->model->where('product_id',$payload)->delete();
    }

    public function unCheckProduct($payload){
        // dd($payload);
        return $this->model->where('product_package_id', $payload['product_package_id'])->where('product_id', $payload['product_id'])->first()->delete();;
    }
}
