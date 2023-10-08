<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\NewsController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/news', NewsController::class);
    Route::get('/comments', [NewsController::class, 'indexComments']);
    Route::post('/news/{news}/comments', [NewsController::class, 'storeComments']);
});

