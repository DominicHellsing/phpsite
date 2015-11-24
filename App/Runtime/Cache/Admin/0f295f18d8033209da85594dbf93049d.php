<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title><link href="<?php echo ($Css); ?>style.css" rel="stylesheet" type="text/css" /><link type="text/css" href="<?php echo ($WebPublic); ?>jquery/css/start/jquery-ui-1.8.22.custom.css" rel="stylesheet" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery-1.7.2.min.js"></script><link href="<?php echo ($WebPublic); ?>jquery/artDialog/skins/green.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/artDialog/jquery.artDialog.min.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/artDialog/artDialog.plugins.min.js"></script><script type="text/javascript" src="<?php echo ($Js); ?>common.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery-ui-1.8.22.custom.min.js"></script></head><body id="main_page"><div id="nav" style="display:none;"><dl><dt>当前位置：</dt><dd class="link">会员管理</dd><!--导航--><dd class="link">管理员信息</dd><!--导航--><dd class="link">管理员管理</dd></dl></div><script type="text/javascript">	if ($.browser.msie) {
		document.execCommand("BackgroundImageCache", false, true);
	}
	var nav = document.getElementById("nav");
	var pnav = window.parent.document.getElementById("nav")
	pnav.innerHTML = nav.innerHTML;
</script><script type="text/javascript" charset="utf-8">	function Del(id){
		if( !confirm("确定删除吗?") ) return false;
		url = "<?php echo ($Url); ?>del/AdminID/"+id+"/p/<?php echo ($NowPage); ?>";
		location.href = url;
		return true;
	}
	
	//全选
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
		var arrChk = $("input[name='AdminID[]']");
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
	
	
	function BatchLock(bLock){
		//先必须选中记录==============================================
		var arrChk = $("input[name='AdminID[]']");
		var n = 0;
		for(var i = 0; i < arrChk.length; i++){
			if(arrChk[i].checked) n++;
		}
		if( n == 0 ) {
			WarnBox("请先选中记录!");
			return;
		}
		//=========================================================
		if( bLock == 1 ){
			if( !confirm("确定锁定吗?") ) return false;
			$('#frm').attr("action", "<?php echo ($Url); ?>batchLock/Lock/1");
		}else{
			if( !confirm("确定取消锁定吗?") ) return false;
			$('#frm').attr("action", "<?php echo ($Url); ?>batchLock/Lock/0");
		}
		
		$('#frm').submit();
		return true;
	}
	
</script><script  type="text/javascript">$(function(){
	// Dialog
	$('#dlgPwd').dialog({
		modal: true,
		autoOpen: false,
		width: 310,
		height: 165,
		open: function () { $("body > div[role=dialog]").appendTo("form#frm");},
		buttons: {
			'确定': function() { //批量修改密码
				if( $('#pwd1').val() == "" ){
					WarnBox("密码不能为空！");
					$('#pwd1').focus();
					return;
				}
				if( $('#pwd2').val() == "" ){
					WarnBox("密码不能为空！");
					$('#pwd2').focus();
					return;
				}
				
				if( $('#pwd1').val() != $('#pwd2').val() ){
					WarnBox("两次输入的密码不同，请重新输入！");
					return;
				}
				$('#frm').attr("action", "<?php echo ($Url); ?>batchModifyPwd");
				$('#frm').submit();
			},
			'关闭': function() { $(this).dialog("close");}
		}
	});
	
	$('#btnPwd').click(function(){
		var arrChk = $("input[name='AdminID[]']");
		var n = 0;
		for(var i = 0; i < arrChk.length; i++){
			if(arrChk[i].checked) n++;
		}
		
		if( n == 0 ) {
			WarnBox("请先选中记录!");
			return;
		}
		
		$('#dlgPwd').dialog('open');
		return false;
	});
})
</script><div id="dlgPwd" title="批量修改管理员密码" style="display:none"><table><tr><th width="80px" nowrap="nowrap" align="right"><span style="font-weight:bold;color:blue">密码</span></th><th align="left"><input type="password" id = "pwd1" name="pwd1"  maxlength="20" class="textinput" style="width:175px" /></th></tr><tr><td nowrap="nowrap" align="right"><span style="font-weight:bold;color:blue">重复密码</span></th><td align="left"><input type="password"  id = "pwd2"  maxlength="20" name="pwd2" class="textinput" style="width:175px" /></td></tr></table></div><div class="wrap"><div class="container"><div id="main"><div class="con"><form enctype="multipart/form-data" method="post" id="frm"><input type="hidden" name="NowPage" id="NowPage" value="<?php echo ($NowPage); ?>" /><div class="table"><div style="vertical-align:middle;height:30px"><li class="toolbar"><a id="selectall" onclick="CheckAll()"  title="全选">全选</a></li><li class="toolbar"><a id="del" onclick="BatchDel()" title="批量删除">删除</a></li><li class="toolbar"><a id="btnLock" onclick="BatchLock(1)" title="批量锁定">锁定</a></li><li class="toolbar"><a id="btnUnlock" onclick="BatchLock(0)" title="批量取消锁定">取消锁定</a></li><li class="toolbar"><a id="btnPwd" title="批量修改密码">修改密码</a></li></div><table class="admin-tb" id="js_data_source"><tr><th width="35px"  nowrap="nowrap">选中</th><th width="50px" >管理员ID</th><th width="110px" >管理员名称</th><th width="95px" >所属分组</th><th width="65px" >性别</th><th width="100px" >前台用户</th><th width="120px">最后登录时间</th><th width="110px">最后登录IP</th><th width="125px" >属性</th><th style="text-align:left;padding-left:20px">操作</th></tr><?php if(is_array($Admin)): $i = 0; $__LIST__ = $Admin;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><tr id="tr<?php echo ($m["AdminID"]); ?>"><td><input type="checkbox" name="AdminID[]" value="<?php echo ($m["AdminID"]); ?>" /></td><td><?php echo ($m["AdminID"]); ?></td><td><?php echo ($m["AdminName"]); ?></td><td><b><?php echo ($m["AdminGroupName"]); ?></b></td><td><?php if(($m["AdminGender"]) == "0"): ?>男<?php else: ?>女<?php endif; ?></td><td><?php echo ($m["MemberName"]); ?></td><td><?php echo (yd_friend_date(strtotime($m["LastLoginTime"]))); ?></td><td><?php echo ($m["LastLoginIP"]); ?></td><td><?php if(($m["IsLock"]) == "1"): ?><span style="color:#F00">锁定</span><?php endif; if(($m["IsSystem"]) == "1"): ?><span style="color:#F00">系统</span><?php endif; if(($m["IsCheck"]) == "0"): ?><span style="color:#F00">未审核</span><?php endif; ?></td><td style="text-align:left;padding-left:5px"><a style="float:left" id="btnEdit" name="btnEdit" href="<?php echo ($Url); ?>Modify/AdminID/<?php echo ($m["AdminID"]); ?>">修改</a><?php if(($m["IsSystem"]) != "1"): ?><div style="float:left;width:3px">&nbsp;</div><a style="float:left" onclick="Del(<?php echo ($m["AdminID"]); ?>)" class="btnDel">删除</a><?php endif; ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?></table><div class="th"><div class="page" ><?php echo ($Page); ?></div></div></div></form></div><!--/ con--></div></div><!--/ container--></div><!--/ wrap--></body></html>