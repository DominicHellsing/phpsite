function saving(obj){	
	obj.value = "保存中...";
	if(obj.disabled==true){
		obj.disabled=false;
		
	}else{
		obj.disabled = "true";
	}
}

//刷新左侧框架
function RefreshLeftFrame(){
	try{
		window.parent.frames["menu"].location.reload();
	}catch(e){
		;
	}
}


//参数顺序，msg,title
function ShowMessage(){
	var msg = arguments[0] ? arguments[0] : '';  //对话框内容
	var title = arguments[1] ? arguments[1] : '友情提示'; //标题
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
function LoadBox(){
	var d = $.dialog.get('tipid');
	if(d) d.close();
	var msg = arguments[0] ? arguments[0] : '数据处理中，请稍后...';
	$.dialog({
		title:'友情提示',
		padding:6,
		content:"<div id='icon_load' style='color:black;font-weight:bold;padding-left:25px'>"+msg+"&nbsp;&nbsp;&nbsp;&nbsp;</b>",
		id:'tipload'
	});
}
function CloseLoadBox(){
	var d = $.dialog.get('tipload');
	if(d) d.close();
}

		
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

// 在光标处插入字符串
// myField, 文本框对象 document.getElementByID('')获取
// 要插入的值
function insertAtCursor(myField, myValue) 
{
	//IE support
	if (document.selection) 
	{
		myField.focus();
		sel            = document.selection.createRange();
		sel.text    = myValue;
		sel.select();
	}
	//MOZILLA/NETSCAPE support
	else if (myField.selectionStart || myField.selectionStart == '0') 
	{
		var startPos    = myField.selectionStart;
		var endPos        = myField.selectionEnd;
		// save scrollTop before insert
		var restoreTop    = myField.scrollTop;
		myField.value    = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos, myField.value.length);
		if (restoreTop > 0)
		{
			// restore previous scrollTop
			myField.scrollTop = restoreTop;
		}
		myField.focus();
		myField.selectionStart    = startPos + myValue.length;
		myField.selectionEnd    = startPos + myValue.length;
	} else {
		myField.value += myValue;
		myField.focus();
	}
}

jQuery.fn.extend({
	/**  
	 * 选中内容  
	 */  
	selectContents: function(){   
		$(this).each(function(i){   
			var node = this;   
			var selection, range, doc, win;   
			if ((doc = node.ownerDocument) &&   
				(win = doc.defaultView) &&   
				typeof win.getSelection != 'undefined' &&   
				typeof doc.createRange != 'undefined' &&   
				(selection = window.getSelection()) &&   
				typeof selection.removeAllRanges != 'undefined')   
			{   
				range = doc.createRange();   
				range.selectNode(node);   
				if(i == 0){   
					selection.removeAllRanges();   
				}   
				selection.addRange(range);   
			}   
			else if (document.body &&   
					 typeof document.body.createTextRange != 'undefined' &&   
					 (range = document.body.createTextRange()))   
			{   
				range.moveToElementText(node);   
				range.select();   
			}   
		});   
	},   
	/**  
	 * 初始化对象以支持光标处插入内容  
	 */  
	setCaret: function(){   
		if(!$.browser.msie) return;   
		var initSetCaret = function(){   
			var textObj = $(this).get(0);   
			textObj.caretPos = document.selection.createRange().duplicate();   
		};   
		$(this)   
		.click(initSetCaret)   
		.select(initSetCaret)   
		.keyup(initSetCaret);   
	},   
	/**  
	 * 在当前对象光标处插入指定的内容  
	 */  
	insertAtCaret: function(textFeildValue){   
	   var textObj = $(this).get(0);   
	   if(document.all && textObj.createTextRange && textObj.caretPos){   
		   var caretPos=textObj.caretPos;   
		   caretPos.text = caretPos.text.charAt(caretPos.text.length-1) == '' ?   
							   textFeildValue+'' : textFeildValue;   
	   }   
	   else if(textObj.setSelectionRange){   
		   var rangeStart=textObj.selectionStart;   
		   var rangeEnd=textObj.selectionEnd;   
		   var tempStr1=textObj.value.substring(0,rangeStart);   
		   var tempStr2=textObj.value.substring(rangeEnd);   
		   textObj.value=tempStr1+textFeildValue+tempStr2;   
		   textObj.focus();   
		   var len=textFeildValue.length;   
		   textObj.setSelectionRange(rangeStart+len,rangeStart+len);   
		   textObj.blur();   
	   }   
	   else {   
		   textObj.value+=textFeildValue;   
	   }   
	}   
}); 