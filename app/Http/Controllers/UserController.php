<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $search = $request['search'] ?? "";
        $users = $this->userService->index($request);
        $data = compact("users","search");
        return view('user.table')->with($data);
    }

    public function edit(request $request)
    {
        $user = $request->user;
        // dd($user);
        return view('user.edit',compact('user'));
    }

    public function update(request $request)
    {
        $this->userService->update($request);
        // return view('user.edit',compact('user'));
        return redirect()->route('users.index')->with('success', $request->user->name." updated successfully");  

    }

}