<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api'
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
});
