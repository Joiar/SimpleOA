<?php
return array(
	//'配置项'=>'配置值'

    // debug trace
//    'SHOW_PAGE_TRACE' =>true,

    // APP config
    'APP_NAME' => '差旅审批系统',

    // DB config
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'SimpleOA',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'OA_',    // 数据库表前缀

    // pagination config
    'PAGE_SIZE'             =>  10,

    // transportation config
    'TRANSPROTATION' => array(
        'CAR' => '客运汽车',
        'TRAIN' => '火车',
        'SHIP' => '轮船',
        'PLANE' => '飞机'
    )
);