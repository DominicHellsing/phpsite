<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title><link href="<?php echo ($Css); ?>style.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery-1.7.2.min.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/jquery.form.js"></script><link href="<?php echo ($WebPublic); ?>jquery/artDialog/skins/green.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/artDialog/jquery.artDialog.min.js"></script><script type="text/javascript" src="<?php echo ($WebPublic); ?>jquery/artDialog/artDialog.plugins.min.js"></script><script type="text/javascript" src="<?php echo ($Js); ?>common.js"></script></head><body id="main_page"><div id="nav" style="display:none;"><dl><dt>当前位置：</dt><dd class="link">互动管理</dd><dd class="link">在线客服</dd><dd class="link">第三方在线客服</dd><!--导航--></dl></div><script type="text/javascript">	if ($.browser.msie) {
		document.execCommand("BackgroundImageCache", false, true);
	}
	var nav = document.getElementById("nav");
	var pnav = window.parent.document.getElementById("nav")
	pnav.innerHTML = nav.innerHTML;


</script><script type="text/javascript">	$(document).ready(function(){
		$('#frmAdd').ajaxForm({
			success: complete,
			dataType: 'json'
		});
		
		function complete(data){
			if (data.status==1){
				SucceedBox(data.info);
				$('#Support3Js').focus();
            }else{
				ErrorBox(data.info);
			}
		};
		
		 $('#frmAdd').submit(function(){  // 提交表单
	     	return false;  //为了防止普通浏览器进行表单提交和产生页面导航（防止页面刷新？）返回false  
	     });
		 
		 $('#Support3Js').focus();
	});
</script><div class="wrap"><div class="container"><div id="main"><div class="con box-green"><form enctype="multipart/form-data" action="<?php echo ($Action); ?>" method="post" id="frmAdd"><?php if(($IsSave) == "1"): ?><input type="hidden" name="Support3ID" value="<?php echo ($Support3ID); ?>" /><?php endif; if(is_array($Group)): $i = 0; $__LIST__ = $Group;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$g): $mod = ($i % 2 );++$i;?><div class="box-header"><h4><?php echo ($g["DisplayName"]); ?></h4></div><div class="box-content"><table class="table-font"><?php if(is_array($Attribute)): $i = 0; $__LIST__ = $Attribute;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$a): $mod = ($i % 2 );++$i; if(($a["GroupID"]) == $g["AttributeID"]): ?><tr><th class="w120"><?php echo ($a["DisplayName"]); ?></th><td><?php echo ($a["html"]); ?></td></tr><?php endif; endforeach; endif; else: echo "" ;endif; ?></table></div><?php endforeach; endif; else: echo "" ;endif; ?><div class="box-footer"><div class="box-footer-inner"><input  id="btnSubmit"  type="submit" value="保存" /></div></div></form></div><!--/ con--></div></div><!--/ container--></div><!--/ wrap--></body></html>