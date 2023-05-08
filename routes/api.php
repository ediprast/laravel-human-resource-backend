<?php

use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\ResponsibilityController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('employee', [EmployeeController::class, 'fetch'])->middleware('auth:sanctum');
Route::post('employee', [EmployeeController::class, 'create'])->middleware('auth:sanctum');
Route::post('employee/update/{id}', [EmployeeController::class, 'update'])->middleware('auth:sanctum');
Route::delete('employee/{id}', [EmployeeController::class, 'delete'])->middleware('auth:sanctum');

Route::get('responsibility', [ResponsibilityController::class, 'fetch'])->middleware('auth:sanctum');
Route::post('responsibility', [ResponsibilityController::class, 'create'])->middleware('auth:sanctum');
Route::delete('responsibility/{id}', [ResponsibilityController::class, 'delete'])->middleware('auth:sanctum');

Route::get('role', [RoleController::class, 'fetch'])->middleware('auth:sanctum');
Route::post('role', [RoleController::class, 'create'])->middleware('auth:sanctum');
Route::post('role/update/{id}', [RoleController::class, 'update'])->middleware('auth:sanctum');
Route::delete('role/{id}', [RoleController::class, 'delete'])->middleware('auth:sanctum');

Route::get('team', [TeamController::class, 'fetch'])->middleware('auth:sanctum');
Route::post('team', [TeamController::class, 'create'])->middleware('auth:sanctum');
Route::post('team/update/{id}', [TeamController::class, 'update'])->middleware('auth:sanctum');
Route::delete('team/{id}', [TeamController::class, 'delete'])->middleware('auth:sanctum');

Route::get('company', [CompanyController::class, 'fetch'])->middleware('auth:sanctum');
Route::post('company', [CompanyController::class, 'create'])->middleware('auth:sanctum');
Route::post('company/update/{id}', [CompanyController::class, 'update'])->middleware('auth:sanctum');

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');;
Route::get('user', [UserController::class, 'fetch'])->middleware('auth:sanctum');;
