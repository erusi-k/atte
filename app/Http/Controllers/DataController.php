<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\BreakTime;
use Carbon\Carbon;
use App\Lib\My_func;

class DataController extends Controller
{

    // 実績取得処理
    public function index(Request $request){
        $day = new Carbon($request->day);
        $items = Attendance::where('day',$day)->paginate(2);
        $breakSum='';
        $userName=[];
        $totalBreak=[];
        $i = 0;
        $l = 0;
        foreach($items as $item){
            $breaks = BreakTime::where('user_id',$item->user_id)->where('day',$day)->get();
                if($breaks->isEmpty()){
                    $breakAll = 0;
                }else{
                    foreach($breaks as $break){
                        $breakIn = new Carbon($break->breakIn);
                        $breakOut = new Carbon($break->breakOut);
                        $breakSeconds = $breakIn->diffInseconds($breakOut);
                        $breakAll =+ $breakSeconds;
                    }
                }    
            $punchIn = new Carbon($item->punchIn);
            $punchOut = new Carbon($item->punchOut);
            $punchSeconds = $punchOut->diffInseconds($punchIn);
            $totalTime = $punchSeconds - $breakAll;
            $totalBreak[]= My_func::s2h($breakAll);

        if($i<count($items)){
            $name =$item->user()->where('id',$item->user_id)->first();
            $items[$i]['name'] = $name->name;
            $items[$i]['total'] = My_func::s2h($totalTime);
        }
        $i++;
        }
        
        foreach($totalBreak as $item){
        if($l<count($items)){
            $items[$l]['break'] =$item;
            $l++;
        }
    }
    
        return response()->json([
            'data'=>$items,
        ],200);
    
}

    public function show(){
        return view('dataList');
    }
}
