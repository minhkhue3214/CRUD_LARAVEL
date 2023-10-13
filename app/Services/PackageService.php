<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\ProductRepository;

class PackageService
{
    protected ProductRepository $packageRepo;

    public function __construct(ProductRepository $packageRepo) {
        $this->packageRepo = $packageRepo;
    }

    public function create(Request $request) {
        dd($request);
    }

    public function update(Request $request) {

    }

    public function delete(Request $request){

    }
}