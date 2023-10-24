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

    public function store(Request $request) {
        // dd($request);
        $user = Session::get('user');
        $total = 0;
        // Duyệt qua mảng và tính tổng
        foreach ($request->price as $number) {
            $total += $number;
        }

        $payload = [
            "user_name"=>$user->name,
            "user_id"=>$user->id,
            'price'=> $total,
        ];

        return $this->orderRepository->store($payload);
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
    
}