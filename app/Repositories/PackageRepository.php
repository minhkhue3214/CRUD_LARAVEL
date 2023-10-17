<?php

namespace App\Repositories;
use App\Models\Package;
use App\Models\Product;

// use App\Models\product_relationship;

class PackageRepository
{
    protected $model;
    protected $product;
    // protected $productpackage;

    public function __construct()
    {
        $this->model = new Package();
        $this->product = new Product();

        // $this->relationProduct = new product_relationship();
    }

    public function index($search){
        if($search != ""){
            
            return $this->model->where("name","LIKE","%$search%")->orderBy('created_at', 'DESC')->paginate(5);
        }else{
            // dd($this->model->orderBy('created_at', 'DESC')->paginate(5));
            return $this->model->orderBy('created_at', 'DESC')->paginate(5); 
        }
    }

    public function store($payload)
    {
        $package = $this->model->create([
            'name'=> $payload['package_name'],
            'description'=> $payload['package_description'],
        ]);
        //Cách 1
        // $product = $package->product()->sync($payload["product_list"]);

        //Cách 2
        $package->product()->attach($payload["product_list"]);
        // $product = Product::whereIn('id', $payload["product_list"])->package()->save($package);
        // dd(Product::findMany($payload["product_list"]));
        // dd(Product::find(1));

        // dd($product);

        // return $this->model->create([
        //     'package_name'=> $payload['package_name'],
        //     'package_description'=> $payload['package_description'],
        // ]);
        //  dd($package);
    }

    public function show($payload)
    {
        // dd($payload);
        // dd($this->model->find($payload));
        // $products = $this->model->find($payload)->product();
        // $package = $this->model->find($payload);
        
        // $products = $this->model->with("product")->get();
        
        $products = $this->model->with("product")
        ->where('id', $payload)
        ->first();

        $relations = $products->getRelations();

        // dd($relations);

        return $relations['product'];
    }

    public function update($payload) {
        // dd($payload);
        $package = $this->model->find($payload['id']);
        // dd($package);

        $package->product()->sync($payload["product_list"]);

        return $this->model->where('id', $payload['id'])->update([
                'name'=> $payload['name'],
                'description'=> $payload['description'],
        ]);
    }

    public function delete($payload){
        $package = $this->model->find($payload);
        // dd($package);

        if($package){
            $package->product()->detach();

            $package->delete();
        }
    }
}
