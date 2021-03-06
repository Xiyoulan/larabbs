<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\Link;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function show(Request $request, Category $category,User $user,Link $link)
    {
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $topics = Topic::where('category_id', $category->id)->with('user', 'category')->withOrder($request->order)->paginate(20);
        // 活跃用户列表
        $active_users = $user->getActiveUsers();
        //推荐资源
        $links = $link->getAllCached();
        // 传参变量话题和分类到模板中
        return view('topics.index', compact('topics', 'category','active_users','links'));
    }

}
