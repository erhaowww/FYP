<?php
namespace App\Repositories\Interfaces;

Interface RewardRepositoryInterface{
    public function allReward();
    public function storeReward($data);
    public function findReward($id);
    public function userRewardHistory($userId);
    public function updateReward($data, $id);
    public function destroyReward($id);

}