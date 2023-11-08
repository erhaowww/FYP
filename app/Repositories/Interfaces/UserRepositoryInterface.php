<?php
namespace App\Repositories\Interfaces;

Interface UserRepositoryInterface{
    public function storeUser($data);
    public function findUserByEmail($email);

}