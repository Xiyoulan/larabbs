<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UsersDetail;
// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public  function saving(User $user){
        if(empty($user->avatar)){
            $user->avatar = 'https://fsdhubcdn.phphub.org/uploads/images/201710/30/1/TrJS40Ey5k.png';
        }
    } 
    public function created(User $user){
      //创建usersDetail  
        $user->usersDetail()->save(new UsersDetail());
     // UsersDetail::create(['user_id'=> $user->id]);
    }
    
}