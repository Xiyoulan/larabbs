<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersDetail extends Model
{

    protected $table = "users_details";
    public $timestamps =false;
    protected $fillable = ['user_id', 'followings_count', 'followers_count', 'replies_count', 'topics_count'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
