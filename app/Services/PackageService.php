<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\PackageRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class PackageService
{
    protected PackageRepository $packageRepo;

    public function __construct(PackageRepository $packageRepo) {
        $this->packageRepo = $packageRepo;
    }

    public function index(Request $request) {
        try {
            $search = $request['search'] ?? "";
            return $this->packageRepo->index($search);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function getListPackage(){
        try {
            return $this->packageRepo->getListPackage();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function show(Request $request){
        // dd($request->package->id);
        try {
            return $this->packageRepo->show($request->package->id);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }

       
    }

    public function caculateListPackage($listPackage){
        foreach ($listPackage as &$package) {
            $id = $package['id'];
            $packagePrice = $this->caculatePrice($id);
            $package->price = $packagePrice;
        }
        return $listPackage;
    }

    public function caculatePrice($id){
        return $this->packageRepo->caculatePrice($id);
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            if($request->has('image')){
                $file = $request->image;
                $extension = $request->image->extension();
                // $file_name = $file->getClientoriginalName();
                $file_name = time().'-'.'package.'. $extension;
                // dd($file_name);
                $file->move(public_path('uploads'),$file_name); 
                $request->merge(['image'=>'/uploads/'.$file_name]);
                // dd($extension);
            }
    
            $payload = [
                "product_list"=>$request->input("product_list"),
                'package_name'=> $request->input('package_name'),
                'image'=> $request->input('image'),
                'package_description'=> $request->input('package_description'),
            ];
            DB::commit();
            return $this->packageRepo->store($payload);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return null;
        }
    }


    public function update(Request $request) {
        DB::beginTransaction();
        try {
        if($request->has('image')){
            $file = $request->image;
            $extension = $request->image->extension();
            // $file_name = $file->getClientoriginalName();
            $file_name = time().'-'.'product.'. $extension;
            // dd($file_name);
            $file->move(public_path('uploads'),$file_name); 
            $request->merge(['image'=>'/uploads/'.$file_name]);

            $payload = [
                "id"=>$request->package->id,
                'name'=> $request->input('package_name'),
                'description'=> $request->input('package_description'),
                'image'=> $request->input('image'),
                'product_list'=> $request->input('product_list'),
            ];
        }else{
            $payload = [
                "id"=>$request->package->id,
                'name'=> $request->input('package_name'),
                'description'=> $request->input('package_description'),
                'image'=> $request->package->image,
                'product_list'=> $request->input('product_list'),
            ];
        }

        DB::commit();
        return $this->packageRepo->update($payload);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return null;
        }
    }

    public function delete(Request $request){
        try {
            return $this->packageRepo->delete($request->package->id);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
}