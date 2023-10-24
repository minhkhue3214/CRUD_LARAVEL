<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Services\OrderService;
use App\Services\PackageService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;



class OrderController extends Controller
{

    protected packageService $packageService;
    protected ProductService $productService;
    protected OrderService $orderService;

    public function __construct(ProductService $productService,PackageService $packageService,OrderService $orderService) {
         $this->packageService = $packageService;
         $this->productService = $productService;
         $this->orderService = $orderService;
    }

    public function index(Request $request){

        $products = $this->productService->getListProduct();
        $packages = $this->packageService->getListPackage();
        $cart = [];
        Session::put('cart', $cart);
        return view('home.home',compact("products","packages"));
    }

    public function orders(){
        $orders = $this->orderService->getOrders();
        // dd($orders);
        return view('orders.orders')->with("orders",$orders);
    }

    public function insertProductToCart(Request $request){
        $product = $request->product;
        // dd($product->id);
        $productcart = Session::get('productcart'); 
        $packagecart = Session::get('packagecart'); 

        $products = $this->productService->getListProduct();
        $packages = $this->packageService->getListPackage();

        $productIds = array_map(function ($product) {
            return $product['id'];
        }, $productcart);

        if (in_array($product->id, $productIds)) {

        return view('home.home',compact("products","packages","productcart","packagecart"));
        } else {
        $product->quantity = 1;
        array_push($productcart, $product);
        // dd($productcart);
        Session::put('productcart', $productcart);

        return view('home.home',compact("products","packages","productcart","packagecart"));
        }
    }

    public function removeProductFromCart(Request $request){
        // dd($request->product);
        $id = $request->product->id;
        $productcart = Session::get('productcart'); 
        $packagecart = Session::get('packagecart');
        
        $products = $this->productService->getListProduct();
        $packages = $this->packageService->getListPackage();

        foreach ($productcart as $key => $product) {
            if ($product['id'] == $id) {
                unset($productcart[$key]);
            }
        }
        Session::put('productcart', $productcart);

        return view('home.home',compact("products","packages","productcart","packagecart"));
    }

    public function removePackageFromCart(Request $request){
        $id = $request->package->id;
        $productcart = Session::get('productcart'); 
        $packagecart = Session::get('packagecart');
        
        $products = $this->productService->getListProduct();
        $packages = $this->packageService->getListPackage();

        foreach ($packagecart as $key => $package) {
            if ($package['id'] == $id) {
                unset($packagecart[$key]);
            }
        }
        Session::put('packagecart', $packagecart);

        return view('home.home',compact("products","packages","productcart","packagecart"));
    }

    public function insertPackageToCart(Request $request){
        $package = $request->package;
        // dd($package);
        $packagePrice = $this->packageService->caculatePrice($request);
        $package->price = $packagePrice;
        $productcart = Session::get('productcart'); 
        $packagecart = Session::get('packagecart'); 
        // dd($carts);

        $products = $this->productService->getListProduct();
        $packages = $this->packageService->getListPackage();

        $packageIds = array_map(function ($package) {
            return $package['id'];
        }, $packagecart);

        if (in_array($package->id, $packageIds)) {

            return view('home.home',compact("products","packages","productcart","packagecart"));
        } else {
            $package->quantity = 1;
            array_push($packagecart, $package);
            Session::put('packagecart', $packagecart);

            // dd($packagecart);
    
            return view('home.home',compact("products","packages","productcart","packagecart"));
        }
    }

    public function payment(Request $request){
        $productcart = Session::get('productcart'); 
        $packagecart = Session::get('packagecart');
                        
        if(count($packagecart) > 0){
            $packagecart = $this->orderService->updateQuantityCart($packagecart, $request, 'quantity_package');
        }
        
        if(count($productcart) > 0){
            $productcart = $this->orderService->updateQuantityCart($productcart, $request, 'quantity_product');            
        }
        $order = $this->orderService->store($request);

        Session::put('productcart', []);
        Session::put('packagecart', []);
        
        $productcart = Session::get('productcart'); 
        $packagecart = Session::get('packagecart');

        $products = $this->productService->getListProduct();
        $packages = $this->packageService->getListPackage();
        return view('home.home',compact("products","packages","productcart","packagecart"));
    }

    public function destroy(Request $request){
     $this->orderService->destroy($request);
     
     $orders = $this->orderService->getOrders();

     $this->orderService->destroy($request);

     return view('orders.orders')->with("orders",$orders);

    }

    public function show(Request $request){
       $order = $request->order;

       $oder_details = $this->orderService->show($request);
       $productcart = $this->orderService->getProductFromOrder($request);
       $packagecart = $this->orderService->getPackageFromOrder($request);

       return view('orders.show',compact("productcart","packagecart","order"));
    }


}
