<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\AttendanceController;
use App\http\Controllers\BreakTimeController;
use App\http\Controllers\CheckAttendanceController;
use App\http\Controllers\DataController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/attendance',AttendanceController::class);
Route::apiResource('/breaktime',BreakTimeController::class);
Route::get('/checkattendance',[CheckAttendanceController::class,'punchIncheck']);
Route::get('/datarequest',[DataController::class,'index']);
