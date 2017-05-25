var  zTreeA,ugridA, zTreeB,ugridB, zTreeC,ugridC, zTreeD,ugridD,zTreeE,ugridE,h,w;
$(function(){
	var flagB = true;
//	var flagC = true;
//	var flagD = true;
//	var flagE = true;
	h = WST.pageHeight();
	w = WST.pageWidth();

	$('.l-tab-content').height(h-40);
	$('.l-tab-content-item').height(h-40);
	$('.l-tab-content-item').css('overflow','hidden');
	$(window).resize(function(){
		w = WST.pageWidth();
		h = WST.pageHeight();
		$('.l-tab-content').height(h-40);
		$('.l-tab-content-item').height(h-40);
		AshopGridInitA();
		AshopGridInitB();
//		AshopGridInitC();
//		AshopGridInitD();
//		AshopGridInitE();
	})
	var tab = $("#wst-tabs").ligerTab({
         height: '99%',
         changeHeightOnResize:true,
         showSwitchInTab : false,
         showSwitch: false,
         onAfterSelectTabItem:function(n){
           if(n=='shopsB'){
              if(flagB){
                shopGridInitB();
                flaB = false;
              }
           }
         }
    })
    shopGridInitA();
})
function shopGridInitA(){
	$("#startDateA").ligerDateEditor();
	$("#endDateA").ligerDateEditor();
	ugridA =  $("#maingridA").ligerGrid({
		url:WST.U('admin/datas/get_stock'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-110,
        width:w-230,
        minColToggle:6,
        rownumbers:true,
       columns: [
	        { display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x1" onclick="WST.checkChks(this,\'.chk_x1\')"/><label for="chk_x1">全选</label></p>', name: 'checkbox1',width: 60,isSort: false,render: function (){
	        	return '<input type="checkbox" class="chk_x1" />';
	        }},
	        { display: '仓库', name: 'p_number',isSort: false},
	        { display: '编号', name: 'pnumber',isSort: false},
	        { display: '名称', name: 'p_huohao',isSort: false},
	        { display: '规格', name: 'stock_id',isSort: false},
	        { display: '数量', name: 'p_id',isSort: false}
        ]
    });
    ugridA.reload();
    ugridA.setParm('classId',"");
    $("#menuTreeA").height(h-110);
    $.ajax({
    	type:"post",
    	url:WST.U('admin/datas/goods_class'),
		dataType:'json',
		success:function(data){
			console.log(data)
			var ops="";
			for(var o=0;o<data.length;o++){
				ops=ops+"<li><span dataid='"+data[o].catId+"' datasp='true'></span><a dataid='"+data[o].catId+"'>"+data[o].catName+"</a></li>";
			}
			$("#sanjiA").append(ops);
		}
    });
}
function AshopGridInitA(){
	ugridA = $("#maingridA").ligerGrid({
		height:h-110,
    });
    
    $("#maingridA").width(w-230);
    $("#menuTreeA").height(h-110);
}
$(function(){
	$("#sanjiA").on("click","span",function(){
		var obj=$(this).parent("li");
		var idss=$(this).attr("dataid");
		if ($(this).attr("datasp")=="true") {
			$(this).attr("datasp","false")
			$.ajax({
	    	type:"post",
	    	url:WST.U('admin/datas/goods_class_son'),
	    	data:{"id":idss},
			dataType:'json',
			success:function(data){
				console.log(data)
				var ops="<ul>";
				for(var o=0;o<data.length;o++){
					ops=ops+"<li><span dataid='"+data[o].catId+"' datasp='true'></span><a dataid='"+data[o].catId+"'>"+data[o].catName+"</a></li>";
				}
				ops=ops+'</ul>'
				obj.append(ops);
			}
	    	})
		}else{
			$(this).siblings("ul").toggle();
		}
		$(this).toggleClass("highlight"); 
	})
	$("#sanjiA").on("click","a",function(){
		var classId=$(this).attr("dataid");
		ugridA.setParm('classId',classId);
		ugridA.reload();    //重新加载库存查询的接口
	})
})
//查询（库存查询）
function loadUserGridA(){
	var changkuA=$("#changkuA").val();
	var zhuanghA=$("#zhuanghA").val();
	var startDateA=$("#startDateA").val();
	var endDateA=$("#endDateA").val();
	var gonghuosA=$("#gonghuosA").val();
	ugridA.setParm('stock_id',changkuA);
	ugridA.setParm('number',zhuanghA);
	ugridA.setParm('start_date',startDateA);
	ugridA.setParm('end_date',endDateA);
	ugridA.setParm('supper_id',gonghuosA);
	
	ugridA.reload();    //重新加载库存查询的接口
	
	
}


//第二个



function shopGridInitB(){
	$("#startDateB").ligerDateEditor();
	$("#endDateB").ligerDateEditor();
	sgrid = $("#maingridB").ligerGrid({
		url:WST.U('admin/datas/change_stock'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:w-230,
        minColToggle:14,
        rownumbers:true,
        columns: [
        	{ display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x2" onclick="WST.checkChks(this,\'.chk_x2\')"/><label for="chk_x2">全选</label></p>', name: 'checkbox2',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x2" value="'+rowdata['id']+'" />';
	        }},
	        { display: '初始仓库', name: 'stock_name',isSort: false},
	        { display: '初始店铺', name: 'shop_name',isSort: false},
	        { display: '目的地仓库', name: 'end_stock_name',isSort: false},
	        { display: '目的地店铺', name: 'end_shop_name',isSort: false},
	        { display: '编号', name: 'call_number',isSort: false},
	        { display: '名称', name: 'goodsName',isSort: false},
	        { display: '规格', name: 'spec_name',isSort: false},
	        { display: '数量', name: 'call_goods_number',isSort: false}
        ]
    });
     sgrid.reload();
    	sgrid.setParm('classId',"");
    $("#menuTreeB").height(h-110);
    $.ajax({
    	type:"post",
    	url:WST.U('admin/datas/goods_class'),
		dataType:'json',
		success:function(data){
			console.log(data)
			var ops="";
			for(var o=0;o<data.length;o++){
				ops=ops+"<li><span dataid='"+data[o].catId+"' datasp='true'></span><a dataid='"+data[o].catId+"'>"+data[o].catName+"</a></li>";
			}
			$("#sanjiB").append(ops);
		}
    });
    $.ajax({
		url:WST.U('admin/datas/get_stock_list'),
		type:"post",
		dataType:'json',
		success:function(data){
			var ops="<option value=''>请选择</option>";
			for(var o=0;o<data.length;o++){
				ops=ops+"<option value='"+data[o].roleId+"'>"+data[o].roleName+"</option>";
			}
			$("#cangkuB").html(ops);
		}
	})
}
function AshopGridInitB(){
	sgrid = $("#maingridB").ligerGrid({
		height:h-110,
    });
    
    $("#maingridB").width(w-230);
    $("#menuTreeB").height(h-110);
}
$(function(){
	$("#sanjiB").on("click","span",function(){
		var obj=$(this).parent("li");
		var idss=$(this).attr("dataid");
		if ($(this).attr("datasp")=="true") {
			$(this).attr("datasp","false")
			$.ajax({
	    	type:"post",
	    	url:WST.U('admin/datas/goods_class_son'),
	    	data:{"id":idss},
			dataType:'json',
			success:function(data){
				console.log(data)
				var ops="<ul>";
				for(var o=0;o<data.length;o++){
					ops=ops+"<li><span dataid='"+data[o].catId+"' datasp='true'></span><a dataid='"+data[o].catId+"'>"+data[o].catName+"</a></li>";
				}
				ops=ops+'</ul>'
				obj.append(ops);
			}
	    	})
		}else{
			$(this).siblings("ul").toggle();
		}
		$(this).toggleClass("highlight"); 
		
	})
	$("#sanjiB").on("click","a",function(){
		var classId=$(this).attr("dataid");
		sgrid.setParm('classId',classId);
		sgrid.reload();    //重新加载库存查询的接口
	})
})

//查询（库存查询）
function loadUserGridB(){
	var cangkuB=$("#cangkuB").val();
	var zhuanghB=$("#zhuanghB").val();
	var startDateB=$("#startDateB").val();
	var endDateB=$("#endDateB").val();
	var gonghuosB=$("#gonghuosB").val();
	sgrid.setParm('stock_id',cangkuB);
	sgrid.setParm('number',zhuanghB);
	sgrid.setParm('start_date',startDateB);
	sgrid.setParm('end_date',endDateB);
	sgrid.setParm('supper_id',gonghuosB);
	
	sgrid.reload();    //重新加载库存查询的接口
}
