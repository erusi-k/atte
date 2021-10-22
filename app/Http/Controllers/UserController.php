<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\User;


class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('id','desc')->paginate(30);
        return view('userlist',['users'=>$users]);
    }
}
