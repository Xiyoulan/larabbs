<?php

namespace App\Http\Controllers\Api;

use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Requests\Api\CaptchaRequest;

class CaptchaController extends Controller
{

    public function store(CaptchaRequest $request, CaptchaBuilder $captchaBuiler)
    {
        $key = 'captcha_' . str_random(15);
        $phone = $request->phone;
        $captcha = $captchaBuiler->build();
        $expiredAt = now()->addMinutes(2);
        \Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);
        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            //base64 格式返回图片
            'captcha_image_content' => $captcha->inline()
        ];
        return $this->response()->array($result)->setStatusCode(201);
    }

}
