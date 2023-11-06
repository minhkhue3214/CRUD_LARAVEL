<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
    }

    public function store($request) {
        // SQL transaction;
        DB::beginTransaction();
        try{
            $user = Auth::guard('web')->user();
            // dd($user->name);
    
            $productList =$request->productList;
            $packageList =$request->packageList;
            $storedTotalPrice =$request->storedTotalPrice;
    
            // "user_name"=>$user->name,
    
            $payload = [
                "user_name"=>$user->name,
                "user_id"=>$user->id,
                'price'=> $storedTotalPrice,
            ];
    
            $order = $this->orderRepository->store($payload);
    
            if(is_array($productList)){
                foreach ($productList as $product) {
                    $this->orderRepository->storeProductIntoOrder($order, $product);
                }
            }
    
            if(is_array($packageList)){
                foreach ($packageList as $package) {
                    $this->orderRepository->storePackageIntoOrder($order, $package);
                }
            }
            
        DB::commit();
        }catch(Exception $e){
            Log::error($e->getMessage());
        DB::rollback();
            return null;
        }

    }

    public function getOrders(){
        try {
            return $this->orderRepository->getOrders();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function destroy(Request $request){
        try {
            $order = $request->order;
            if ($order) {
                return $this->orderRepository->destroy($order);
            }        
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function show(Request $request){
        try {
            $order = $request->order;
            if ($order) {
                return $this->orderRepository->show($order);
            } 
                 
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function getProductFromOrder(Request $request){
        try {
            $order = $request->order;
            return $this->orderRepository->getProductFromOrder($order->id);     
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function getPackageFromOrder(Request $request){
        try {
            $order = $request->order;
            return $this->orderRepository->getPackageFromOrder($order->id); 
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
    
}