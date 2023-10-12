<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;

// use Session;

class AuthController extends Controller
{
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
        // dd(Auth::attempt($checkLoginCredentials));
        // dd($checkLoginCredentials);
        if(Auth::attempt($checkLoginCredentials)){
            return redirect('products')->withSuccess('You are successfully loggedin');
        }

        return redirect('login')->withErrors(['error' => 'Your email and password are not match']);
    }
    
    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect("login");
    }

    public function dashboard(){
        // dd(Auth::check());
        if(Auth::check()){
            return view('dashboard');
        }
        return redirect('login')->withSuccess('Please login to access the dashboard page');
    }

}
