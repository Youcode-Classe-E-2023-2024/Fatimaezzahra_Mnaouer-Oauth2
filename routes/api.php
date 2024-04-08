<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\userController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Middleware\Authenticate;

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

Route::get('debug', function () {
    $user = \App\Models\User::find(7);
    dd($user->role->first()->toArray());
});

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth:api')->group(function () {
    /* Auth */
    Route::post('/logout', [AuthController::class,'logout']);
    Route::apiResource('/forget',ForgotPasswordController::class);
    Route::get('/user', function (Request $request) {return $request->user();});

    /* Role */
    Route::apiResource('/role',RoleController::class);
    Route::post('/role/{user_id}',[RoleController::class, 'assignRole']);

    /* PERMISSION */
    Route::apiResource('/permission',PermissionController::class);
    Route::post('/permission/{role_id}',[PermissionController::class, 'assignPermission']);

    /* USER */
    Route::post('/users', [UserController::class, 'addUser']);
    Route::put('/users/{id}', [UserController::class, 'editUser']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
});
