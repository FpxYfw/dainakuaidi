<?php

return [
    // 公共接口 默认的 token
    'defaultToken' => '0cc175b9c0f1b6a831c399e269772661',

    // 版本号
    'version' => 'v1',

    // hash
    'hash' => [
        [2,3,1,17,22,28],
        [0,8,19,23,30,31],
        [9,15,31,1,5,7],
        [11,21,31,10,12,16],
        [30,1,12,18,25,28],
        [8,14,17,27,1,4],
        [2,8,13,19,20,24],
        [5,16,20,29,18,22],
    ],

    // 公共路由
    'publicApiArr' => [
        'App\Http\Controllers\LoginController@login',
    ],
];