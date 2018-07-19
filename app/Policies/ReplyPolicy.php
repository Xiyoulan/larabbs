<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    //回复者或者话题的作者可以删除回复
    public function destroy(User $user, Reply $reply)
    {
        return $user->id===$reply->user_id||$user->id===$reply->topic->user_id;
    }
}
