<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Facades\MCP;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind MCPHandler into the service container
        $this->app->singleton('mcp', function () {
            return new \App\MCP\MCPHandler();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ Register MCP Tool to call Ollama's TinyLLaMA and return clean text
        MCP::tool('AskLLM', function ($input) {
            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json'
                ])
                ->timeout(120) // ⏳ Wait up to 2 minutes for long responses
                ->post('http://host.docker.internal:11434/api/generate', [
                    'model'  => 'tinyllama',
                    'prompt' => $input
                ]);

                // Log HTTP status and raw NDJSON
                Log::info('AskLLM response status: ' . $response->status());
                Log::info('AskLLM raw NDJSON: ' . $response->body());

                // Parse NDJSON (Newline Delimited JSON) into a single string
                $lines = explode("\n", trim($response->body()));
                $finalText = '';

                foreach ($lines as $line) {
                    if (empty($line)) continue; // skip blank lines
                    $json = json_decode($line, true);
                    if (isset($json['response'])) {
                        $finalText .= $json['response'];
                    }
                }

                return trim($finalText);

            } catch (\Exception $e) {
                // Log the exception for debugging
                Log::error('AskLLM request failed: ' . $e->getMessage());

                // Fallback fake response so testing can continue
                return "⚠️ LLM request failed: " . $e->getMessage();
            }
        });
    }
}
