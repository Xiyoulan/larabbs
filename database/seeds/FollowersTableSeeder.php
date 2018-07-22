<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UsersDetail;

class FollowersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //所有人都关注1号用户,1号用户关注所有人
        $users = User::all();
        $user_ids = $users->pluck('id')->slice(1)->toArray();
        $user = User::find(1);
        $user->follow($user_ids);
        $user->usersDetail()->save(new UsersDetail(['followings_count' => count($user_ids), 'followers_count' => count($user_ids)]));
        foreach ($users as $u) {
            if($u->id==1){
                continue;
            }
            $u->follow(1);
            $u->usersDetail()->save(new UsersDetail(['followers_count' => 1,'followings_count'=>1]));
        }
    }

}
