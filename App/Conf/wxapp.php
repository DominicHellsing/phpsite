<?php
$wxapp=array (
 		'/^([\w\W]+)(天气)$/i'=>array(
 				'name'=>'天气查询', 'type'=>'3', 'function'=>'weather',
 				'parameter'=>array('days'=>2, 'city'=>'北京', 'errormsg'=>'抱歉，没有天气数据或系统繁忙，请稍后再试！'),
 				'msgtype'=>'text', 'msgtpl'=>'',
 				'description'=>"格式：(城市名称)天气\n举例：长沙天气",
 		),
		'/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/'=>array(
				'name'=>'手机归属地查询', 'type'=>'3', 'function'=>'guishudi',
				'parameter'=>array(),
				'description'=>"格式：(手机号码)\n举例：13285877889",
		),
		'/^([\w\W]+)公交从([\w\W]+)到([\w\W]+)$/'=>array(
				'name'=>'公交换乘查询','type'=>'3', 'function'=>'gongjiaohuancheng',
				'description'=>"格式：(城市名称)公交从(起点站)到(终点站)\n举例：长沙公交从火车站到五一广场",
		),
		'/^([\w\W]+)公交([\w\W]+)$/'=>array(
				'name'=>'公交查询','type'=>'3', 'function'=>'gongjiao',
				'parameter'=>array('errormsg'=>'抱歉，没有查询到结果'),
				'description'=>"格式：(城市名称)公交(公交线路名)\n举例：长沙公交127",
		),
		'/^火车([\w\W]+)$/'=>array(
				'name'=>'火车车次查询', 'type'=>'3', 'function'=>'huochecheci',
				'parameter'=>array('errormsg'=>'抱歉，没有查询到结果'),
				'description'=>"格式：火车(车次)\n举例：火车T1",
		),
		'/^高([\d]+)重([\d]+)$/'=>array(
				'name'=>'健康指数查询', 'type'=>'3', 'function'=>'jiankang',
				'description'=>"格式：高(身高cm)重(体重kg)\n举例：高175重75",
		),
		'/^翻译([\w\W]+)$/'=>array(
				'name'=>'翻译', 'type'=>'3', 'function'=>'fanyi',
				'description'=>"格式：翻译(待翻译的中文)\n举例：翻译我爱你",
		),
		'/^([\w\W]+)快递([\w\W]+)$/'=>array(
				'name'=>'快递查询','type'=>'3', 'function'=>'kuaidi',
				'description'=>"格式：(快递公司名称)快递(快递单号)\n举例：天天快递1238898898",
		),
		'/^股票([a-zA-Z0-9]{3,})$/'=>array(
				'name'=>'股票查询', 'type'=>'3', 'function'=>'gupiao',
				'description'=>"格式：股票(股票代码)\n举例：股票000088",
		),
		'/^([\w\W]+)人品$/'=>array(
				'name'=>'人品计算','type'=>'3', 'function'=>'renpin',
				'description'=>"格式：(姓名)人品\n举例：李白人品",
		),
		'/^梦见([\w\W]+)$/'=>array(
				'name'=>'周公解梦','type'=>'3', 'function'=>'zhougongjiemeng',
				'description'=>"格式：梦见(梦的内容)\n举例：梦见下雨",
		),
		'/^成语([\w\W]+)$/'=>array(
				'name'=>'成语词典','type'=>'3', 'function'=>'chengyu',
				'description'=>"格式：成语(成语名称)\n举例：成语百步穿杨",
		),
		'/^(\d{6})$/'=>array(
				'name'=>'邮编查询','type'=>'3', 'function'=>'youbian',
				'description'=>"格式：(6位邮政编码)\n举例：410000",
		),
		
		/*
		'/^([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+)/i'=>array(
				'name'=>'域名授权查询','type'=>'3', 'function'=>'cmsauthorize',
				'description'=>"格式：(域名)\n举例：FZYCMS.com",
		),
		*/
		
		'/^([\w\W]+)菜谱$/'=>array(
				'name'=>'菜谱','type'=>'3', 'function'=>'caipu',
				'description'=>"格式：(菜名)菜谱\n举例：剁椒鱼头菜谱",
		),
		'/^谜语(\d+)$/'=>array(
				'name'=>'谜语答案','type'=>'3', 'function'=>'miyu',
				'description'=>"格式：谜语(谜语编号)\n举例：谜语8",
		),
		'/^完善资料|WSZL$/i'=>array(
				'name'=>'完善资料','type'=>'3', 'function'=>'wanshanziliao',
				'msgtpl'=>'登记会员资料成功！',
				'description'=>"格式：完善资料\n备注：主要用于登记会员信息",
		),
		'/^([\w\W]*)(帮助|\?)$/i'=>array(
				'name'=>'查看指令帮助','type'=>'3', 'function'=>'zhilingbangzhu',
				'description'=>"格式：[指令关键词]帮助|?\n举例：?、天?、天帮助\n备注：指令关键词支持模糊检索",
		),
		'/^歌词([\w\W]+)$/'=>array(
				'name'=>'歌词','type'=>'3', 'function'=>'geci',
				'description'=>"格式：歌词(歌名[-歌手])\n举例：歌词天路、歌词忘情水-刘德华",
		),
		
		'糗事'=> array('name'=>'糗事', 'type'=>'3', 'function'=>'choushi', 'description'=>"格式：糗事"),
		'谜语'=> array('name'=>'谜语', 'type'=>'3', 'function'=>'miyu', 'description'=>"格式：谜语"),
		'笑话'=> array('name'=>'笑话', 'type'=>'3', 'function'=>'xiaohua', 'description'=>"格式：笑话"),
 		'大转盘'=> array('name'=>'大转盘抽奖活动', 'type'=>'1', 'function'=>'dazhuanpan', 'description'=>"格式：大转盘\n备注：返回最新大转盘应用"),
 		'刮刮卡'=> array('name'=>'刮刮卡刮奖活动', 'type'=>'1', 'function'=>'guaguaka', 'description'=>"格式：刮刮卡\n备注：返回最新刮刮应用"),
		'兑奖'=> array('name'=>'活动兑奖', 'type'=>'1', 'function'=>'duijiang', 'description'=>"格式：兑奖\n备注：查询活动中奖信息"),
		'调查'=> array('name'=>'微调查', 'type'=>'5', 'function'=>'diaocha', 'description'=>"格式：调查\n备注：返回所有微调查"),
		'投票'=> array('name'=>'微投票', 'type'=>'2', 'function'=>'toupiao', 'description'=>"格式：投票\n备注：返回所有微投票"),
		'会员卡'=> array('name'=>'微会员卡', 'type'=>'6', 'function'=>'huiyuanka', 'description'=>"格式：会员卡\n备注：返回微会员卡"),
		
		//关键词不用于直接录入
		'我的位置'=> array('name'=>'我的位置', 'type'=>'4', 'function'=>'lbsplace',
				'description'=>"格式：我的位置\n备注：必须先发送位置消息"),
		'/^附近(\d*)([\w\W]+)$/'=> array('name'=>'附近位置查询', 'type'=>'4', 'function'=>'lbsnear', 
				'parameter'=>array('radius'=>'3000',),
				'description'=>"格式：附近[搜索半径m](关键词)\n举例：附近500酒店:表示附近500米范围的酒店，若省略搜索范围，则默认为3000米"),
);
//微信扩展开放配置
$wxconfig = array('wxother.php');
foreach ($wxconfig as $v){
	if( is_file(CONF_PATH.$v)){
		$wx = include CONF_PATH.$v;
		if(!empty($wx)){
			$wxapp = array_merge($wxapp, $wx);
		}
	}
}
return $wxapp;
?>