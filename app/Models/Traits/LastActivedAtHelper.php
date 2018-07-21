<?php

namespace App\Models\Traits;

use Redis;
use Carbon\Carbon;

trait LastActivedAtHelper
{

    //缓存相关
    protected $hash_prefix = 'larabbs_last_actived_at_';
    protected $field_prefix = 'user_';

    public function recordLastActivedAt()
    {
        $date = Carbon::now()->toDateString();
        $hash = $this->getHashFromDateString($date);
        //字段名称:eg:user_1
        $field = $this->getHashField();
        //当前时间
        $now = Carbon::now()->toDateTimeString();

        // 数据写入 Redis ，字段已存在会被更新
        Redis::hSet($hash, $field, $now);
    }

    //同步数据到数据库中
    public function syncUserActivedAt()
    {    //获取前一天日期
        $date = Carbon::yesterday()->toDateString();
        // Redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-21
        $hash = $this->getHashFromDateString($date);
        $datas = Redis::hGetAll($hash);
        foreach ($datas as $user_id => $actived_at) {
            //去掉前缀 eg:user_1 => 1
            $use_id = str_replace($this->field_prefix, '', $user_id);
            $user = $this->find($use_id);
            if ($user) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }
        // 以数据库为中心的存储，既已同步，即可删除
        Redis::del($hash);
    }

    //
    public function getHashFromDateString($date)
    {
        // Redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-21
        return $this->hash_prefix . $date;
    }

    public function getHashField()
    {
        // 字段名称，如：user_1
        return $this->field_prefix . $this->id;
    }

    //获得最后活跃时间
    public function getLastActivedAtAttribute($value)
    {
        //若是在缓存中有从缓存中取,否则在数据库中取
        $date = Carbon::now()->toDateString();
        $hash = $this->getHashFromDateString($date);
        $field = $this->getHashField();
        $datetime = Redis::hGet($hash, $field) ?: $value;

        if ($datetime) {
            return new Carbon($datetime);
        } else {
            //不存在取用户注册时间
            return $this->created_at;
        }
    }

}
