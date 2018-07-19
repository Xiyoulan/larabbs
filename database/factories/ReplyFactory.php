<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    //随机一个月内
    $date_time = $faker->dateTimeThisMonth();
    return [
        'content'=>$faker->sentence(),
        'created_at' =>$date_time,
        'updated_at' =>$date_time,
    ];
});
