<?php
# YouDian Enterprise Content Management System
# Copyright (C) YouDian Co.,Ltd (http://www.725725.com). All rights reserved.
if (is_file('./config.php')){
	$g = include './config.php';
	define('APP_DEBUG', isset($g['APP_DEBUG']) ? $g['APP_DEBUG'] : false);      //是否开启调试
}

if (!file_exists('./install.lock')){
	header("location: ./Install/index.php");
}

define('THINK_PATH', './App/Core/');        //框架路径
define('APP_NAME', 'App');                       //应用程序名
define('APP_PATH', './App/');                     //应用程序路径
define('APP_PUBLIC_PATH', './Public/');    //应用程序公共路径
require(THINK_PATH.'/ThinkPHP.php');    //加载核心框架
?>