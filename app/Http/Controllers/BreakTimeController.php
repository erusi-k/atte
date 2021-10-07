<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BreakTime;
use Carbon\Carbon;

class BreakTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $item = BreakTime::create(['user_id'=>$request->user_id,'day'=>$time,'breakIn'=>$time]);
        if($item){
            return response()->json([
                'message'=>'休憩に入りました！',
            ],201);
        }
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
        $timestamp = BreakTime::where('user_id',$id)->latest()->first();
        if(!empty($timestamp->breakOut)){
            return response()->json([
                'message'=>'すでに休憩終了がされているか、休憩開始がされていません'
            ]);
        }
        $item = $timestamp->update([
            'breakOut'=>Carbon::now()
        ]);
        if($item) {
            return response()->json([
                'message'=>'休憩が終わりました！'
            ],200);
        }
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
