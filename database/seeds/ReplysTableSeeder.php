<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Topic;
use App\Models\Reply;

class ReplysTableSeeder extends Seeder
{

    public function run()
    {
        //创建一千条回复,将回复随机分配话题和回复人
        //所有人的用户id
        $user_ids = User::all()->pluck('id')->toArray();
        //所有帖子的id
        $topic_ids = Topic::all()->pluck('id')->toArray();
        //实例化faker
        $faker =app(\Faker\Generator::class);
        $replys = factory(Reply::class)
                ->times(1000)
                ->make()
                ->each(function ($reply, $index)use($user_ids,$topic_ids,$faker){
                 $reply->user_id = $faker->randomElement($user_ids);
                 $reply->topic_id = $faker->randomElement($topic_ids);
                 
        });
         // 将数据集合转换为数组，并插入到数据库中
        Reply::insert($replys->toArray());
        
    }

}
