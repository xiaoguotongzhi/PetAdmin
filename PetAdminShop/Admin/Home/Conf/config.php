<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => '60.205.142.58', // 服务器地址
	//'DB_HOST'   => '182.92.67.210', // 服务器地址
	'DB_NAME'   => 'love_pet', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => 'xmm123456', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_CHARSET'=> 'utf8', // 字符集

	'DEFAULT_MODULE'     => 'Index', //默认模块
	'DEFAULT_CONTROLLER' => 'Login', // 默认控制器名称
	'DEFAULT_CHARSET'       =>  'utf-8', // 默认输出编码

	'SESSION_AUTO_START' => true, //是否开启session

	'URL_CASE_INSENSITIVE'  =>  true,//不区分大小写

	'URL_HTML_SUFFIX'=>'html',//伪静态
	'LOG_RECORD' => true, // 开启日志记录

	//开启layout布局
	'LAYOUT_ON'=>true,
	'LAYOUT_NAME'=>'layout',

	//隐藏系统默认错误提示,更换提示状态以及页面
	'SHOW_ERROR_MSG' =>false,
	'ERROR_MESSAGE' =>'请注意：因为一个不起眼的错误影响了正常运行',
	'ERROR_PAGE' =>'http://demo.cssmoban.com/cssthemes1/ftmp_183_ma/index.html'
);