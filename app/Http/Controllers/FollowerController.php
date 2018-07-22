<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class FollowerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //关注
    public function follow(User $user)
    {
        $current_user = Auth::user();
        //判断是不是账户
        if ($current_user->id == $user->id) {
            return back()->with('warning', '不能关注或者取消关注自己!');
        }
        //判断有没有关注过
        if (!$current_user->isFollowing($user)) {
            $current_user->follow($user->id);
            $current_user->usersdetail()->increment('followings_count', 1);
            $user->usersDetail()->increment('followers_count', 1);
        }
        return back();
    }

    //取消关注
    public function unfollow(User $user)
    {
        $current_user = Auth::user();
        //判断是不是账户
        if ($current_user->id == $user->id) {
            return back()->with('warning', '不能关注或者取消关注自己!');
        }
        //判断有没有关注过
        if ($current_user->isFollowing($user)) {
            $current_user->unFollow($user->id);
            $current_user->usersdetail()->decrement('followings_count', 1);
            $user->usersDetail()->decrement('followers_count', 1);
        }
        return back();
    }

}
