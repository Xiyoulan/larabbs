<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth',['except' => ['show']]);
    }
    //展示个人页面
    public function show(User $user) {
        return view('users.show', compact('user'));
    }

    //编辑个人资料页面
    public function edit(User $user) {
        $this->authorize('update',$user);
        return view('users.edit', compact('user'));
    }
       //编辑个人资料页面
    public function update(UserRequest $request,ImageUploadHandler $uploader,User $user) {
       $this->authorize('update',$user);
       $data =$request->all();
       if($request->avatar){
           //上传头像
           $result = $uploader ->save($request->avatar, 'avatars', $user->id,362);
           if($result){
               $data['avatar'] = $result['path']; 
           }
       }
       $user ->update($data);
       return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功!');
        
    }
    public function usersjson(Request $request){
        $name =$request->key;
        $users=User::where('name','like','%'.$name.'%')->pluck('name')->toArray();
        return response()->json($users); 
    }

}
