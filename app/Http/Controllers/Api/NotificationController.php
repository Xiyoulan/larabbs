<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Transformers\NotificationTransformer;

class NotificationController extends Controller
{

    public function index()
    {
        $notifications = $this->user->notifications()->paginate(20);
        //$this->user->markAsRead();
        return $this->response->paginator($notifications, new NotificationTransformer());
    }

    public function stats()
    {
        $count = $this->user->notification_count;
        return $this->response->array(['unread_count' => $count]);
    }

    public function read()
    {
        $this->user()->markAsRead();

        return $this->response->noContent();
    }

}
