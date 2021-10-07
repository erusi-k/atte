<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $time = carbon::now();
        $item = Attendance::create(['user_id'=>$request->user_id,'day'=>$time,'punchIn'=>$time]);
        return response()->json([
            'data'=>$item,
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $timestamp = Attendance::where('user_id',$id)->latest()->first();
        if(!empty($timestamp->punchOut)){
            return response()->json([
                'message'=>'すでに退勤の打刻がされているか、出勤打刻がされていません'
            ]);
        }
        $item = $timestamp->update([
            'punchOut'=>Carbon::now()
        ]);
        
        return response()->json([
            'data'=>$item
        ],200);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    
}
