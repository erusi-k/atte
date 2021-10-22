<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\BreakTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // ステータスの確認処理
    public function punchInCheck(Request $request)
    {
        $oldtimein = Attendance::where('user_id',$request->user_id)->latest()->first();
        $breaktimein = BreakTime::where('user_id',$request->user_id)->latest()->first();
        $oldDay = '';
        $breakDay = '';
        $today  = Carbon::today();
        
        if($oldtimein){
            $oldDay = new Carbon($oldtimein->day);
        }   
        if($breaktimein){
            $oldTimeBreakIn = new Carbon($breaktimein->breakIn);
            $breakDay = $oldTimeBreakIn->startOfDay();
        }
        

        if(($oldDay == $today) && (empty($oldtimein->punchOut))){
            
            $punchIn=false;
            $punchOut=true;
            if(($breakDay == $today) && (empty($breaktimein->breakOut))){
                $breakIn = false;
                $breakOut = true;
                $punchOut  = false;
            }else {
                $breakIn = true;
                $breakOut =false;
                }
        }else{
            $punchIn = true;
            $punchOut = false;
            $breakIn =  false;
            $breakOut = false;
            $fin = false;
        }
        if((($oldDay == $today) && (!empty($oldtimein->punchOut)))){
            $punchIn = false;
            $punchOut = false;
            $breakIn =  false;
            $breakOut = false;
            $fin = true;
        }
        return response()->json([
            'punchIn'=>$punchIn,
            'punchOut'=>$punchOut,
            'breakIn'=>$breakIn,
            'breakOut'=>$breakOut,  
            'fin'=>$fin,
        ]);     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
