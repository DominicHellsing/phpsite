<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title><link href="<?php echo ($Css); ?>style.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery-1.7.2.min.js"></script><link href="<?php echo ($WebPublic); ?>jquery/artDialog/skins/green.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/artDialog/jquery.artDialog.min.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/artDialog/artDialog.plugins.min.js"></script><script type="text/javascript" src="<?php echo ($Js); ?>common.js"></script></head><body id="main_page"><div id="nav" style="display:none;"><dl><dt>当前位置：</dt><dd class="link">会员管理</dd><dd class="link">管理员分组</dd><!--导航--><dd class="link">管理员分组管理</dd><!--导航--></dl></div><script type="text/javascript">	if ($.browser.msie) {
		document.execCommand("BackgroundImageCache", false, true);
	}
	var nav = document.getElementById("nav");
	var pnav = window.parent.document.getElementById("nav")
	pnav.innerHTML = nav.innerHTML;
</script><script type="text/javascript" charset="utf-8">	function Del(id){
		if( !confirm("确定删除吗?") ) return false;
		url = "<?php echo ($Url); ?>Del/AdminGroupID/"+id;
		$.get(url, {}, DelComplete, "json");
		return true;
	}
	
	//回调函数
	function DelComplete(data, textStatus){
		if (data.status == 1){
			$(data.data).css("display","none");
		}else{ //删除失败
			ErrorBox(data.info);
		}
	}
</script><script type="text/javascript" charset="utf-8">	//全选
	function CheckAll(){
		var title = $("#selectall").attr('title');
		if(title == "全选"){
			$(":checkbox").attr('checked', true);
			$("#selectall").attr('title','取消');
			$("#selectall").html('取消');
		}else{
			$(":checkbox").attr('checked', false);
			$("#selectall").attr('title','全选');
			$("#selectall").html('全选');
		}
	}
	
		//批量删除
	function BatchDel(){
		//var arrChk = $("input[name='InfoID[]'][checked]"); //在高速浏览器长度总是返回0
		var arrChk = $("input[name='AdminGroupID[]']");
		var n = 0;
		for(var i = 0; i < arrChk.length; i++){
			if(arrChk[i].checked) n++;
		}
		
		if( n == 0 ) {
			WarnBox("请选中要删除的记录!");
			return;
		}
		
		if( !confirm("确定删除吗?") ) return false;
		$('#frm').attr("action", "<?php echo ($Url); ?>batchDel");
		$('#frm').submit();
		return true;
	}
</script><div class="wrap"><div class="container"><div id="main"><div class="con"><form enctype="multipart/form-data" method="post" id="frm"><div class="table"><div style="vertical-align:middle;height:30px"><li class="toolbar"><a id="btnSaveAll" href="<?php echo ($Url); ?>Add"  title="添加管理员分组" target="_self">添加管理员组</a></li><li class="toolbar"><a id="selectall" onclick="CheckAll()"  title="全选">全选</a></li><li class="toolbar"><a id="del" onclick="BatchDel()" title="批量删除">删除</a></li></div><table class="admin-tb" id="js_data_source"><tr><th width="45px"  nowrap="nowrap">选中</th><th width="90px" >管理员分组ID</th><th width="140px" >管理员分组名称</th><th width="400px" >管理员分组备注</th><th width="90px" >属性</th><th style="text-align:left;padding-left:20px">操作</th></tr><?php if(is_array($AdminGroup)): $i = 0; $__LIST__ = $AdminGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ag): $mod = ($i % 2 );++$i;?><tr id="tr<?php echo ($ag["AdminGroupID"]); ?>"><td><input type="checkbox" name="AdminGroupID[]" value="<?php echo ($ag["AdminGroupID"]); ?>" /></td><td><?php echo ($ag["AdminGroupID"]); ?></td><td><b><?php echo ($ag["AdminGroupName"]); ?></b></td><td><?php echo ($ag["AdminGroupRemark"]); ?></td><td><?php if(($ag["IsSystem"]) == "1"): ?><span style="color:#F00">系统</span><?php else: ?><span style="color:green">自定义</span><?php endif; ?></td><td style="text-align:left;padding-left:5px"><a style="float:left" href="<?php echo ($Url); ?>Modify/AdminGroupID/<?php echo ($ag["AdminGroupID"]); ?>" id="btnEdit">修改</a><div style="float:left;width:3px">&nbsp;</div><?php if(($ag["IsSystem"]) == "0"): ?><a style="float:left" onclick="Del(<?php echo ($ag["AdminGroupID"]); ?>)" class="btnDel">删除</a><?php endif; ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?></table><div class="th"><div class="form"  id="notice"><b>说明：</b>不能删除属性为系统的管理组！</div></div></div></form></div><!--/ con--></div></div><!--/ container--></div><!--/ wrap--></body></html>