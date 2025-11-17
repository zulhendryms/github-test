<?php

use App\Http\Controllers\GithubController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/github/repos', [GithubController::class, 'repos']);
