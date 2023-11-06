<?php

namespace App\Http\Controllers;
// use App\Http\Requests\Auth\Register;
use App\Http\Requests\Auth\register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Services\UserService;
use App\Services\PackageService;
use App\Services\ProductService;
use App\Services\AuthService;

// use Session;

class AuthController extends Controller
{

    protected UserService $userService;
    protected packageService $packageService;
    protected ProductService $productService;
    protected AuthService $authService;

    public function __construct(UserService $userService,ProductService $productService,PackageService $packageService,AuthService $authService) {
        $this->userService = $userService;
        $this->packageService = $packageService;
        $this->productService = $productService;
        $this->authService = $authService;
    }

    //
    public function index(){
        return view("auth.UserLogin");
    }


    public function Userlogin(Request $request)
    {
        if ($request->getMethod() == 'GET') {
            Auth::logout();
            return view('auth.Userlogin');
        }

        $credentials = $request->only(['email', 'password']);

        // $user = $this->userService->findUserByEmail($request);
        
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
            Auth::logout();
            return view('auth.Adminlogin');
        }
        
        $credentials = $request->only(['email', 'password']);
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('products.index');
        } else {
            return redirect()->back()->withInput()->withErrors(['error' => 'login failed']);
        }
    }

    public function registerFormUser(){
        return view("auth.register");
    }

    public function registerFormAdmin(){
        return view("auth.Adminregister");
    }

    public function adminRegister(Request $request){

        $user = $this->authService->adminRegister($request);
        // dd($user);
        if (empty($user)) return redirect('admin-form')->withErrors(['error' => 'Registration failed , try again']);
        return redirect('admin-login')->withSuccess('You are successfully register');
    }

    public function userRegister(Register $request){

        $user = $this->authService->userRegister($request);
        // dd($user);
        if (empty($user)) return redirect('user-form')->withErrors(['error' => 'Registration failed , try again']);
        return redirect('user-login')->withSuccess('You are successfully register');

    }

    public function logout(Request $request){
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Session::flush();
        Auth::logout();
        if(Auth::guard("admin")->check()){
            return redirect("admin-login");
        }else{
            return redirect("/");
        }
    }

}
