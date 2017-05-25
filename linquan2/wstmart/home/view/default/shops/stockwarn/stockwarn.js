$(function(){
	stockByPage();
});
function toStock(id,src){
    location.href=WST.U('home/goodsvirtuals/stock','id='+id+"&src="+src);
}
function stockByPage(p){
	$('#list').html('<tr><td colspan="11"><img src="'+WST.conf.ROOT+'/wstmart/home/view/default/img/loading.gif">正在加载数据...</td></tr>');
	var params = {};
	params = WST.getParams('.s-query');
	params.page = p;
	$.post(WST.U('home/goods/stockByPage'),params,function(data,textStatus){
	    var json = WST.toJson(data);
	    if(json.status==1 && json.Rows){
	       	var gettpl = document.getElementById('tblist').innerHTML;
	       	laytpl(gettpl).render(json.Rows, function(html){
	       		$('#list').html(html);
	       		$('.j-goodsImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.ROOT+'/'+window.conf.GOODS_LOGO});//商品默认图片
	       	});
	       	if(json.TotalPage>1){
	       		laypage({
		        	 cont: 'pager', 
		        	 pages:json.TotalPage, 
		        	 curr: json.CurrentPage,
		        	 skin: '#e23e3d',
		        	 groups: 3,
		        	 jump: function(e, first){
		        		    if(!first){
		        		    	stockByPage(e.curr);
		        		    }
		        	    } 
		        });
	       	}else{
	       		$('#pager').empty();
	       	}
       	}  
	});
}
function toEdit(id,src){
	location.href = WST.U('home/goods/edit','id='+id+'&src='+src);
}
//双击修改
function toEditGoodsStock(id,type){
	$("#ipt_"+type+"_"+id).show();
	$("#span_"+type+"_"+id).hide();
	$("#ipt_"+type+"_"+id).focus();
	$("#ipt_"+type+"_"+id).val($("#span_"+type+"_"+id).html());
}
function endEditGoodsStock(type,id){
	$('#span_'+type+'_'+id).html($('#ipt_'+type+'_'+id).val());
	$('#span_'+type+'_'+id).show();
    $('#ipt_'+type+'_'+id).hide();
}
function editGoodsStock(id,type,goodsId){
	var number = $('#ipt_'+type+'_'+id).val();
	if($.trim(number)==''){
		WST.msg('库存不能为空', {icon: 5});
        return;
	}
	var params = {};
	params.id = id;
	params.type = type;
	params.goodsId = goodsId;
	params.number = number;
	$.post(WST.U('Home/Goods/editwarnStock'),params,function(data,textStatus){
		var json = WST.toJson(data);
		if(json.status>0){
			$('#img_'+type+'_'+id).fadeTo("fast",100);
			endEditGoodsStock(type,id);
			$('#img_'+type+'_'+id).fadeTo("slow",0);
		}else{
			WST.msg(json.msg, {icon: 5}); 
		}
	});
}

function getCat(val){
  if(val==''){
  	$('#cat2').html("<option value='' >-请选择-</option>");
  	return;
  }
  $.post(WST.U('home/shopcats/listQuery'),{parentId:val},function(data,textStatus){
       var json = WST.toJson(data);
       var html = [],cat;
       html.push("<option value='' >-请选择-</option>");
       if(json.status==1 && json.list){
         json = json.list;
       for(var i=0;i<json.length;i++){
           cat = json[i];
           html.push("<option value='"+cat.catId+"'>"+cat.catName+"</option>");
        }
       }
       $('#cat2').html(html.join(''));
  });
}



//leib为1是补货，2是退货
function buhuo(id,leib){
	var shopId;
	var shopkeeper;
	data = {'goodsId':id};
	if(leib=='2'){
		$('.ylf_bt_x').html("退货权限");
		$('.ylf_sl_x').html("退货数量:");
	}else if(leib=='1'){
		$('.ylf_bt_x').html("补货权限");
		$('.ylf_sl_x').html("补货数量:");
	}
	$.ajax({
		url:WST.U('home/goods/get_infos'),
		data:data,
		type:'post',
		dataType:'json',
		success:function(data){
			var span="";
			for (var i=0;i<data.spec.length;i++) {
				span=span+'<span>'+data.spec[i].catName+':'+data.spec[i].itemName+'</span>'
			}
			console.log(span);
			$("#ylf_ge").html(span)
			$("#ylf_wd").html(data.shopName);
			$("#ylf_pe").html(data.shopkeeper);
			$("#ylf_sp").html(data.goodsName);
			shopId=data.shopId;
			shopkeeper=data.shopkeeper;
			$("#ylf_sl").val("");
			$("#beizhu").val("");
			$('.ylf_yc').show();
		}
	})
	$(".ylf_quxiao").off("click");
	$(".ylf_queren").off("click");
	$(".ylf_quxiao").on("click",function(){
		$('.ylf_yc').hide();
	})
	$(".ylf_queren").on("click",function(){
		datas={'goodsId':id,'shopId':shopId,'shopkeeper':shopkeeper,'beizhu':$("#beizhu").val(),'ylf_sl':$("#ylf_sl").val(),'leib':leib}
		$.ajax({
			url:WST.U('home/goods/operate'),
			data:datas,
			type:'post',
			dataType:'json',
			success:function(result){
				if(result.flag == '1'){
					WST.msg(result.msg, {icon: 5});
					 history.go(0);
				}else{
					WST.msg(result.msg, {icon: 5}); 
					 history.go(0);
				}
			}
		})
	})
}
$(function(){
})
