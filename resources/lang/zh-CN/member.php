<?php
return [
    // labels是自定义标签翻译(除了数据表字段)   可以是任何自定义内容
    'labels' => [
        // 这个是页面 title 翻译
        'Member' => '会员列表',
        //  面包屑翻译,是根据路由匹配的  /member/users
        'users' => '会员列表'
    ],
    // 表字段翻译
    'fields' => [
        'account' => '手机号',
        'email' => '邮箱',
        'password' => '密码',
        'user_name' => '姓名',
        'nick_name' => '昵称',
        'sex' => '性别',
        'photo' => '头像',
        'status' => '状态',
        'integral' => '积分'
    ],
    //  枚举选项翻译
    'options' => [
        'sex' => [
            1 => '男',
            2 => '女'
        ],
        'status' => [
            0 => '冻结',
            1 => '正常'
        ]
    ],
];
