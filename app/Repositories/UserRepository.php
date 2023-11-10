<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function allUser()
    {
        return User::where('deleted_at', 0)
        ->where('role', 'user')
        ->get();
    }

    public function storeUser($data)
    {
        return User::create($data);
    }

    public function updateUser($data, $id)
    {
        $user = User::where('id', $id)->first();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->gender = $data['gender'];
        $user->address = $data['address'];
        $user->role = $data['role'];
        if($data['image'] != ''){
            $user->image = $data['image'];
        }
        $user->phone_number = $data['phone_number'];
        $user->save();
    }

    public function destroyUser($id)
    {
        $user = User::find($id);
        $user->deleted_at = 1;
        $user->save();
    }

    public function findUser($id)
    {
        return User::find($id);
    }

    public function findUserByEmail($email)
    {
        return User::where(['email'=>$email])->first();
    }

    public function password_reset($data)
    {
        $user = User::where('email', $data['email'])->first();
        $user->password = Hash::make($data['password']);
        $user->save();
    }
}
