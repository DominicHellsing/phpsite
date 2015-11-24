<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title><link href="<?php echo ($Css); ?>style.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery-1.7.2.min.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery.form.js"></script><link href="<?php echo ($WebPublic); ?>jquery/artDialog/skins/green.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/artDialog/jquery.artDialog.min.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/artDialog/artDialog.plugins.min.js"></script><script type="text/javascript" src="<?php echo ($Js); ?>common.js"></script></head><body id="main_page"><div id="nav" style="display:none;"><dl><dt>当前位置：</dt><dd class="link">管理首页</dd><dd class="link">系统设置</dd><dd class="link">上传设置</dd></dl></div><script type="text/javascript">	if ($.browser.msie) {
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
</script><div class="wrap"><div class="container"><div id="main"><div class="con box-green"><form enctype="multipart/form-data" id="frmConfig" method="post" action="<?php echo ($Action); ?>"><div class="box-header"><h4>文件上传设置</h4></div><div class="box-content"><table class="table-font"><tr><th class="w120">上传目录</th><td><input disabled="disabled" type="text" class="textinput w360" name="UPLOAD" value="<?php echo ($Upload); ?>" /></td></tr><tr><th>允许上传文件类型</th><td><input type="text" class="textinput w360" name="UPLOAD_FILE_TYPE" value="<?php echo ($UploadFileType); ?>"  /><span class='Caution'>文件类型以竖线“|”隔开，如：jpg|png|bmp|gif|rar|zip</span></td></tr><tr><th class="w120">最大上传文件大小</th><td><input type="text" class="textinput w360" name="MAX_UPLOAD_SIZE" value="<?php echo ($MaxUploadSize); ?>" /><span class='Caution'>单位：字节(B)&nbsp;&nbsp;1M=1024K&nbsp;&nbsp;1K=1024B&nbsp;&nbsp;默认为5M(5242880)</span></td></tr><tr style="color:#F30; font-size:12px;font-weight:bold"><th class="w120">注意：</th><td>[1]系统检测到您的Web服务器最大上传文件大小为<b style="color:#00F"><?php echo ini_get('upload_max_filesize');?></b>，如需修改此值，请联系Web服务器提供商<br />           [2]超过此大小的文件请使用FTP上传</td></tr></table></div><div class="box-footer"><div class="box-footer-inner"><input  id="btnSubmit"  type="submit" value="保存设置" /></div></div></form></div><!--/ con--></div></div><!--/ container--></div><!--/ wrap--></body></html>