<?php

return [
    'custom' => [
        'card_number' => [
            'required' => '会员卡号不能为空',
        ],
        'name' => [
            'required' => '姓名不能为空',
            'max'                  => [
                'numeric' => '姓名最多不能超过 :max字符',
            ],
        ],
        'mobile' => [
            'required' => '手机号码不能为空',
            'mobile' => '手机号码格式不正确',
            'sms' => '短信发送时间间隔过短',
            'unique' => '手机号码已存在，请更换',
        ],
        'verifyCode' => [
            'required' => '短信码不能为空',
            'min'                  => [
                'numeric' => '验证码至少 :min个数字.',
            ],
            'verify_code' => '短信验证码不正确'
        ],
    ],
];