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

    public function index($search){
        // dd($search);
        if($search != ""){
           return $this->model->where("title","LIKE","%$search%")->orWhere("product_code","LIKE","%$search%")->orderBy('created_at', 'DESC')->paginate(5);
        }else{
           return $this->model->orderBy('created_at', 'DESC')->paginate(5); 
        }
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
        // dd($this->model->find($payload['id']));
        return $this->model->find($payload['id'])->update([
            'title'=> $payload['title'],
            'price'=> $payload['price'],
            'product_code'=> $payload['product_code'],
            'description'=> $payload['description'],
        ]);
    }

    public function delete($payload){
        // dd($payload);
        return $this->model->find($payload)->delete();
    }
}
