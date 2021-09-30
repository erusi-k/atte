<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;

class DataController extends Controller
{
    public function index(Request $request){
        $day = new Carbon($request->day);
        $item = Attendance::where('day',$day)->paginate(3);
        return response()->json([
            'data'=>$item,
            'day'=>$day
        ],200);
    }

    public function show(){
        return view('datalist');
    }
}
