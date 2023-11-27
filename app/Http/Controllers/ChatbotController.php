<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;
use Throwable;
use App\Repositories\Interfaces\ChatbotRepositoryInterface;

class ChatbotController extends Controller
{
    private $chatbotRepository;

    public function __construct(ChatbotRepositoryInterface $chatbotRepository)
    {
        $this->chatbotRepository = $chatbotRepository;
    }

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

    public function indexFAQ(Request $request)
    {
        $faqs = $this->chatbotRepository->allFAQ();
        return view('admin/all-faq', compact('faqs'));
    }

    public function createFAQ(){
        return view('admin/add-faq');
    }

    public function storeFAQ(Request $req){
        $req->validate([
            'question' => 'required',
            'answer' => 'required'
        ]);

        $data = [
            'question' => $req->question,
            'answer' => $req->answer,
        ];
        $this->chatbotRepository->storeFAQ($data);
        return redirect()->route('faqs.index')->with('success', 'Successfully added a FAQ');
    }

    public function editFAQ($id){
        $faq = $this->chatbotRepository->findFAQ($id);
        return view('admin/edit-faq', compact('faq'));
    }

    public function updateFAQ(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required'
        ]);

        $data = [
            'question' => $request->question,
            'answer' => $request->answer,
        ];
        $this->chatbotRepository->updateFAQ($data, $id);

        return redirect()->route('faqs.index')->with('success', 'Information has been updated');
    }

    public function destroyFAQ($id)
    {
        $this->chatbotRepository->destroyFAQ($id);
        return redirect()->route('faqs.index')->with('success', 'Information has been deleted');
    }
}
