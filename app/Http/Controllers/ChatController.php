<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatController extends Controller
{
    public function showStoryForm()
    {
        // Display the story input form
        return view('story-form');
    }

    public function generateStory(Request $request)
    {
        // Retrieve user input: book name and description
        $bookName = $request->input('book_name');
        $description = $request->input('description');                                                                                    $var='https://api.groq.com/openai/v1/chat/completions';

        // Groq Cloud API request to generate the story
        $client = new Client();

        try {
            $response = $client->post($var, [










                'headers' => [
                    'Authorization' => 'Bearer ' . env('PYTHON'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'llama3-8b-8192',  // Specify the desired model
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a creative book author.'],
                        ['role' => 'user', 'content' => "Write a full storybook. The book name is '$bookName' and it is about '$description'."],
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 2048,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $storyContent = $data['choices'][0]['message']['content'] ?? 'Sorry, unable to generate the story at this time.';

            // Pass the story content back to the view
            return view('story-output', [
                'bookName' => $bookName,
                'storyContent' => $storyContent
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate story: ' . $e->getMessage());
        }
    }
}
