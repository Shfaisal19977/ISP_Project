<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logincon; // Import the UserAuthController class
use App\Http\Controllers\PasswordController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/Login/VerificationRequest', [logincon::class, 'initiateLogin']);
Route::post('/Login/VerificationCode', [logincon::class, 'verifyLogin']);
Route::middleware('auth:sanctum')->post('Logout', [logincon::class, 'logout'])->name('logout');
Route::post('/Reset/Password', [PasswordController::class, 'resetPassword']);
