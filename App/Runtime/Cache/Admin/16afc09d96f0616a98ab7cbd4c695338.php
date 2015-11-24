<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title><link href="<?php echo ($Css); ?>style.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery-1.7.2.min.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery.form.js"></script><link href="<?php echo ($WebPublic); ?>jquery/artDialog/skins/green.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/artDialog/jquery.artDialog.min.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/artDialog/artDialog.plugins.min.js"></script><script type="text/javascript" src="<?php echo ($Js); ?>common.js"></script></head><body id="main_page"><div id="nav" style="display:none;"><dl><dt>当前位置：</dt><dd class="link">管理首页</dd><dd class="link">系统设置</dd><dd class="link">联系方式</dd></dl></div><script type="text/javascript">	if ($.browser.msie) {
		document.execCommand("BackgroundImageCache", false, true);
	}
	var nav = document.getElementById("nav");
	var pnav = window.parent.document.getElementById("nav")
	pnav.innerHTML = nav.innerHTML;
</script><script type="text/javascript">	$(document).ready(function(){
		$('#frmConfig').ajaxForm({
			success: complete,
			dataType: 'json'
		});
		
		function complete(data){
			if (data.status==1){
				SucceedBox(data.info);
            }else if(data.status==0){
				ErrorBox(data.info);
			}
		};
		
		 $('#frmConfig').submit(function(){  // 提交表单
	     	return false;
	     });
	});
</script><div class="wrap"><div class="container"><div id="main"><div class="con box-green"><form id="frmConfig" method="post" action="<?php echo ($Action); ?>"  enctype="multipart/form-data"><div class="box-header"><h4>联系方式</h4></div><div class="box-content"><table class="table-font"><tr><th class="w120">公司名称</th><td><input type="text" class="textinput" style="width:650px" name="COMPANY" value="<?php echo ($Company); ?>" /></td></tr><tr><th>联系人</th><td><input type="text" class="textinput" style="width:650px" name="CONTACT" value="<?php echo ($Contact); ?>"  /></td></tr><tr><th class="w120">手机</th><td><input type="text" class="textinput" style="width:650px" name="MOBILE" value="<?php echo ($Mobile); ?>" /></td></tr><tr><th>固定电话</th><td><input type="text" class="textinput" style="width:650px" name="TELEPHONE" value="<?php echo ($Telephone); ?>"  /></td></tr><tr><th>传真</th><td><input type="text" class="textinput" style="width:650px" name="FAX" value="<?php echo ($Fax); ?>"  /></td></tr><tr><th class="w120">电子邮件</th><td><input type="text" class="textinput"  style="width:650px" name="EMAIL" value="<?php echo ($Email); ?>" /></td></tr><tr style="display:none" comment="取消qq号码，统一从在线客服中获取"><th class="w120">QQ号码</th><td><input type="text" class="textinput" style="width:650px" name="QQ" value="<?php echo ($QQ); ?>" /></td></tr><tr><th>邮政编码</th><td><input type="text" class="textinput" style="width:650px" name="POSTCODE" value="<?php echo ($PostCode); ?>"  /></td></tr><tr><th class="w120">联系地址</th><td><input type="text" class="textinput" style="width:650px" name="ADDRESS" value="<?php echo ($Address); ?>" /></td></tr></table></div><div class="box-footer"><div class="box-footer-inner"><input  id="btnSubmit"  type="submit" value="保存设置" /></div></div></form></div><!--/ con--></div></div><!--/ container--></div><!--/ wrap--></body></html>