<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title><link href="<?php echo ($Css); ?>style.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery-1.7.2.min.js"></script></head><body><div class="wrap"><div class="container"><div id="header"><div class="con"><div id="logo"><a href="<?php echo ($Url); ?>welcome" title="<?php echo ($CMSName); ?>后台" target="main">{CMSName}后台</a></div><div id="menu"><div class="item"><ul><?php if(is_array($MenuTop)): $i = 0; $__LIST__ = $MenuTop;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i; if($m["IsActive"] == '1'): ?><li class="index"><a href="<?php echo ($Group); ?>/<?php echo ($m["MenuTopUrl"]); ?>/MenuTopID/<?php echo ($m["MenuTopID"]); ?>" id="item<?php echo ($m["MenuTopID"]); ?>" target="<?php echo ($m["MenuTopTarget"]); ?>" mid="<?php echo ($m["MenuTopID"]); ?>" class="active" onclick="Tabmenu(this,<?php echo ($m["MenuTopID"]); ?>);"><?php echo ($m["MenuTopName"]); ?></a></li><?php else: ?><li><a href="<?php echo ($Group); ?>/<?php echo ($m["MenuTopUrl"]); ?>/MenuTopID/<?php echo ($m["MenuTopID"]); ?>" id="item<?php echo ($m["MenuTopID"]); ?>" target="<?php echo ($m["MenuTopTarget"]); ?>"  mid="<?php echo ($m["MenuTopID"]); ?>" onclick="Tabmenu(this,<?php echo ($m["MenuTopID"]); ?>);"><?php echo ($m["MenuTopName"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?></ul></div></div><!--/ menu--><?php if(!empty($Language)): ?><div id="language"><div><ul><?php if(is_array($Language)): $i = 0; $__LIST__ = $Language;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><li><a <?php if(($l["LanguageMark"]) == $AdminLanguageMark): ?>class="active"<?php endif; ?>  onclick="ChangeLng(this,'<?php echo ($l["LanguageMark"]); ?>','<?php echo ($Url); ?>','lng<?php echo ($l["LanguageID"]); ?>')" target="main"><?php echo ($l["LanguageName"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div></div><?php endif; ?></div><!--/ con--></div><!--/ header--></div></div><script type="text/javascript">function ChangeLng(obj,mark,url,id){
	var Items = document.getElementById("language").getElementsByTagName("a");
	for(var i= 0,len = Items.length;i<len;++i){
		if(Items[i].clssName !==""){
			Items[i].className = "";
		}
	}
	obj.className = "active";
	
	//获取当前顶层菜单ID
	var mid = 0;
	var Items = document.getElementById("menu").getElementsByTagName("a");
	for(var i= 0,len = Items.length;i<len;++i){
		if(Items[i].className == "active"){
			mid = Items[i].getAttribute('mid');
			break;
		}
	}
	
	if(mid == 3){ //内容频道需要刷新左侧菜单
		RefreshChannel(obj,mark);
	}else{
		RefreshMain(obj,mark);
	}
}

function RefreshChannel(obj,mark){
	var t = new Date().getTime();
	var url = window.parent.frames["menu"].location.href;
	var p = url.indexOf("/l/");
	if( p > 0){
	  url = url.substring(0, p);
	}
	obj.target = "menu";
	obj.href = url+"/l/"+mark+"/random/"+t;
	var mainUrl = window.parent.frames["main"].location.href;
	var objUrl = "<?php echo ($Url); ?>welcome";
	var index = mainUrl.toLowerCase().indexOf( objUrl.toLowerCase()  );
	if( index == -1  ){
		window.parent.frames["main"].location.href = "<?php echo ($Url); ?>welcome";
	}
	return true;
}

function RefreshMain(obj,mark){
	var t = new Date().getTime();
	var url = window.parent.frames["main"].location.href;
	var p = url.indexOf("/l/");
	if( p > 0){
	  url = url.substring(0, p);
	}
	obj.target = "main";
	obj.href = url+"/l/"+mark+"/random/"+t;
	return true;
}


function Tabmenu(obj,n){
	var Items = document.getElementById("menu").getElementsByTagName("a");
	for(var i= 0,len = Items.length;i<len;++i){
		if(Items[i].className !==""){
			Items[i].className = "";
		}
	}
	obj.className = "active";
	obj.blur();
	location.hash = n;
	return true;
};

(function(){
	var n = <?php echo ($MenuTopID); ?>;
	var curitem = document.getElementById("item"+n);
	Tabmenu(curitem, n);
})();
</script><script>/*
document.onkeydown = function(e){
	//捕获Ctrl+Del组合键盘
	if(e.ctrlKey && e.keyCode == 46){
		var url = "__GROUP__/public/clearCache/Action/systemcache";
		$.get(url, {}, function(data){
		   if (data.status==1){
				alert(data.info);
            }else{ //添加频道失败
				alert(data.info);
			}
		}, "json");
	}
}
*/
</script></body></html>