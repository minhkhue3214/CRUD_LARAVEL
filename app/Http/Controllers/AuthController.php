<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Services\UserService;
use App\Services\PackageService;
use App\Services\ProductService;

// use Session;

class AuthController extends Controller
{

    protected UserService $userService;
    protected packageService $packageService;
    protected ProductService $productService;

    public function __construct(UserService $userService,ProductService $productService,PackageService $packageService) {
        $this->userService = $userService;
        $this->packageService = $packageService;
        $this->productService = $productService;
    }

    //
    public function index(){
        return view("auth.login");
    }

    public function postLogin(Request $request){
        $request->validate([
            "email" =>"required|email",
            "password" =>"required",  
        ]);

        $checkLoginCredentials = $request->only('email','password');
        
        if(Auth::attempt($checkLoginCredentials)){
            $user = $this->userService->findUserByEmail($request);
            Session::put('user', $user);
            // session_start();
            $productcart = [];
            $packagecart = [];
            Session::put('productcart', $productcart);
            Session::put('packagecart', $packagecart);

            if($user->role == 'admin'){
                $products = $this->productService->getListProduct();
                $packages = $this->packageService->getListPackage();

                return view('home.home',compact("products","packages","productcart","packagecart")); 
            }else{
                return redirect('products')->withSuccess('You are successfully loggedin'); 
            }

        }

        return redirect('login')->withErrors(['error' => 'Your email and password are not match']);
    }

    public function register(){
        return view("auth.register");
    }

    public function postRegister(Request $request){
        $request->validate([
            "name" =>"required",
            "email" =>"required|email",
            "password" =>"required",  
            "repassword" =>"required",  
        ]);

        if($request->input("password") != $request->input("repassword")){
            return redirect('register')->withErrors(['error' => 'Your repassword and password are not match']);
        }

        if(!empty($user)){

            return redirect('register')->withErrors(['error' => 'Registration failed , try again']);
        }else{
            $data["name"] = $request->name;
            $data["email"] = $request->email;
            $data["password"] = Hash::make($request->password);
            $user = User::create($data);
            // dd($data);
            return redirect('login')->withSuccess('You are successfully register');
        }
    }
    
    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect("home");
    }

    public function dashboard(){
        // dd(Auth::check());
        if(Auth::check()){
            return view('dashboard');
        }
        return redirect('login')->withSuccess('Please login to access the dashboard page');
    }

}
