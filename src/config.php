<?php

/*
 * This file is part of the nilsir/laravel-esign.
 *
 * (c) nilsir <nilsir@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Ice\Recharge\Constants\OilConstant;

return [
    'oFei' => [
        'host' => env('OF_HOST', 'http://apitest.ofpay.com'),
        'version' => '6.0',
        'key' => env('OF_KEY', 'OFCARD'),
        'userId' => env('OF_USERID', 'A08566'),
        'userpwd' => env('OF_USERPWD', 'of111111'),
        'product' => [
            OilConstant::ZHONG_SHI_HUA => [
                1 => '64127500',
                50 => '64157005',
                100 => '64157004',
                200 => '64157003',
                500 => '64157002',
                1000 => '64157001',
            ],
            OilConstant::ZHONG_SHI_YOU => [
                1 => '64127500',
                50 => '64157005',
                100 => '64157004',
                200 => '64157003',
                500 => '64157002',
                1000 => '64157001',
            ],
        ],
    ],
    'wzh' => [
        'host' => "http://api.szwanzh.com",
        'appId' => "721d31f780f64efc813b28b2681688f0",
        'appKey' => "be41434fbe8c457b9cd9aee2aa58fe6b",
        'product' => [
            OilConstant::WZH_ZHONG_SHI_HUA => [
                1 => '',
                50 => '',
                100 => '2951',
                200 => '2953',
                500 => '2955',
                1000 => '',
            ],
            OilConstant::WZH_ZHONG_SHI_YOU => [
                1 => '',
                50 => '',
                100 => '2952',
                200 => '2954',
                500 => '2956',
                1000 => '',
            ],
            OilConstant::WZH_HUA_FA => [
                50 => '2957',
                100 => '2958',
                200 => '2959',
            ],

        ],
    ],

];

