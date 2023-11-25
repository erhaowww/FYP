<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PusherBroadcast;

class ChatController extends Controller
{
    public function index() {
        return view('admin/chat');
    }

    public function requestLiveChat() {
        event(new PusherBroadcast('Live chat request', 'my-channel', 'my-event'));
        return response()->json(['message' => 'Live chat request dispatched']);
    }
}
