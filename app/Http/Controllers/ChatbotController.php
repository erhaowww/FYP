<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;
use Throwable;

class ChatbotController extends Controller
{
    public function sendChat(Request $request) {
        try {
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . config('openai.api_key')
            ])->post('https://api.openai.com/v1/chat/completions', [
                "model" => 'gpt-3.5-turbo',
                "messages" => [
                    [
                        "role" => "user",
                        "content" => $request->input
                    ]
                ],
                "temperature" => 0,
                "max_tokens" => 100
            ])->body();
            return response()->json(json_decode($response));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Chat GPT Limit Reached. This means too many people have used this demo this month and hit the FREE limit available. You will need to wait, sorry about that.'], 401);
        }
    }
}
