<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\BreakTime;
use Carbon\Carbon;
use App\Lib\My_func;

class IndividualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //ユーザー別実績データ取得
    public function index(Request $request)
    {   
        $year = substr($request->day,0,4);
        $month = substr($request->day,-2);
        $items = Attendance::where('user_id',$request->user_id)->whereYear('day',$year)->whereMonth('day',$month)->get();
        $i = 0;
        $l = 0;
        $totalBreak = [];
        foreach($items as $item){
            $breaks = BreakTime::where('user_id',$item->user_id)->where('day',$item->day)->get();
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
            $totalBreak[] = My_func::s2h($breakAll);

            if($i<count($items)){
                $items[$i]['total'] = My_func::s2h($totalTime);
            }
            $i++;
        }

        foreach($totalBreak as $item){
            if($l<count($items)){
                $items[$l]['break'] = $item;
                $l++;
            }
        }

        return response()->json([
            'data'=>$items,
        ],200);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        $param = [
            'user'=>$user
        ];
        return view('individual',$param);
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
        //
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
