<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\PackageRepository;

class PackageService
{
    protected PackageRepository $packageRepo;

    public function __construct(PackageRepository $packageRepo) {
        $this->packageRepo = $packageRepo;
    }

    public function index(Request $request) {
        $search = $request['search'] ?? "";
        return $this->packageRepo->index($search);
    }

    public function getListPackage(){
        return $this->packageRepo->getListPackage();
    }

    public function show(Request $request){
        // dd($request->package->id);

       return $this->packageRepo->show($request->package->id);
    }

    public function caculatePrice(Request $request){
        return $this->packageRepo->caculatePrice($request->package->id);
    }

    public function store(Request $request) {
        // dd($request);
        $payload = [
            "product_list"=>$request->input("product_list"),
            'package_name'=> $request->input('package_name'),
            'package_description'=> $request->input('package_description'),
        ];

        return $this->packageRepo->store($payload);
    }


    public function update(Request $request) {
        $payload = [
            "id"=>$request->package->id,
            'name'=> $request->input('package_name'),
            'description'=> $request->input('package_description'),
            'product_list'=> $request->input('product_list'),
        ];

        return $this->packageRepo->update($payload);
    }

    public function delete(Request $request){
        // dd($request->package->id);
        return $this->packageRepo->delete($request->package->id);
    }
}