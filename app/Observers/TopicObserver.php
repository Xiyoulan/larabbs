<?php

namespace App\Observers;

use App\Models\Topic;
use App\Jobs\TranslateSlug;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{

    public function saving(Topic $topic)
    {
        //xss过滤
        $topic->body = clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);
    }

    public function saved(Topic $topic)
    {
         // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if (!$topic->slug) {
            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
        $topic->user->usersDetail()->increment('topics_count',1);
    }
    public function deleted(Topic $topic){
        //话题被删除,回复应当也被删除,这里用DB类避免触发Eloquent 事件回复删除
         \DB::table('replies')->where('topic_id', $topic->id)->delete();
           //用户话题数量-1
        $users_detail =$topic->user->usersDetail;
        if ($users_detail->topics_count > 0) {
            $users_detail->decrement('topics_count', 1);
        }
    }

}
