<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logincon; // Import the UserAuthController class
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IptvSubscriptionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\ChannelController;

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

Route::get('/bundles', [BundleController::class, 'index']);


Route::get('/', function (Request $request) {
    return response()->json(['message' => 'Login required'], 200);
})->name('unauthenticated');
Route::post('/Login/VerificationRequest', [logincon::class, 'initiateLogin']);
Route::post('/Login/VerificationCode', [logincon::class, 'verifyLogin']);
Route::middleware('auth:sanctum')->post('Logout', [logincon::class, 'logout'])->name('logout');
Route::post('/Reset/Password', [PasswordController::class, 'resetPassword']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user/subscribe', [SubscriptionController::class, 'subscribe']);
    Route::post('/user/extend-subscription', [SubscriptionController::class, 'extendSubscription']);
    Route::post('/user/change-speed', [SubscriptionController::class, 'changeSpeed']);
    Route::delete('/user/delete-subscription', [SubscriptionController::class, 'deleteSubscription']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::get('/users/Subscription/{user}', [UserController::class, 'getUserSubscription']);
    Route::get('/user/subscription-status/{user}', [SubscriptionController::class, 'getSubscriptionStatus']);
    Route::get('users/{userId}/service-type-name', [UserController::class, 'getServiceTypeName']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/iptv-subscriptions', [IptvSubscriptionController::class, 'create']);
    Route::get('/iptv-subscriptions/{id}', [IptvSubscriptionController::class, 'show']);
    Route::delete('/iptv-subscriptions-delete/{id}', [IptvSubscriptionController::class, 'delete']);
    Route::put('/iptv-subscriptions-update', [IptvSubscriptionController::class, 'update']);
});
Route::middleware('auth:sanctum')->get('/{id}', [NotificationController::class, 'getNotifications']);


Route::post('/create-payments', [PaymentController::class, 'createPayment']);
Route::get('/payments/{userId}', [PaymentController::class, 'getPayments']);
Route::delete('/payments-delete/{id}', [PaymentController::class, 'deletePayment']);
Route::put('/payments-update', [PaymentController::class, 'updatePayment']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/bundles/{id}', [BundleController::class, 'show']);
    Route::post('/store-bundles', [BundleController::class, 'store']);
    Route::put('/bundles-update/{id}', [BundleController::class, 'update']);
    Route::delete('/bundles-destroy/{id}', [BundleController::class, 'destroy']);
    Route::get('/channels/{category}', [ChannelController::class, 'getChannelsByCategory']);
    Route::post('/create-payments', [PaymentController::class, 'createPayment']);
    Route::get('/payments/{userId}', [PaymentController::class, 'getPayments']);
    Route::delete('/payments-delete/{id}', [PaymentController::class, 'deletePayment']);
    Route::put('/payments-update', [PaymentController::class, 'updatePayment']);
});
