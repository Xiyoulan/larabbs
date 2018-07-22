<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersDetailsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_details', function (Blueprint $table) {
            $table->increments('id');
            $table ->integer('user_id')->unsigned()->index();
            //关注数量
            $table->integer('followings_count')->unsigned()->default(0);
            //粉丝数量
            $table->integer('followers_count')->unsigned()->default(0);
            //回复数量
            $table->integer('replies_count')->unsigned()->default(0);
            //话题数量
            $table->integer('topics_count')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_details');
    }

}
