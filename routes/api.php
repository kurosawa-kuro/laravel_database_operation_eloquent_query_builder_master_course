<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('hello_list', function () {
//    abort(500);
    $data = [
        'data'=>
        [
            'id' => 1,
            'first' => 'abc',
            'second' => 'efg',
            'third' => 'hig',],
        [
            'id' => 2,
            'first' => 'lfm',
            'second' => 'opq',
            'third' => 'rst',]
    ];

    return response()->json($data);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [\App\Http\Controllers\AuthController::class, 'user']);

    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);

    Route::get('protected_hello_list', function () {
        return [
            'first' => 'ABC',
            'second' => 'EFG',
            'third' => 'HIG',
        ];
    });

    Route::apiResource('users', \App\Http\Controllers\UserController::class);

//    Route::post('upload', [ImageController::class, 'upload']);
});

Route::get('tests', [\App\Http\Controllers\TestController::class, 'test']);

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
