<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BreakTimeController;
use App\Http\Controllers\CheckAttendanceController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\IndividualController;

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

Route::apiResource('/attendance',AttendanceController::class)->only([
    'store','update'
]);
Route::apiResource('/breaktime',BreakTimeController::class)->only([
    'store','update'
]);;
Route::get('/checkattendance',[CheckAttendanceController::class,'punchIncheck']);
Route::get('/datarequest',[DataController::class,'index']);
Route::get('/individual',[IndividualController::class,'index']);
