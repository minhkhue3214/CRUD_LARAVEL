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
        $listPackage = $this->packageService->getListPackage();
        $packages = $this->packageService->caculateListPackage($listPackage);

        return view('home.home',compact("products","packages"));
    }

    public function orders(){
        $orders = $this->orderService->getOrders();
        // dd($orders);
        return view('orders.orders')->with("orders",$orders);
    }

    public function payment(Request $request) {
        $this->orderService->store($request);

        return "Success";
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
       $listPackage = $this->orderService->getPackageFromOrder($request);
       $packagecart = $this->packageService->caculateListPackage($listPackage);

       return view('orders.show',compact("productcart","packagecart","order"));
    }

}
