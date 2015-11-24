<?php
// 系统默认的核心行为扩展列表文件
return array(
    'app_begin'=>array(  //因为项目中也可能用到语言行为,最好放在项目开始的地方
        'CheckLang', //检测语言, 一定放在ReadHtmlCache前，否则会导致静态缓存有问题
    	'BadIP',  //ip过滤
    	'StartWeb', //启动Web
    	'ReadHtmlCache', // 读取静态缓存
    ),
	'info_content'=>array(
			'AutoLink', //关键词自动生成链接
	),
	'channel_content'=>array(
			'AutoLink', //关键词自动生成链接
	),
	'baseaction_init'=>array(
			'IpLocation', //Ip位置服务
	),
	'view_filter'=>array(
			'BadWords', // 模板输出替换
	),
);
?>