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
        return view('home.home',compact("products","packages"));
    }

    public function orders(){
        $orders = $this->orderService->getOrders();
        // dd($orders);
        return view('orders.orders')->with("orders",$orders);
    }

    public function insertProductToCart(Request $request){
        $product = $request->product;
        $productcart = Session::get('productcart'); 
        $this->orderService->addToCart($product, $productcart, 'productcart', 'id');
    
        return view('home.home', [
            'products' => $this->productService->getListProduct(),
            'packages' => $this->packageService->getListPackage(),
            'productcart' => Session::get('productcart'),
            'packagecart' => Session::get('packagecart'),
        ]);     
    }

    public function insertPackageToCart(Request $request){
        $package = $request->package;
        $packagePrice = $this->packageService->caculatePrice($request);
        $package->price = $packagePrice;
        $packagecart = Session::get('packagecart'); 
        
        $this->orderService->addToCart($package, $packagecart, 'packagecart', 'id');
        
        return view('home.home', [
            'products' => $this->productService->getListProduct(),
            'packages' => $this->packageService->getListPackage(),
            'productcart' => Session::get('productcart'),
            'packagecart' => Session::get('packagecart'),
        ]);     
    }
    
    public function removeProductFromCart(Request $request){
        $id = $request->product->id;
        $productcart = Session::get('productcart'); 

        $this->orderService->removeItemFromCart($id, $productcart, 'productcart');

        return view('home.home', [
            'products' => $this->productService->getListProduct(),
            'packages' => $this->packageService->getListPackage(),
            'productcart' => Session::get('productcart'),
            'packagecart' => Session::get('packagecart'),
        ]);    
    }

    public function removePackageFromCart(Request $request){
        $id = $request->package->id;
        $packagecart = Session::get('packagecart');

        $this->orderService->removeItemFromCart($id, $packagecart, 'packagecart');

        return view('home.home', [
            'products' => $this->productService->getListProduct(),
            'packages' => $this->packageService->getListPackage(),
            'productcart' => Session::get('productcart'),
            'packagecart' => Session::get('packagecart'),
        ]);
    }

    public function payment(Request $request){
        $data = json_decode($request->getContent(), true);
        dd(json_decode($request->getContent()));
        
        $productcart = Session::get('productcart'); 
        if(!empty($productcart)){
            $productcart = $this->orderService->updateQuantityCart($productcart, $request, 'quantity_product');            
        }
        
        $packagecart = Session::get('packagecart');
        if(!empty($packagecart)){
            $packagecart = $this->orderService->updateQuantityCart($packagecart, $request, 'quantity_package');
        }
        $this->orderService->store($request);

        return redirect()->route('home.index');
    }

    public function destroy(Request $request){
     $this->orderService->destroy($request);

     return redirect()
     ->route('orders.index')
     ->with('success', 'Order deleted successfully');
    }

    public function show(Request $request){
       $order = $request->order;
       $productcart = $this->orderService->getProductFromOrder($request);
       $packagecart = $this->orderService->getPackageFromOrder($request);

       return view('orders.show',compact("productcart","packagecart","order"));
    }

}
