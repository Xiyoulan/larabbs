<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{

    public function creating(Reply $reply)
    {
        //过滤xss攻击
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function created(Reply $reply)
    {
        //帖子的回复数+1
        $topic = $reply->topic;
        $topic->increment('reply_count', 1);

        // 通知作者话题被回复了
        $topic->user->notify(new TopicReplied($reply));
    }
    public function deleted(Reply $reply){
        //回复被删除时,话题回复数-1
        $topic = $reply->topic;
        $topic->decrement('reply_count', 1);
        //通知回复者回复被删除
        //todo
    }

}
