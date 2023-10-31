<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
    }

    public function store($request) {
        $user = Session::get('user');
        // dd($user);
        $productList =$request->productList;
        $packageList =$request->packageList;
        $storedTotalPrice =$request->storedTotalPrice;


        $payload = [
            "user_name"=>$user->name,
            "user_id"=>$user->id,
            'price'=> $storedTotalPrice,
        ];


        $order = $this->orderRepository->store($payload);

        foreach ($productList as $product) {
            $this->orderRepository->storeProductCart($order, $product);
        }

        foreach ($packageList as $package) {
            $this->orderRepository->storePackageCart($order, $package);
        }
    }

    public function getOrders(){
        return $this->orderRepository->getOrders();
    }

    function updateQuantityCart($cart,Request $request, $quantityKey) {
        if (count($request->$quantityKey) > 0) {
            foreach ($request->$quantityKey as $itemId => $newQuantity) {
                if (isset($cart[$itemId])) {
                    $cart[$itemId]['quantity'] = $newQuantity;
                }
            }
        }
        return $cart;
    }

    public function destroy(Request $request){
        $order = $request->order;
        return $this->orderRepository->destroy($order);
    }

    public function show(Request $request){
        $order = $request->order;
        return $this->orderRepository->show($order);
    }

    public function getProductFromOrder(Request $request){
        $order = $request->order;
        return $this->orderRepository->getProductFromOrder($order->id);
    }

    public function getPackageFromOrder(Request $request){
        $order = $request->order;
        return $this->orderRepository->getPackageFromOrder($order->id);
    }

    public function removeItemFromCart($id, &$cart, $cartKey) {
        foreach ($cart as $key => $item) {
            if ($item['id'] == $id) {
                unset($cart[$key]);
            }
        }
        Session::put($cartKey, $cart);
    }

    public function addToCart($item, $cart, $cartKey, $itemKey) {
        $cartIds = array_map(fn($item) => $item['id'], $cart);
    
        if (!in_array($item->$itemKey, $cartIds)) {
            $item->quantity = 1;
            array_push($cart, $item);
            Session::put($cartKey, $cart);
        }
    }
    
}