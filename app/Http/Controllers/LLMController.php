<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Facades\MCP;

class LLMController extends Controller
{
    // Handles request to TinyLlama through Ollama
    public function ask(Request $request)
    {
        // Validate prompt input
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $prompt = $request->input('prompt');

        // Call Ollama API
        $response = Http::post('http://localhost:11434/api/generate', [
            'model' => 'tinyllama',
            'prompt' => $prompt,
            'stream' => false
        ]);

        // Return result or error
        if ($response->successful()) {
            return response()->json([
                'response' => $response->json()['response']
            ]);
        } else {
            return response()->json([
                'error' => 'LLM request failed.',
                'details' => $response->body()
            ], 500);
        }
    }

    // Uses custom MCP class via Facade
    public function testMCP()
    {
        $input = "hello";
        $output = MCP::reply($input);

        return response()->json([
            'response' => $output
        ]);
    }
}
