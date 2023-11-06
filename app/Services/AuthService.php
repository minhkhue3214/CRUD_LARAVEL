<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Repositories\authRepository;
use Illuminate\Support\Facades\DB;

class AuthService
{
    protected AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository) {
        $this->authRepository = $authRepository;
    }

    public function adminRegister(Request $request){
        // dd($request->input('password'), $request->input('repassword'));
        if($request->input("password") != $request->input("repassword")){
            // return redirect('register')->withErrors(['error' => 'Your repassword and password are not match']);
            return null;
        }


        $payload = [
            'name'=> $request->input('name'),
            'email'=> $request->input('email'),
            'password'=> Hash::make($request->password),
        ];

        return $this->authRepository->adminRegister($payload);
    }

    public function userRegister(Request $request){
        // dd($request->input('password'), $request->input('repassword'));
        if($request->input("password") != $request->input("repassword")){
            // return redirect('register')->withErrors(['error' => 'Your repassword and password are not match']);
            return null;
        }


        $payload = [
            'name'=> $request->input('name'),
            'email'=> $request->input('email'),
            'password'=> Hash::make($request->password),
        ];

        return $this->authRepository->userRegister($payload);
    }
    
}