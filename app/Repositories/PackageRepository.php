<?php

namespace App\Repositories;
use App\Models\Package;
use App\Models\Product;

// use App\Models\product_relationship;

class PackageRepository
{
    protected $model;
    protected $product;

    public function __construct()
    {
        $this->model = new Package();
        $this->product = new Product();
    }

    public function index($search){
        if($search != ""){            
            return $this->model->where("name","LIKE","%$search%")->orderBy('created_at', 'DESC')->paginate(5);
        }else{
            return $this->model->orderBy('created_at', 'DESC')->paginate(5); 
        }
    }

    public function getListPackage(){
        return $this->model->orderBy('created_at', 'DESC')->get();
     }

    public function show($payload)
    {   
        $products = $this->model->with("product")
        ->where('id', $payload)
        ->first();

        $relations = $products->getRelations();
        return $relations['product'];
    }
    public function caculatePrice($payload)
    {   
        $products = $this->model->with("product")
        ->where('id', $payload)
        ->first();

        $relations = $products->getRelations();
        $totalPrice = collect($relations['product'])->pluck('price')->sum();
        
        return $totalPrice;
    }

    public function store($payload)
    {
        $package = $this->model->create([
            'name'=> $payload['package_name'],
            'description'=> $payload['package_description'],
        ]);
        // dd($package->product());
        // 1
        // $product = $package->product()->sync($payload["product_list"]);
        // 2
        return $package->product()->attach($payload["product_list"]);
    }

    public function update($payload) {
        $package = $this->model->find($payload['id']);

        $package->product()->sync($payload["product_list"]);

        return $this->model->where('id', $payload['id'])->update([
                'name'=> $payload['name'],
                'description'=> $payload['description'],
        ]);
    }

    public function delete($payload){
        $package = $this->model->find($payload);

        if($package){
            $package->product()->detach();
            $package->delete();
        }
    }
}
