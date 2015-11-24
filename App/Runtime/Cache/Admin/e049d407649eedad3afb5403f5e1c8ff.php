<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title><link href="<?php echo ($Css); ?>style.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery-1.7.2.min.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery.form.js"></script><link href="<?php echo ($WebPublic); ?>jquery/artDialog/skins/green.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/artDialog/jquery.artDialog.min.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/artDialog/artDialog.plugins.min.js"></script><script type="text/javascript" src="<?php echo ($Js); ?>common.js"></script></head><body id="main_page"><div id="nav" style="display:none;"><dl><dt>当前位置：</dt><dd class="link">管理首页</dd><dd class="link">系统设置</dd><dd class="link">其它设置</dd></dl></div><script type="text/javascript">	if ($.browser.msie) {
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
</script><div class="wrap"><div class="container"><div id="main"><div class="con box-green"><form  enctype="multipart/form-data" id="frmConfig" method="post" action="<?php echo ($Action); ?>"><div class="box-header"  id="c3"><h4>其它设置</h4></div><div class="box-content"><table class="table-font"><tr><th nowrap="nowrap" style="width:20%">删除记录时是否同时删除图片和附件</th><td style="width:80%"><label><input type="radio" name="AUTO_DEL_ENABLE" value="1" <?php if(($AutoDelEnable) == "1"): ?>checked="checked"<?php endif; ?> />是</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="AUTO_DEL_ENABLE" value="0" <?php if(($AutoDelEnable) == "0"): ?>checked="checked"<?php endif; ?> />否</label></td></tr><tr><th nowrap="nowrap">是否自动上传远程图片</th><td><label><input type="radio" name="AUTO_UPLOAD_ENABLE" value="1" <?php if(($AutoUploadEnable) == "1"): ?>checked="checked"<?php endif; ?> />是</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="AUTO_UPLOAD_ENABLE" value="0" <?php if(($AutoUploadEnable) == "0"): ?>checked="checked"<?php endif; ?> />否</label><span class='Caution'>启用后，将自动上传文章中的远程图片</span></td></tr><tr><th nowrap="nowrap">是否删除非站内链接</th><td><label><input type="radio" name="DEL_LINK_ENABLE" value="1" <?php if(($DelLinkEnable) == "1"): ?>checked="checked"<?php endif; ?> />是</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="DEL_LINK_ENABLE" value="0" <?php if(($DelLinkEnable) == "0"): ?>checked="checked"<?php endif; ?> />否</label><span class='Caution'>启用后，将删除非站内链接，允许的站外链接除外</span></td></tr><tr><th>允许的站外链接</th><td><input type="text" class="textinput w450" name="ALLOW_LINK" value="<?php echo ($AllowLink); ?>" /><span class='Caution'>链接以竖线“|”分割，如：google.com|baidu.com</span></td></tr></table></div><div class="box-footer"><div class="box-footer-inner"><input  id="btnSubmit"  type="submit" value="保存设置" /></div></div></form></div><!--/ con--></div></div><!--/ container--></div><!--/ wrap--></body></html>