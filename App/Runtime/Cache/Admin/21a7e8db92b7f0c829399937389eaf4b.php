<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><link href="<?php echo ($Css); ?>style.css" rel="stylesheet" type="text/css" /><link href="<?php echo ($WebPublic); ?>jquery/jquery.powerFloat.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery-1.7.2.min.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery.form.js"></script><link href="<?php echo ($WebPublic); ?>jquery/artDialog/skins/green.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/artDialog/jquery.artDialog.min.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/artDialog/artDialog.plugins.min.js"></script><script type="text/javascript" src="<?php echo ($Js); ?>common.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery.powerFloat.min.js"></script><script type='text/javascript' src='<?php echo ($WebPublic); ?>ckfinder/ckfinder.js'></script><script type='text/javascript'>	function BrowserServer(){
		var finder = new CKFinder();
		finder.basePath = '<?php echo ($WebPublic); ?>ckfinder'; 
		finder.selectActionFunction = SetFileField;
		//alert('d'); //加上alert指令后，popup都能弹出对话框
		finder.popup(); 
	}
	function SetFileField(fileUrl){
		//如果执行抛出异常，则finder.popup()后的框不会关闭
		document.getElementById('WEB_LOGO').value = fileUrl;
	}
	
	function BrowserIconServer(){
		var finder = new CKFinder();
		finder.basePath = '<?php echo ($WebPublic); ?>ckfinder'; 
		finder.selectActionFunction = SetIconField;
		finder.popup(); 
	}
	
	function SetIconField(fileUrl){
		//如果执行抛出异常，则finder.popup()后的框不会关闭
		document.getElementById('WEB_ICON').value = fileUrl;
	}
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
			}else if(data.status==2){
				ErrorBox(data.info); //上传失败
			}else if(data.status==3){
				$('#WEB_LOGO').val(data.data);
				SucceedBox(data.info); //上传成功
			}else if(data.status==4){
				$('#WEB_ICON').val(data.data);
				SucceedBox(data.info); //上传成功
			}
		};
			 
	     //上传提交表单,注意：这里的上传地址不能实用$UploadAction因为和上传设置config/upload冲突
		 $('#btnUpload').click(function(){
		 	$('#frmConfig').attr('action','__GROUP__/public/upload/addwater/no');
	     });
		 
		 $('#btnIconUpload').click(function(){  
		 	var url = $("#webiconfile").val();
			if(url == ""){
				ErrorBox("图像不能为空！");
				return;
			}
			var pos = url.lastIndexOf(".")+1;
			var ext = url.substring(pos);
			if( ext.toLowerCase() != "ico"){
				ErrorBox("图像格式必须为ico格式！");
				return;
			}
		 	$('#frmConfig').attr('action','__GROUP__/public/upload/addwater/no/flag/4');
	     });
		 
		 //保存提交
		 $('#btnSubmit').click(function(){
		 	$('#frmConfig').attr('action','<?php echo ($Action); ?>');
	     });
		 
		 $('#frmConfig').submit(function(){  // 提交表单
	     	return false;
	     });
		 
		 $("#WEB_LOGO").powerFloat({
			targetMode: "ajax",
			targetAttr: "value",
			position: "5-7"
		});
		
		$("#WEB_ICON").powerFloat({
			targetMode: "ajax",
			targetAttr: "value",
			position: "5-7"
		});
	});
</script></head><body id="main_page"><div id="nav" style="display:none;"><dl><dt>当前位置：</dt><dd class="link">管理首页</dd><dd class="link">系统设置</dd><dd class="link">基本设置</dd></dl></div><script type="text/javascript">	if ($.browser.msie) {
		document.execCommand("BackgroundImageCache", false, true);
	}
	var nav = document.getElementById("nav");
	var pnav = window.parent.document.getElementById("nav");
	pnav.innerHTML = nav.innerHTML;
</script><div class="wrap"><div class="container"><div id="main"><div class="con box-green"><form id="frmConfig" method="post" action="<?php echo ($Action); ?>" enctype="multipart/form-data" ><div class="box-header" id="c1"><h4>基本设置</h4></div><div class="box-content"><table class="table-font"><tr><th>网站名称</th><td><input type="text" class="textinput w450" name="WEB_NAME" value="<?php echo ($WebName); ?>" /></td></tr><tr><th>网站域名</th><td><input type="text" class="textinput w450" name="WEB_URL" value="<?php echo ($WebUrl); ?>"  /><span class='Caution'>域名以http://开头。系统检测到你的域名是：<b style="color:#F30"><?php echo get_web_url();?></b></span></td></tr><tr><th>网站Logo</th><td><input type="text" id="WEB_LOGO" class="textinput w450" name="WEB_LOGO" value="<?php echo ($WebLogo); ?>"  /><span class='Caution'>鼠标移动到文本框可以预览Logo</span><br/><input id='weblogofile' name ='weblogofile' type ='file'  size='70'  class='textinput' />&nbsp;&nbsp;<input id='btnUpload' name ='btnUpload'  type ='submit' value='上传图片'   />&nbsp;&nbsp;<input id='btnServer' onclick='BrowserServer()' name ='btnServer'  type ='button' value='选择图片'   /></td></tr><tr><th>网站地址栏图标</th><td><input type="text" id="WEB_ICON" class="textinput w450" name="WEB_ICON" value="<?php echo ($WebIcon); ?>"  /><span class='Caution'> 推荐上传32x32的ico图标，如无法看到新上传的图标，请清空浏览器缓存，并重启浏览器！<br/><input id='webiconfile' name ='webiconfile' type ='file'  size='70'  class='textinput' />&nbsp;&nbsp;
                            <input id='btnIconUpload' name ='btnIconUpload'  type ='submit' value='上传图片'   />&nbsp;&nbsp;
                            <input id='btnIconServer' onclick='BrowserIconServer()' name ='btnIconServer'  type ='button' value='选择图片'   /><br/><span class='Caution' style="color:#F30">                            在线制作ico网址推荐：<a href="http://www.bitbug.net" target="_blank">http://www.bitbug.net</a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="http://www.ico.la" target="_blank">http://www.ico.la</a></span></td></tr><tr><th>网站ICP备案信息</th><td><input type="text" class="textinput w450" name="WEB_ICP" value="<?php echo ($WebICP); ?>" /></td></tr><tr><th>网站状态</th><td><label><input type="radio" name="WEB_STATUS" value="1" <?php if(($WebStatus) == "1"): ?>checked="checked"<?php endif; ?> />打开</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="WEB_STATUS" value="0" <?php if(($WebStatus) == "0"): ?>checked="checked"<?php endif; ?> />关闭</label></td></tr><tr><th>关闭网站原因</th><td><textarea class="w450" style="height:40px" name="WEB_CLOSE_REASON"><?php echo ($WebCloseReason); ?></textarea></td></tr><tr><th>脏话过滤</th><td><textarea class="w450" style="height:60px" name="WEB_BAD_WORDS"><?php echo ($WebBadWords); ?></textarea><span class='Caution'>格式：“脏话词=替换词”，每行词设置以回车分开！如：他妈的=***</span></td></tr><tr><th>IP过滤</th><td><textarea class="w450" style="height:60px" name="WEB_BAD_IP"><?php echo ($WebBadIP); ?></textarea><span class='Caution'>支持通配符*(表示所有)，例如：202.103.23.* 表示202.103.23.0到202.103.23.255之间的IP</span></td></tr><tr><th>是否启用调试模式</th><td><label><input type="radio" name="APP_DEBUG" value="1" <?php if(($AppDebug) == "1"): ?>checked="checked"<?php endif; ?> />是</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="APP_DEBUG" value="0" <?php if(($AppDebug) == "0"): ?>checked="checked"<?php endif; ?> />否</label><span class='Caution'>启用调试模式后，系统将保存各种状态日志，同时禁止缓存数据，有利于调试，但会影响速度！网站正式上线后，请关闭调试模式！</span></td></tr></table></div><div class="box-footer"><div class="box-footer-inner"><input id="btnSubmit" type="submit" value="保存设置" /></div></div></form></div><!--/ con--></div></div><!--/ container--></div><!--/ wrap--></body></html>