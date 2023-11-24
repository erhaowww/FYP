<?php
namespace App\Repositories\Interfaces;

Interface UserRepositoryInterface{
    public function allUser();
    public function findUser($id);
    public function storeUser($data);
    public function updateUser($data, $id); 
    public function findUserByEmail($email);
    public function password_reset($data); 
    public function edit_password($data, $id); 
    public function destroyUser($id);

}