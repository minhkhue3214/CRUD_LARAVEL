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
        $order = $this->model->create([
            'user_name'=> $payload['user_name'],
            'user_id'=> $payload['user_id'],
            'price'=> $payload['price'],
        ]);
        
        $productcart = Session::get('productcart'); 
        $packagecart = Session::get('packagecart');

        foreach ($productcart as $product) {
            $this->order_detail->create([
                'order_id'=> $order->id,
                'product_id'=> $product['id'],
                'package_id'=> null,
                'product_quantity'=> $product['quantity'],
                'package_quantity'=> null,
            ]);
        }

        foreach ($packagecart as $package) {
            $this->order_detail->create([
                'order_id'=> $order->id,
                'product_id'=> null,
                'package_id'=> $package['id'],
                'package_quantity'=> $package['quantity'],
                'product_quantity'=> null,
            ]);
        }
        

    }

    public function getOrders() {
        return $this->model->all();
    }

    public function destroy($order){
        if ($order) {
            $order->orderdetail()->delete();
            $order->delete(); 
        }
    }

    public function show($order) {
        if ($order) {
           return $order->orderdetail()->get();
        }
    }

    public function getProductFromOrder($payload) {

        $productIds = $this->order_detail->where('order_id', $payload)->pluck('product_id')->toArray();
        $productQuantity = $this->order_detail->where('order_id', $payload)->pluck('product_quantity')->toArray();

        // dd($productQuantity);
        $filteredproductIds = array_filter($productIds, function ($value) {
            return $value !== null;
        });
        
        $filteredproductQuantity = array_filter($productQuantity, function ($value) {
            return $value !== null;
        });


        $products = $this->product->whereIn('id', $filteredproductIds)->get();
        
        for ($i = 0; $i < count($products); $i++) {
            // Nếu chưa có trường 'quantity', hãy tạo nó và gán giá trị
            $products[$i]['quantity'] = $filteredproductQuantity[$i];
        }
        
        return $products;

    }

    public function getPackageFromOrder($payload) {

        $packageIds = $this->order_detail->where('order_id', $payload)->pluck('package_id')->toArray();
        $packageQuantity = $this->order_detail->where('order_id', $payload)->pluck('package_quantity')->toArray();

        $filteredpackageIds = array_filter($packageIds, function ($value) {
            return $value !== null;
        });
        
        $filteredpackageQuantity = array_filter($packageQuantity, function ($value) {
            return $value !== null;
        });

        $newPackageQuantity = array_values($filteredpackageQuantity);

        $packages = $this->package->whereIn('id', $filteredpackageIds)->get();
        // dd($packages);
            for ($i = 0; $i < count($packages); $i++) {
                $packages[$i]['quantity'] = $newPackageQuantity[$i];
            }

        return $packages;
    }


}
