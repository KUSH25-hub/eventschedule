<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LLMController extends Controller
{
    public function prompt(Request $request)
    {
        try {
            Log::info('LLM prompt hit');
            Log::info('Request payload:', $request->all());

            $prompt = $request->input('prompt');

            if (!$prompt) {
                return response()->json([
                    'answer' => "Sorry, I didn't understand the prompt."
                ]);
            }

            // Simulate LLM-like response (you can later connect OpenAI or event logic here)
            $answer = $this->getAnswerFromPrompt($prompt);

            return response()->json([
                'answer' => $answer
            ]);
        } catch (\Throwable $e) {
            Log::error('LLM prompt error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    // Simulated prompt handler
    private function getAnswerFromPrompt($prompt)
    {
        $prompt = strtolower($prompt);

        if (str_contains($prompt, 'how many events')) {
            // You can later replace this with a real Event::count() or query
            return "There are 5 events scheduled this week.";
        }

        if (str_contains($prompt, 'next event')) {
            return "The next event is on Thursday at 3 PM.";
        }

        if (str_contains($prompt, 'hello') || str_contains($prompt, 'hi')) {
            return "Hello! How can I assist you with events today?";
        }

        return "Sorry, I didn't understand the prompt.";
    }
}

