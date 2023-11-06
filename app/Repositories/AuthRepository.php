<?php

namespace App\Repositories;
use App\Models\User;
use App\Models\UserAdmin;

class AuthRepository
{
    protected $model;
    protected $userAdmin;

    public function __construct()
    {
        $this->model = new User();
        $this->userAdmin = new UserAdmin();
    }

    public function userRegister($payload){
        return $this->model->create($payload);
    }
    public function adminRegister($payload){
        return $this->userAdmin->create($payload);
    }
}
