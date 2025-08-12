<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Facades\MCP;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ LLM JSON API Route
Route::get('/ask-llm', function (\Illuminate\Http\Request $request) {
    $prompt = $request->query('prompt', 'Hello from Laravel');
    $response = MCP::callTool('AskLLM', $prompt);

    return response()->json([
        'prompt'   => $prompt,
        'response' => $response
    ]);
});

// ✅ LLM Chat UI Routes
Route::get('/chat', function () {
    return view('chat');
});

Route::post('/chat', function (\Illuminate\Http\Request $request) {
    $prompt = $request->input('prompt', '');
    $response = MCP::callTool('AskLLM', $prompt);

    return view('chat', [
        'prompt'   => $prompt,
        'response' => $response
    ]);
});

require __DIR__ . '/auth.php';
