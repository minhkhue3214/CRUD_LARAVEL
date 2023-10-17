<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\ProductRelationRepository;

class ProductRelationService
{
    protected ProductRelationRepository $productRelationRepo;

    public function __construct(ProductRelationRepository $productRelationRepo) {
        $this->productRelationRepo = $productRelationRepo;
    }

    public function productsRelation(Request $request)
    {
        return $this->productRelationRepo->productsRelation($request->package->id);
    }

    public function getSelectedProduct(Request $request){
        // dd($request->package->id);
        $selectedProduct = $this->productRelationRepo->getSelectedProduct($request->package->id);
        // dd($selectedProduct);
        foreach ($selectedProduct as $product_id) {
            $productIds[] = $product_id['product_id'];
        }
        return $productIds;
    }

    public function store(Request $request,$Package) {
        $product_list = $request->product_list;

        $PackageId = $Package->id;
        foreach ($product_list as $product) {

            $payload = [
                'product_id'=>$product,
                'product_package_id'=> $PackageId,
            ];
            $this->productRelationRepo->store($payload);
        }
    }

    public function findProductById($product_package_id,$product_id){
        $payload = [
            'product_id'=>$product_id,
            'product_package_id'=> $product_package_id,
        ];

        return $this->productRelationRepo->findProductById($payload);
    }

    public function delete(Request $request){
        // dd($request->product->id);
        return $this->productRelationRepo->delete($request->product->id);
    }

    public function checkMoreProduct(Request $request){
        foreach($request->product_list as $productId){

            $productforpackage = $this->findProductById($request->package->id,$productId);

            if($productforpackage){
                //đã có sản phẩm trong gói sản phẩm
            }else{
                $payload = [
                    'product_id'=>$productId,
                    'product_package_id'=> $request->package->id,
                ];
        
                $this->productRelationRepo->store($payload);
            }
        }
    }
    public function unCheckProduct(Request $request,$productsRelation){
        // dd($request,$productsRelation);
        $id = $request->package->id;
        foreach ($productsRelation as $item) {
            $productPackageIds[] = $item['product_id'];
        }

        $diffIds = array_diff($productPackageIds,$request->product_list);

        // dd($diffIds);
        if(!empty($diffIds)){
            foreach($diffIds as $diffId){
                $payload = [
                    'product_id'=>$diffId,
                    'product_package_id'=> $id,
                ];
                $this->productRelationRepo->unCheckProduct($payload);
            }
        }
    }
}