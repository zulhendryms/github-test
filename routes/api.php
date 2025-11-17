<?php
// not go this way!!
// route still in web.php

use App\Http\Controllers\GithubController;
use Illuminate\Support\Facades\Route;

Route::get('/github/repos', [GithubController::class, 'repos']);
dd(3);