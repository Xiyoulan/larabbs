<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CalculateActiveUser extends Command
{
    
    //console command 供我们调用的命令
    protected $signature = 'larabbs:calculate-active-user';

    //命令描述,可以在artisan list 命令看到
    protected $description = '通过回复量和发帖量统计生成活跃用户,并将其缓存';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user)
    {
         // 在命令行打印一行信息
        $this->info("开始计算...");
        //   
        $user->calculateAndCacheActiveUsers();

        $this->info("成功生成！");
    }
}
