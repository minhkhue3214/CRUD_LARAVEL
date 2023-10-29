<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;

class ProductService
{
    protected ProductRepository $productRepo;

    public function __construct(ProductRepository $productRepo) {
        $this->productRepo = $productRepo;
    }

    // public function index(Request $request)
    // {
    //     $search = $request['search'] ?? "";
    //     return $this->productRepo->index($search);
    // }
    public function index(Request $request)
    {
        // dd($request->query());
        try {
        $search = $request['search'] ?? "";
        return $this->productRepo->index($search);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function getListProduct(){
        return $this->productRepo->getListProduct();
    }

    // public function Store(Request $request) {
    //     $payload = [
    //         'title'=> $request->input('title'),
    //         'price'=> $request->input('price'),
    //         'product_code'=> $request->input('product_code'),
    //         'description'=> $request->input('description'),
    //     ];

    //     return $this->productRepo->store($payload);
    // }

    public function Store(Request $request) {
        try{
            if($request->has('image')){
                $file = $request->image;
                $extension = $request->image->extension();
                // $file_name = $file->getClientoriginalName();
                $file_name = time().'-'.'product.'. $extension;
                // dd($file_name);
                $file->move(public_path('uploads'),$file_name); 
                $request->merge(['image'=>'/uploads/'.$file_name]);
                // dd($extension);
            }
            
            $payload = [
                'title'=> $request->input('title'),
                'price'=> $request->input('price'),
                'image'=> $request->input('image'),
                'product_code'=> $request->input('product_code'),
                'description'=> $request->input('description'),
            ];

            // dd($payload);
            return $this->productRepo->store($payload);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return null;
        }
    }

    public function update(Request $request) {
        // dd($request->product->image);

        if($request->has('image')){
            $file = $request->image;
            $extension = $request->image->extension();
            // $file_name = $file->getClientoriginalName();
            $file_name = time().'-'.'product.'. $extension;
            // dd($file_name);
            $file->move(public_path('uploads'),$file_name); 
            $request->merge(['image'=>'/uploads/'.$file_name]);
            // dd($extension);
            $payload = [
                "id"=>$request->product->id,
                'title'=> $request->input('title'),
                'price'=> $request->input('price'),
                'image'=> $request->input('image'),
                'product_code'=> $request->input('product_code'),
                'description'=> $request->input('description'),
            ];
        }else{
            $payload = [
                "id"=>$request->product->id,
                'title'=> $request->input('title'),
                'price'=> $request->input('price'),
                'image'=> $request->product->image,
                'product_code'=> $request->input('product_code'),
                'description'=> $request->input('description'),
            ];
        }

        return $this->productRepo->update($payload);
    }

    public function delete(Request $request){
        // dd($request->product->id);
        return $this->productRepo->delete($request->product->id);
    }

    public function productInPackage($productsRelation){
        // dd($productsRelation);
        foreach ($productsRelation as $item) {
           $productPackageIds[] = $item['product_id'];
        }
        // dd($request->product->id);
        return $this->productRepo->productInPackage($productPackageIds);
    }

    public function priceInPackage($productsRelation){
            // dd($productsRelation);
            foreach ($productsRelation as $item) {
                $productPackageIds[] = $item['product_id'];
             }
             // dd($request->product->id);
             return $this->productRepo->productInPackage($productPackageIds);
    }

}