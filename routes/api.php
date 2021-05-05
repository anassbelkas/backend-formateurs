<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\ForgotPasswordController;
use App\Http\Controllers\auth\VerificationController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\TodoController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('create', [ForgotPasswordController::class, 'create']);
    Route::get('find/{token}', [ForgotPasswordController::class, 'find']);
    Route::post('reset', [ForgotPasswordController::class, 'reset']);
});

/*
Route::post('password/forgot', [ForgotPasswordController::class, 'forgot_password']);
Route::post('password/reset', [ForgotPasswordController::class, 'change_password']);
*/

Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name

Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::middleware('auth:api')->group(function () {
    Route::resource('formations', FormationController::class)->middleware('verified');

    Route::resource('todos', TodoController::class)->middleware('verified');

    Route::get('/logout', [AuthController::class, 'logout'])->middleware('verified');

    Route::get('/user', [AuthController::class, 'user'])->middleware('verified');
});
