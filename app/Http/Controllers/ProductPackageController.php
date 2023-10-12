<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageProduct\Create;
use App\Http\Requests\PackageProduct\Update;
use App\Models\Product;
use App\Models\product_relationship;
use App\Models\ProductPackage;
use Illuminate\Http\Request;

class ProductPackageController extends Controller
{
    public function index(Request $request){
        $search = $request['search'] ?? "";
        if($search != ""){
            $packages = ProductPackage::where("package_name","LIKE","%$search%")->orderBy('created_at', 'DESC')->paginate(5);
        }else{
            $packages = ProductPackage::orderBy('created_at', 'DESC')->paginate(5); 
        }

        $data = compact("packages","search");
        return view('productspackage.table')->with($data);
    }

    public function create(Request $request)
    {
            $products = Product::orderBy('created_at', 'DESC')->get();
            $data = compact("products");
    
            return view('productspackage.create')->with($data);        
    }

    public function show($id)
    {
        $package = ProductPackage::findOrFail($id);
        $productsRelation = product_relationship::where('product_package_id', '=', $id)->get();

        foreach ($productsRelation as $item) {
           $productPackageIds[] = $item['product_id'];
        }

        // dd($productPackageIds);
        $products = Product::whereIn('id', $productPackageIds)->get();
        // dd($products);

        $data = compact("package","products");

        // dd($package);
        return view('productspackage.show')->with($data);
    }

    public function store(Create $request)
    {
        // dd($request->input('product_list'));

        $product_list = $request->input('product_list');

        //handle add product to database
        $Package = ProductPackage::create([
            'package_name'=> $request->input('package_name'),
            'package_description'=> $request->input('package_description'),
        ]);
        $PackageId = $Package->id;
        // dd($PackageId);

        foreach ($product_list as $product) {
            product_relationship::create([
                'product_id'=> $product ,
                'product_package_id'=> $PackageId,
            ]);
         }

        // dd($Package);

        return redirect()
        ->route('packages.index')
        ->with('success', 'Product Package added successfully');
    }

    public function destroy($id)
    {
        // dd($id);
        $Package = ProductPackage::findOrFail($id);
        $Package->delete();

        product_relationship::where("product_package_id", $id)->delete();
        return redirect()
        ->route('packages.index')
        ->with('success', 'Product Package deleted successfully');
    }

    public function edit($id)
    { 
        //lấy thông tin gói sản phẩm
        $package = ProductPackage::findOrFail($id);

        //lấy thông tin các sản phẩm
        $products = Product::orderBy('created_at', 'DESC')->get();

        $selectedProduct = product_relationship::where('product_package_id', $id)->get();
        // dd($selectedProduct->all());

        //Danh sách id các sản phẩm được chọn
        foreach ($selectedProduct as $product_id) {
            $productIds[] = $product_id['product_id'];
        }

        // dd($productIds);

        $data = compact("package","productIds","products");

        return view('productspackage.edit')->with($data);
    }

    public function update(Update $request, $id){
        // $package = ProductPackage::findOrFail($id);
        $productsRelation = product_relationship::where('product_package_id', '=', $id)->get();

        foreach ($productsRelation as $item) {
           $productPackageIds[] = $item['product_id'];
        }

        $diffIds = array_diff($productPackageIds,$request->product_list);

        // Kết quả sẽ là một mảng chứa các ID trong $array1 mà không có trong $array2
        // dd($diffIds);
        if(!empty($diffIds)){
            foreach($diffIds as $diffId){
                $product = product_relationship::where('product_package_id', $id)->where('product_id', $diffId)->first();
                $product->delete();
            }
        }

        // dd($productPackageIds);
        // dd($request->product_list);

        //product_list danh sách các sản phẩm trong gói
        foreach($request->product_list as $productId){
            $productforpackage = product_relationship::where('product_package_id', $id)->where('product_id', $productId)->first();
            if($productforpackage){
                //đã có sản phẩm trong gói sản phẩm
            }else{
                // dd($id,$productId);
                product_relationship::create([
                    'product_id'=> $productId,
                    'product_package_id'=> $id,
                ]);
            }
        }

        ProductPackage::where('id', $id)->update([
        'package_name'=> $request->input('package_name'),
        'package_description'=> $request->input('package_description'),
       ]);

       $packages = ProductPackage::orderBy('created_at', 'DESC')->paginate(5);
       // dd($products);
       $data = compact("packages");
        // dd($package);
        return view('productspackage.table')->with($data); 
    }

}
