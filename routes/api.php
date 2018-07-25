<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings',],
        ], function($api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
            ], function($api) {
        // 短信验证码
        $api->post('verificationCodes', 'VerificationCodeController@store')
                ->name('api.verificationCodes.store');
        // 用户注册
        $api->post('users', 'UserController@store')
                ->name('api.users.store');
        // 图片验证码
        $api->post('captchas', 'CaptchaController@store')
                ->name('api.captchas.store');
        // 第三方登录
        $api->post('socials/{social_type}/authorizations', 'AuthorizationController@socialStore')
                ->name('api.socials.authorizations.store');
        // 登录
        $api->post('authorizations', 'AuthorizationController@store')
                ->name('api.authorizations.store');
        // 刷新token
        $api->put('authorizations/current', 'AuthorizationController@update')
                ->name('api.authorizations.update');
        // 删除token
        $api->delete('authorizations/current', 'AuthorizationController@destroy')
                ->name('api.authorizations.destroy');
    });
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
            ], function ($api) {

        // 游客可以访问的接口
        $api->get('categories', 'CategoriesController@index')
                ->name('api.categories.index');
        //帖子列表
        $api->get('topics', 'TopicController@index')
                ->name('api.topics.index');
        //帖子详情
        $api->get('topics/{topic}', 'TopicController@show')
                ->name('api.topics.show');
        //某个用户的帖子列表
        $api->get('users/{user}/topics', 'TopicController@userIndex')
                ->name('api.users.topics.index');


        // 需要 token 验证的接口
        $api->group(['middleware' => 'api.auth'], function($api) {
            // 当前登录用户信息
            $api->get('user', 'UserController@me')
                    ->name('api.user.show');
            // 图片资源
            $api->post('images', 'ImageController@store')
                    ->name('api.images.store');
            // 编辑登录用户信息
            $api->patch('user', 'UserController@update')
                    ->name('api.user.update');
            // 发布话题
            $api->post('topics', 'TopicController@store')
                    ->name('api.topics.store');
            //编辑话题
            $api->patch('topics/{topic}', 'TopicController@update')
                    ->name('api.topics.update');
            //删除
            $api->delete('topics/{topic}', 'TopicController@destroy')
                    ->name('api.topics.destroy');
        });
    });
});
