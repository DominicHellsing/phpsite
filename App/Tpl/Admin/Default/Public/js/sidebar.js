$(document).ready(function(){
	$('ul li a').bind("click",function(){
		$('ul  li  a').each(function(i){
			$(this).removeClass("active");
		});
		
		$("div[flag='menu']").each(function(i){
			$(this).css("background-color", '');
		});
			
		this.blur();
		this.className = "active";
	});
	$('#sidebar .con h2 span').bind("click",function(){
		if(this.className == "close"){
			this.className = "open";
			$(this.parentNode.parentNode).find("ul").hide()
		}else{
			this.className = "close";
			$(this.parentNode.parentNode).find("ul").show()
		}
	
	})
});

