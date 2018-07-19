<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public  function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        //获得用户的所有通知
        $notifications=Auth::User()->notifications()->paginate(20);
        //标记为已读, 未读数量清零
        Auth::User()->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
