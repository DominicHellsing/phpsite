<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title><link href="<?php echo ($Css); ?>style.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery-1.7.2.min.js"></script><script type="text/javascript" src="<?php echo ($Js); ?>sidebar.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jscroll.js"></script><style>#treemenu a {font-weight:bold;text-decoration: none;}
#treemenu a:hover {font-weight:bold;text-decoration: none;}
#topmenu{ text-align:left;padding:2px;}
#topmenu a {color:#000;text-decoration: none;}
#topmenu a:hover {text-decoration: none;color:#06F;}
.depth1{ font-weight:bold }
#topmenu .single{color:#F30;}
#topmenu .link{color:#60F;}
#topmenu .feedback{color:#090;}
.cc{ background-color:#9BB055; color:#FFFFFF;}
</style><script type='text/javascript'>	$(document).ready(function(){
		var h = $(window).height();
		ScrollChannel(h);
		ScrollWx(h);

		$(window).resize(function() {
			var h = $(window).height();
			ScrollChannel(h);
			ScrollWx(h);
		});
		
		function ScrollChannel(h){
				$('#ScrollChannel').css({height:h - 252});
				$('#ScrollChannel').jscroll({
					W:"10px",
					BgUrl:"",//设置滚动条背景图片地址
					Bg:"#d8e899",//设置滚动条背景图片position,颜色等
					Bar:{  Pos:"up",//设置滚动条初始化位置在底部
						   Bd:{Out:"#eaf1d6",Hover:"#eaf1d6"},//设置滚动滚轴边框颜色：鼠标离开(默认)，经过
						   Bg:{Out:"#87a34d",Hover:"#677c3b",Focus:"#677c3b"}
					}, //设置滚动条滚轴背景：鼠标离开(默认)，经过，点击
					Btn:{  btn: false, //是否显示上下按钮 false为不显示
						   uBg:{Out:"#9bb055",Hover:"#9bb055",Focus:"#9bb055"},//设置上按钮背景：鼠标离开(默认)，经过，点击
						   dBg:{Out:"#9bb055",Hover:"#9bb055",Focus:"#9bb055"}
					}  //设置下按钮背景：鼠标离开(默认)，经过，点击
				});
		}
		
		function ScrollWx(h){
			$("#ScrollWx").css({height:h - 442});
			$("#ScrollWx").jscroll({
					W:"10px",
					BgUrl:"",//设置滚动条背景图片地址
					Bg:"#d8e899",//设置滚动条背景图片position,颜色等
					Bar:{  Pos:"up",//设置滚动条初始化位置在底部
						   Bd:{Out:"#eaf1d6",Hover:"#eaf1d6"},//设置滚动滚轴边框颜色：鼠标离开(默认)，经过
						   Bg:{Out:"#87a34d",Hover:"#677c3b",Focus:"#677c3b"}
					}, //设置滚动条滚轴背景：鼠标离开(默认)，经过，点击
					Btn:{  btn: false, //是否显示上下按钮 false为不显示
						   uBg:{Out:"#9bb055",Hover:"#9bb055",Focus:"#9bb055"},//设置上按钮背景：鼠标离开(默认)，经过，点击
						   dBg:{Out:"#9bb055",Hover:"#9bb055",Focus:"#9bb055"}
					}  //设置下按钮背景：鼠标离开(默认)，经过，点击
			});
		
		}
	});
</script><script type='text/javascript'>	$(document).ready(function(){
		//菜单背景
		$("div[flag='menu']").bind("click",function(){
			$("div[flag='menu']").each(function(i){
				$(this).css("background-color", '');
			});
			
			$('ul  li  a').each(function(i){
				$(this).removeClass("active");
			});
		
			this.blur();
			$(this).css("background-color", '#9BB055');
		});
});
</script></head><body id="sidebar_page"><div class="wrap"><div class="cotainer"><div id="sidebar" ><div class="home"><a href="<?php echo ($WebInstallDir); ?>" target="_blank"><b>访问网站首页</b></a></div><div class="con"><!--公用 start--><h2>管理首页</h2><p class="userpanel">            用户名：<?php echo ($AdminName); ?><br />            分　组：<?php echo ($AdminGroupName); ?><br /><a href="<?php echo ($Url); ?>pwd" target='main'>密 码</a>&nbsp;|&nbsp;
            <a href="<?php echo ($Url); ?>welcome" target='main'>主 页</a>&nbsp;|&nbsp;
            <a href="<?php echo ($Url); ?>logout" target="_top">退 出</a></p><!--公用 end--><?php if(is_array($MenuGroup)): $i = 0; $__LIST__ = $MenuGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mg): $mod = ($i % 2 );++$i;?><div class="item"><h2><?php echo ($mg["MenuGroupName"]); ?><span class='close'>收起</span></h2><ul  <?php if(($mg["MenuGroupID"]) == "25"): ?>id="ScrollWx"<?php endif; ?>><?php if(($mg["MenuGroupID"]) == "3"): ?><div id="ScrollChannel" style="text-align:left;overflow:hidden;"><?php if(is_array($Channel)): $i = 0; $__LIST__ = $Channel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i; if(($c["IsEnable"]) == "1"): if(!in_array(($c["ChannelID"]), explode(',',"1,2,6,7,10,11"))): ?><div id="topmenu" style="text-indent:<?php echo ($c['ChannelDepth']*12-12); ?>px; " class="depth<?php echo ($c["ChannelDepth"]); ?>"  flag="menu"><?php if(($c["ChannelDepth"]) == "1"): ?><img src="<?php echo ($Images); ?>r1.gif" align="absmiddle" /><?php else: ?><img src="<?php echo ($Images); ?>r2.gif" align="absmiddle" /><?php endif; switch($c["ChannelModelID"]): case "32": ?><a href='<?php echo ($Group); ?>/Channel/Single/ChannelID/<?php echo ($c["ChannelID"]); ?>' target='main' class="single" ><?php echo ($c["ChannelName"]); ?></a><?php break; case "37": ?><a href='<?php echo ($Group); ?>/Info/Feedback/ChannelID/<?php echo ($c["ChannelID"]); ?>' target='main' class="feedback"><?php echo ($c["ChannelName"]); ?></a><?php break; case "33": if(($c["ChannelID"] == 5) or ($c["ChannelID"] == 9)): ?><a href='<?php echo ($Group); ?>/GuestBook/index//ChannelID/<?php echo ($c["ChannelID"]); ?>' target='main' class="link"><?php echo ($c["ChannelName"]); ?></a><?php elseif(($c["ChannelID"] == 4) or ($c["ChannelID"] == 8)): ?><a href='<?php echo ($Group); ?>/job/index/ChannelID/<?php echo ($c["ChannelID"]); ?>' target='main' class="link"><?php echo ($c["ChannelName"]); ?></a><?php else: ?><a href='<?php echo ($Group); ?>/Channel/link/ChannelID/<?php echo ($c["ChannelID"]); ?>' target='main' class="link"><?php echo ($c["ChannelName"]); ?></a><?php endif; break; default: ?><a href='<?php echo ($Group); ?>/Info/Index/ChannelID/<?php echo ($c["ChannelID"]); ?>' target='main'><?php echo ($c["ChannelName"]); ?></a><?php if(($c["HasChild"]) == "0"): ?>&nbsp;&nbsp;<a href='<?php echo ($Group); ?>/Info/Add/ChannelID/<?php echo ($c["ChannelID"]); ?>' target='main'><img src="<?php echo ($Images); ?>addinfo.png" align="absmiddle" title="添加内容" alt="添加内容" /></a><?php endif; endswitch;?></div><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?></div><?php endif; if(is_array($Menu)): $i = 0; $__LIST__ = $Menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i; if(($m["MenuGroupID"]) == $mg["MenuGroupID"]): switch($m["MenuType"]): case "1": break; case "2": break; case "3": break; case "0": default: ?><li><a href='<?php echo ($Group); ?>/<?php echo ($m["MenuContent"]); ?>' target='main'><?php echo ($m["MenuName"]); ?></a></li><?php endswitch; endif; endforeach; endif; else: echo "" ;endif; ?></ul></div><?php endforeach; endif; else: echo "" ;endif; ?></div><!--/ .con--></div><!--/ sidebar--></div></div></body></html>