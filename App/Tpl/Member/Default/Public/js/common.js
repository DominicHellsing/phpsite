function saving(obj){	
	obj.value = "保存中...";
	if(obj.disabled==true){
		obj.disabled=false;
		
	}else{
		obj.disabled = "true";
	}
}

//参数顺序，msg,title
function ShowMessage(){
	var msg = arguments[0] ? arguments[0] : '';  //对话框内容
	var title = arguments[1] ? arguments[1] : '系统提示'; //标题
	var icon = arguments[2] ? arguments[2] : 'succeed'; //图标
	var time = arguments[3] ? arguments[3] : 1400; //自动关闭时间
	iconid = 'icon_'+icon;
	msg = "<div id='"+iconid+"' style='padding-left:50px;'>"+msg+"</div>";
	switch(icon){
		case 'succeed':
		$.dialog({title:title,time:time,padding:8,content:msg,id:'tipid'});
		break;
	case 'error':
		$.dialog({title:title,content:msg,id:'tipid',padding:8,okValue:'关闭',ok:function(){}});
		break;
	case 'warning':
		$.dialog({title:title,time:time,padding:8,content:msg,id:'tipid'});
		break;
	}	
}

//参数顺序：内容msg，标题title
function SucceedBox(){ShowMessage(arguments[0],arguments[1],'succeed',1200);}
function ErrorBox(){ShowMessage(arguments[0],arguments[1],'error',2000);}
function WarnBox(){ShowMessage(arguments[0],arguments[1],'warning', 1300);}

$(document).ready(function(){
	if ($.browser.msie && $.browser.version=="6.0"){
		if($("tr")){
			$("tr").bind("mouseover",function(){
				$(this).addClass("hover");
				
			})
			$("tr").bind("mouseout",function(){
				$(this).removeClass("hover");
				
			})
			
		}	
	}

});