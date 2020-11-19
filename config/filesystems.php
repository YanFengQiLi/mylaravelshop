<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

        //  七牛云储存
        'qiniu' => [
            'driver' => 'qiniu',
            'domains' => [
                'default' => env('QINIU_DOMAIN'), //你的七牛域名
                'https' => env('QINIU_DOMAIN'), //你的HTTPS域名
                'custom' => env('QINIU_DOMAIN'), //自定义域名无用,与default保持一致就行
            ],
            'access_key' => env('QINIU_AK'),  //AccessKey
            'secret_key' => env('QINIU_SK'),  //SecretKey
            'bucket' => env('QINIU_BUCKET'),  //Bucket名字
            'notify_url' => '',  //持久化处理回调地址
            'url' => 'http://' . env('QINIU_DOMAIN') . '/',  // 填写文件访问根url
        ],

        //  后台文件上传
        'admin' => [
            'driver' => 'local',
            'root' => public_path('uploads'),
            'visibility' => 'public',
            'url' => env('APP_URL') . '/uploads',
        ],
    ],

    //  图片格式配置
    'images_config' => [
        //  允许上传图片的 mime 类型,多个用逗号分隔
        'mime_type' => 'jpg,png,gif,jpeg',
        //  单个图片上传大小 单位KB
        'max_size' => 2 * 1024,
    ],

    //  文件格式配置
    'file_config' => [
        //  允许上传文件的 mime 类型, 多个用逗号分隔
        'mine_type' => 'jpg,png,gif,jpeg,ppt,doc,docx,xls,xlsx,pdf',
        //  单个文件上传大小 单位KB
        'max_size' => 5 * 1024
    ],

    //  视频格式配置
    'video_config' => [
        //  视频文件的 mime 类型
        'mime_type' => 'mp4',
        //  单个文件上传大小 单位KB
        'max_size' => 200 * 1024
    ]

];
