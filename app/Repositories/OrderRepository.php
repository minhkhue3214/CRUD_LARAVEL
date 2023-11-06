<?php

namespace App\Repositories;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Package;
use Illuminate\Support\Facades\Session;

class OrderRepository
{
    protected $model;
    protected $order_detail;
    protected $product;
    protected $package;

    public function __construct()
    {
        $this->model = new Order();
        $this->order_detail = new OrderDetail();
        $this->product = new Product();
        $this->package = new Package();
    }

    public function store($payload) {
        return $this->model->create([
            'user_name'=> $payload['user_name'],
            'user_id'=> $payload['user_id'],
            'price'=> $payload['price'],
        ]);
    }

    // public function storeProductIntoOrder($order,$product) {
    //     $order->product()->attach([
    //         'product_id'=> $product['id'],
    //         'product_quantity'=> $product['quantity'],
    //     ]);
    // }
    
    // public function storePackageIntoOrder($order,$package) {
    //     $order->package()->attach([
    //         'package_id'=> $package['id'],
    //         'package_quantity'=> $package['quantity'],
    //     ]);
    // }

    public function storeProductIntoOrder($order,$product) {
        // dd($order->product());
        $order->orderdetail()->create([
            'product_id'=> $product['id'],
            'product_quantity'=> $product['quantity'],
        ]);
    }
    public function storePackageIntoOrder($order,$package) {
        $order->orderdetail()->create([
            'package_id'=> $package['id'],
            'package_quantity'=> $package['quantity'],
        ]);
    }

    public function getOrders() {
        return $this->model->all();
    }

    public function destroy($order){
            $order->orderdetail()->delete();
            $order->delete(); 
    }

    public function show($order) {        
           return $order->orderdetail()->get();
    }

    public function getProductFromOrder($payload) {

        $filteredProductQuantity = $this->order_detail->where('order_id', $payload)
        ->pluck('product_quantity')
        ->filter()
        ->toArray();

        $filteredProductIds = $this->order_detail->where('order_id', $payload)
        ->pluck('product_id')
        ->filter()
        ->toArray();


        $products = $this->product->whereIn('id', $filteredProductIds)->get();
        
        for ($i = 0; $i < count($products); $i++) {
            $products[$i]['quantity'] = $filteredProductQuantity[$i];
        }
        
        return $products;
    }

    public function getPackageFromOrder($payload) {

        $filteredpackageIds = $this->order_detail->where('order_id', $payload)
        ->pluck('package_id')
        ->filter()
        ->toArray();

        $filteredpackageQuantity = $this->order_detail->where('order_id', $payload)
        ->pluck('package_quantity')
        ->filter()
        ->toArray();
    
        $newPackageQuantity = array_values($filteredpackageQuantity);

        $packages = $this->package->whereIn('id', $filteredpackageIds)->get();

        for ($i = 0; $i < count($packages); $i++) {
                $packages[$i]['quantity'] = $newPackageQuantity[$i];
            }

        return $packages;
    }


}
