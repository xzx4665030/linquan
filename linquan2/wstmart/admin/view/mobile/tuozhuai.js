$(function(){
	$('.sss').mousedown(function(e){
		var thisx=$(".ddd").position().left;//获取被拖动的div  left值
		var thisy=$(".ddd").position().top;//获取被拖动的div  top值
		var chax=thisx-e.pageX;     //获取被拖动的div左上角和鼠标按下点的 横向距离
		var chay=thisy-e.pageY;		 //获取被拖动的div左上角和鼠标按下点的 纵向距离
		$("body").on("mousemove",function(e){    //鼠标移动事件
			$(".ddd").css("left",(e.pageX+chax)+'px');  //鼠标移动后 现在的x坐标和距离差值赋值给被拖动div的left值
			$(".ddd").css("top",(e.pageY+chay)+'px');	//鼠标移动后 现在的x坐标和距离差值赋值给被拖动div的top值
		})
	})
	//鼠标放开事件
	$('.sss').mouseup(function(){
		$("body").off("mousemove")  //解除鼠标移动事件
	})
})
