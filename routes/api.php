<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LLMController;



Route::post('/ask', [LLMController::class, 'ask']);
Route::get('/test-mcp', [LLMController::class, 'testMCP']);


