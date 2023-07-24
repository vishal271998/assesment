<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login']);


//Route::middleware('auth:sanctum')->group(function () {
    Route::get('candidates', [CandidateController::class, 'index']);
    Route::get('candidates/search', [CandidateController::class, 'search']);
    Route::post('candidates', [CandidateController::class, 'store']);
//});

