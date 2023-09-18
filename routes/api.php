<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\ShowListController;

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


Route::get('/', [ShowListController::class, 'index']);
Route::get('/index', [ShowListController::class, 'index']);
Route::get('/page/{page}', [ShowListController::class, 'indexPages'])->name('nextpage');
Route::get('/character/detail/{actorId}', [ShowListController::class, 'characterDetail'])->name('actorDetail');
Route::get('/dashboard', [ShowListController::class, 'dashBoard'])->name('dashBoard');
