<?php

namespace App\Notifications;

use App\Models\Reply; 
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserAted extends Notification
{

    use Queueable;

    //能被艾特的model,例如回复,帖子
    private $reply;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->reply=$reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $topic = $this->reply->topic;
        $page = ceil($topic ->reply_count/config('larabbs.replies_per_page'));
        $link = $topic->link(['page'=>$page, '#reply' . $this->reply->id]);
        // 存入数据库里的数据 将被转化成json格式并存储在notifications数据表的data字段中
        return [
            'reply_id' => $this->reply->id,
            'reply_content' => $this->reply->content,
            'user_id' => $this->reply->user->id,
            'user_name' => $this->reply->user->name,
            'user_avatar' => $this->reply->user->avatar,
            'topic_link' => $link,
            'topic_id' => $topic->id,
            'topic_title' => $topic->title,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
                //
        ];
    }

}
