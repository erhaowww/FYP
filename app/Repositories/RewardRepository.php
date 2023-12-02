<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RewardRepositoryInterface;
use App\Models\Reward;
use App\Models\RewardClaim;
use Illuminate\Support\Facades\Hash;

class RewardRepository implements RewardRepositoryInterface
{
    public function allReward()
    {
        return Reward::where('deleted_at', 0)
        ->get();
    }

    public function storeReward($data)
    {
        return Reward::create($data);
    }

    public function findReward($id)
    {
        return Reward::find($id);
    }

    public function userRewardHistory($userId)
    {
        return RewardClaim::with('reward')
            ->where('user_id', $userId)->get();
    }

    public function updateReward($data, $id)
    {
        $reward = Reward::where('id', $id)->first();
        $reward->name = $data['name'];
        $reward->description = $data['description'];
        $reward->image = $data['image'];
        $reward->points_required = $data['points_required'];
        $reward->quantity_available = $data['quantity_available'];
        $reward->save();
    }

    public function destroyReward($id)
    {
        $reward = Reward::find($id);
        $reward->deleted_at = 1;
        $reward->save();
    }
}
