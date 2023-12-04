<?php

namespace App\Repositories;

use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function allNotification()
    {
        return Notification::where('deleted_at', 0)
        ->get();
    }

    public function storeNotification($data)
    {
        return Notification::create($data);
    }

    public function findNotification($id)
    {
        return Notification::where('deleted_at', 0)->find($id);
    }

    public function findSpecificNotification($user_id)
    {
        return Notification::where('deleted_at', 0)
        ->where('user_id', $user_id)
        ->orderBy('id', 'desc')
        ->get();
    }

    public function getUserUnreadCount($user_id)
    {
        return Notification::where('deleted_at', 0)
        ->where('user_id', $user_id)
        ->whereNull('read_at')
        ->count();
    }

    public function updateNotificationReadAt($id)
    {
        $notification = Notification::where('id', $id)->first();
        $notification->read_at = now();
        $notification->save();
    }

    public function destroyNotification($id)
    {
        $notification = Notification::find($id);
        $notification->deleted_at = 1;
        $notification->save();
    }
}
