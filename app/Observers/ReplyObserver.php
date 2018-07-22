<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;
use App\Handlers\AtUserHandler;
use App\Notifications\UserAted;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{

    public function creating(Reply $reply)
    {
        //过滤xss攻击
        $content = clean($reply->content, 'user_topic_body');
        //查找@username 并替换成链接 
        $reply->content = app(AtUserHandler::class)->replaceAtUserNames($content);
        //通知被艾特的用户
        //1.获得被@的用户
        $users = app(AtUserHandler::class)->getAtUsers($content);
        if (!empty($users)) {
            session()->put('at_users', $users);
        }
    }

    public function created(Reply $reply)
    {
        //帖子的回复数+1
        $topic = $reply->topic;
        $topic->increment('reply_count', 1);
         //用户回复数+1
        $reply->user->usersDetail->increment('replies_count', 1);
        // 通知作者话题被回复了
        $topic->user->notify(new TopicReplied($reply));
        // 通知被艾特的人
        $users = session()->get('at_users');
        if ($users) {
            foreach ($users as $user) {
                $user->notify(new UserAted($reply));
            }
            session()->forget('at_users');
        }
    }

    public function deleted(Reply $reply)
    {
        //回复被删除时,话题回复数-1
        $topic = $reply->topic;
        if ($topic->reply_count > 0) {
            $topic->decrement('reply_count', 1);
        }
        //用户回复数-1
        $users_detail =$reply->user->usersDetail;
        if ($users_detail->replies_count > 0) {
            $users_detail->decrement('replies_count', 1);
        }
        //通知回复者回复被删除
        //todo
    }

}
