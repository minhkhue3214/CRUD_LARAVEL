<?php

namespace App\Http\Controllers;
use App\Http\Requests\Auth\Register;
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
        return view("auth.UserLogin");
    }


    public function Userlogin(Request $request)
    {
        if ($request->getMethod() == 'GET') {
            return view('auth.Userlogin');
        }
        $credentials = $request->only(['email', 'password']);

        $user = $this->userService->findUserByEmail($request);
        Session::put('user', $user);
        
        if (Auth::attempt($credentials)) {
            // dd("just sad");
            return redirect()->route('index');
        } else {
            return redirect()->back()->withInput()->withErrors(['error' => 'login failed']);
        }
    }

    public function Adminlogin(Request $request)
    {
        if ($request->getMethod() == 'GET') {
            return view('auth.Adminlogin');
        }
        
        $credentials = $request->only(['email', 'password']);
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('products.index');
        } else {
            return redirect()->back()->withInput()->withErrors(['error' => 'login failed']);
        }
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
            return redirect('user-login')->withSuccess('You are successfully register');
        }
    }

    public function logout(){
        if(Auth::guard("admin")->check()){
            Session::flush();
            Auth::logout();
            return redirect("admin-login");
        }else{
            Session::flush();
            Auth::logout();
            return redirect("/");
        }
    }

}
