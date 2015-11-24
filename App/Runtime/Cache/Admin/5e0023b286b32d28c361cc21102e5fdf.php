<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><html xmlns="http://www.w3.org/1999/xhtml"><head><title>管理中心-<?php echo ($WebName); ?></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta content="<?php echo ($CompanyUrl); ?>" name="Copyright" /><style type="text/css">html{ overflow:hidden;}
table,td,th, body,dt,dd,dl{ margin:0; padding:0; border:none;}
#nav { 
background: repeat-x url(<?php echo ($Images); ?>repeat.gif) 0 -209px ; font-size:12px; position:static; top:0; left:0;height:32px; line-height:26px; padding: 0 10px; 
}
#nav a { color:#666; text-decoration:none; }
#nav a:hover { color:#f60; text-decoration:underline;}
#nav dt, #nav dd { float:left;}
#nav dd { color:#999;}
#nav dt,#nav dd.link {
	padding-right:16px; background:url(<?php echo ($Images); ?>images.gif) no-repeat right -204px; 
}
#myfooter{text-align:center;
padding:8px;
color:#6B7355;
font-family:Verdana;
font-size:12px;}
#myfooter a { color:#4D5D2C; text-decoration:none; cursor:pointer;}
#myfooter a:hover { text-decoration:none; color:#f30;}
</style></head><body scroll="no" onLoad="init()"><table cellpadding="0" cellspacing="0" width="100%" height="100%"><tr><td colspan="2" height="59"><iframe src="<?php echo ($Url); ?>AdminTop" name="header" target="menu" width="100%" height="59" scrolling="no" frameborder="0"></iframe></td></tr><tr><td valign="top" rowspan="2" width="165px"><div style="width:165px;height:100%"><iframe src="<?php echo ($Url); ?>AdminLeft/MenuTopID/<?php echo ($MenuTopID); ?>" name="menu" id="menu" target="main" width="165px" height="100%"  scrolling="no" frameborder="0"></iframe></div></td><td valign="top" width="100%" height="100%"><table  cellpadding="0" cellspacing="0" width="100%" height="100%"><tr><td valign="top" height="32"><div id="nav"></div></td></tr><tr><td valign="top" width="100%" height="100%"><iframe src="<?php echo ($Url); ?>Welcome" id="main" name="main" width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow:visible;"></iframe></td></tr><tr><td valign="top" height="32" style="background:repeat-x url(<?php echo ($Images); ?>repeat.gif) 0 -165px ;"><div id="myfooter"><div style="width:auto;float:left;text-align:left;"><span style="font-weight:bold;color:#00C">您好！<span style="color:red"><?php echo ($AdminName); ?>[<?php echo ($AdminGroupName); ?>]</span>&nbsp;欢迎登录<span style="color:#F00"><?php echo ($WebName); ?></span>管理后台！</span>&nbsp;&nbsp;</div></div></td></tr></table></td></tr></table><script type="text/javascript">var init = function(){
	var nav = document.getElementById("nav");
	var main = document.getElementById("main");
	var mainDom;
	if(document.all){
		mainDom = main.contentWindow.document;
	}else{
		mainDom = main.contentDocument; //以HTML对象返回框架容纳的文档
	}
	nav.innerHTML = mainDom.getElementById("nav").innerHTML;
}

</script></body></html>