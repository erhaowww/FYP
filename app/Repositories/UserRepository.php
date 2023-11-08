<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function storeUser($data)
    {
        return User::create($data);
    }

    public function findUserByEmail($email)
    {
        return User::where(['email'=>$email])->first();
    }
}
