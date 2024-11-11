<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    protected $openAIKey;
    protected $openAIEndpoint;

    public function __construct()
    {
        $this->openAIKey = env('OPENAI_API_KEY');
        $this->openAIEndpoint = 'https://api.openai.com/v1/completions';
    }

    public function chat(Request $request)
    {

        return view('chat');
        // $client = new Client();

        // $response = $client->post($this->openAIEndpoint, [
        //     'headers' => [
        //         'Content-Type' => 'application/json',
        //         'Authorization' => 'Bearer ' . $this->openAIKey,
        //     ],
        //     'json' => [
        //         'model' => 'text-davinci-003',
        //         'prompt' => $request->input('prompt'),
        //         'max_tokens' => 150,
        //         'temperature' => 0.7,
        //         'stop' => ['\n']
        //     ],
        // ]);

        // return $response->getBody()->getContents();
    }
    public function submitChat(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $request->prompt
                    ]
                ],
                'max_tokens' => 1000,
                'temperature' => 0.7,
            ]);

            return response()->json([
                'success' => true,
                'data' => $response['choices'][0]['message']['content']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
