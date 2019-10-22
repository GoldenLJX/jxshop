<?php
return array(
	//'配置项'=>'配置值'
    'URL_MODEL'=>2,//设置URL模式为重写模式
    'MODULE_ALLOW_LIST'=>array('Home','Admin'),//设置容许访问的模块
//    'DEFAULT_MODULE'=>'Admin',//设置默认的模块
    //增加自定义的模板替换配置信息
    'TMPL_PARSE_STRING'=>array(
        '__PUBLIC__'=>'../ueditor',
        '__PUBLIC_ADMIN__'=>'/Public/Admin',
    ),
    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'jxshop',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'ljx674897315',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'jx_',    // 数据库表前缀
);