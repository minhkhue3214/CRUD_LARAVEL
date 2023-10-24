<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        // dd($request->query());
        try {
        $search = $request['search'] ?? "";
        return $this->userRepository->index($search);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function findUserByEmail(Request $request) {
        // dd($request->only('email'));
        $email = $request->only('email');
        $payload = [
            'email'=> $email,
        ];

        return $this->userRepository->findUserByEmail($payload);
    }

    public function update(Request $request) {
        // dd($request);
        $payload = [
            "id"=>$request->user->id,
            'name'=> $request->input('name'),
            'email'=> $request->input('email'),
            'role'=> $request->input('role'),
        ];

        return $this->userRepository->update($payload);
    }

    
}