<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/home',[HomeController::class,'index'])->middleware('auth');
Route::get('/datalist',[DataController::class,'show'])->middleware('auth');
Route::get('/dashboard', [HomeController::class,'index'])->middleware('auth');
Route::get('/individual',[IndividualController::class,'show'])->middleware('auth');
Route::get('/userlist',[UserController::class,'index'])->middleware('auth');

require __DIR__.'/auth.php';
