<?php

namespace App\Handlers;

use App\Models\User;

class AtUserHandler
{

    private $users = [];
    //@的格式必须是 @username后有一个空格 
    protected $reg = '/@([\p{Han}A-Za-z0-9\-\_]+)\s/u';

    public function getAtUserNames($input)
    {
        preg_match_all($this->reg, $input, $matches);
        // dd($matches);
        foreach ($matches[1] as $name) {
            $this->users[] = $name;
        }
        //去重
        $this->users = array_unique($this->users);
        return $this->users;
    }

    public function getAtUsers($input)
    {
        $users = $this->getAtUserNames($input);
        return User::whereIn('name', $users)->get();
    }

    public function replaceAtUserNames($input)
    {
        return preg_replace_callback($this->reg, "self::replace", $input);
    }

    protected function replace($matches)
    {
        $user = User::where('name', $matches[1])->first();
        if ($user) {
            return "<a href='" . route('users.show', $user->id) . "'style='color:#f4645f'>" . trim($matches[0]) . "</a> ";
        } else {
            return $matches[0];
        }
    }

}
