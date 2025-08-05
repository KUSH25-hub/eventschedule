<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LLMController;

Route::post('/llm/prompt', [LLMController::class, 'prompt']);


