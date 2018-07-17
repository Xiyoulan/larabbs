<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {

    //展示个人页面
    public function show(User $user) {
        return view('users.show', compact('user'));
    }

}
