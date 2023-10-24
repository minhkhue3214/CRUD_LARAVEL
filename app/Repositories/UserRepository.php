<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index($search){
        // dd($search);
        if($search != ""){
           return $this->model->where("name","LIKE","%$search%")->orderBy('created_at', 'DESC')->paginate(5);
        }else{
           return $this->model->orderBy('created_at', 'DESC')->paginate(5); 
        }
    }

    public function findUserByEmail($payload) {

        $user = $this->model->where('email', $payload['email'])->first();
        // dd($user);
        return $user;
    }

    public function update($payload) {
        // dd($payload);
        // dd($this->model->find($payload['id']));
        return $this->model->find($payload['id'])->update([
            'name'=> $payload['name'],
            'email'=> $payload['email'],
            'role'=> $payload['role'],
        ]);
    }
}
