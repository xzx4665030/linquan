var ugrid,sgrid,mgrid,h;
$(function(){
//	alert(1);
	var flag = true;
	var flagx = true;
	var flagy = true;
	h = WST.pageHeight();
//	alert(1);
	$('.l-tab-content').height(h-50);
	$('.l-tab-content-item').height(h-50);
	$('.l-tab-content-item').css('overflow','hidden');
	$(window).resize(function(){
		h = WST.pageHeight();
		$('.l-tab-content').height(h-45);
		$('.l-tab-content-item').height(h-45);
		AuserGridInit();
	})
    userGridInit();
})
function userGridInit(){
	$("#startDate").ligerDateEditor();
	$("#endDate").ligerDateEditor();
	ugrid = $("#userGrid").ligerGrid({
		url:WST.U('admin/replenishment/pageIndexs'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:'100%',
        minColToggle:7,
        rownumbers:true,
        columns: [
	        { display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x" onclick="WST.checkChks(this,\'.chk_x\')"/><label for="chk_x">全选</label></p>', name: 'checkbox',width: 60,isSort: false,render: function (){
	        	return '<input type="checkbox" class="chk_x" />';
	        }},
	        { display: '网点', name: 'shopName',isSort: false},
	        { display: '需退货商品', name: 'goodsName',isSort: false},
	        { display: '商品规格', name: 'spec',isSort: false},
	        { display: '退货数量', name: 'num',isSort: false},
	        { display: '申请人', name: 'shopkeeper',isSort: false},
	        { display: '备注', name: 'remark',isSort: false},
	        { display: '申请时间', name: 'time',isSort: false},
	        { display: '操作', name: 'op',width: 111,iisSort: false,render: function (rowdata, rowindex, value){
	        	var h="";
	        	if(rowdata["status"]==1){
	        		h=h+'<a class="bianji" href="javascript:jujue(1,'+rowdata["tuihuo_id"]+')">同意</a><a class="shanchux" href="javascript:jujue(2,'+rowdata["tuihuo_id"]+'">拒绝</a>';
	        	}else if(rowdata["status"]==2){
	        		h=h+'<a class="bianji" href="javascript:getForEdit(1,'+rowdata["tuihuo_id"]+')">编辑</a>';
	        		
	        	}else{
	        		h=h+"<a>已拒绝</a>"
	        	}
	        	return h;
	        }}
        ]
    });
}
function AuserGridInit(){
	ugrid = $("#userGrid").ligerGrid({
		height:h-100,
    });
}

function toDel(id){
	var box = WST.confirm({content:"您确定要删除该文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/articles/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            grid.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

//批量删除
function toBatchDel(){
	var ids = WST.getChks('.chk');
	if(ids.length==0){
		 WST.msg('请选择要删除的文章',{icon:2});
		 return;
	}
	var box = WST.confirm({content:"您确定要删除这些文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           $.post(WST.U('admin/articles/delByBatch'),{ids:ids.join(',')},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            ugrid.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}



//
function getForEdit(se,id){
	$('#expressForm').get(0).reset();
	$("#wangdian2").html("");
	$("#wangdian2").hide();
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/replenishment/get_goods_infos'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           //alert(json.tuihuo_id);
           if(json.tuihuo_id){
           		WST.setValues(json);
           		toEdit(se,json.tuihuo_id);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEdit(se,id){
	var title =(se==0)?"新增":"编辑";
	if(id!=0){
		var isflag=($("#spec").val()=="")?0:1;
	}
	if(se==0){
		//WST.setValues({group_name:'',sort:'',remark:''});
		$('#expressForm').get(0).reset();
		$("#wangdian2").html("");
		$("#wangdian2").hide();
	}
	var box = WST.open({title:title,type:1,content:$('#expressBox'),area: ['638px', 'auto'],btn:['确定','取消'],yes:function(){
		$('#expressForm').submit();
	}});
	$('#expressForm').validator({
//      fields: {
//          expressName: {
//          	rule:"required;",
//          	msg:{required:"快递名称不能为空"},
//          	tip:"请输入快递名称",
//          	ok:"",
//          }
//      },
       valid: function(form){
       				var yy="";
       				var bj=0;
       				$("#tj_tan .dsb").each(function(){
       					if($(this).is(':checked')){
       						if($("#tj_tan .shuliang").eq($("#tj_tan .dsb").index(this)).val()>0){
       							yy=yy+$("#tj_tan .dsb").eq($("#tj_tan .dsb").index(this)).val()+","+$("#tj_tan .shuliang").eq($("#tj_tan .dsb").index(this)).val()+";";
       							bj=bj+parseInt($("#tj_tan .shuliang").eq($("#tj_tan .dsb").index(this)).val());
       						}else{
								WST.msg('请输入大于0的数字', {icon:2});
       						}
       						
       					}
       				})
       				
		            var params = WST.getParams('.ipt');
	                params.tuihuo_id = id;
	                params.isflag = isflag;
	                params.yy = yy;   //补货时其他网店退货的数据
	                
	                if(params.wangdian==1&&yy==""){
	                	WST.msg('选择错误', {icon:2});
	                }else if(bj > params.buhuo_do_num){
	                	WST.msg('数量超出', {icon:2});
	                }else if(params.wangdian2==""){
	                	WST.msg('请选择', {icon:2});
	                }else {
		                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
		           		$.post(WST.U('admin/replenishment/'+((se==0)?"add":"done_tuihuo")),params,function(data,textStatus){
		           			  layer.close(loading);
		           			  var json = WST.toAdminJson(data);
		           			  if(json.status=='1'){
		           			    	WST.msg("操作成功",{icon:1});
		           			    	$('#expressForm')[0].reset();
		           			    	layer.close(box);
		           		            ugrid.reload();
		           			  }else{
		           			        WST.msg(json.msg,{icon:2});
		           			  }
		           		});
	                }

    	}

  });

}

//flag：2拒绝,1同意
function jujue(flag,id){
	$.ajax({
		url:WST.U('admin/replenishment/do_tuihuo'),
		data:{"id":id,"flag":flag},
		type:"post",
		dataType:'json',
		success:function(data){
			ugrid.reload();	
		}
	})
}


$(function(){
	$("#wangdian").change(function(){
		$("#tj_tan").html("");
		var select_id = $(this).val(); //选择的是网店还是仓库
		if(select_id>0){
			datas = {'select_id':select_id};
			$.ajax({
				type:'post',
				url:WST.U('admin/Replenishment/get_stockinfo'),
				data:datas,
				dataType:'json',
				success:function(result){
//					console.log(result);
					document.getElementById('wangdian2').options.length=0;
					var opt = document.createElement('option');
					opt.text = "请选择";
					document.getElementById('wangdian2').add(opt);
					for (i = 0; i < result.length; i++)  
					{  
					  var opt = document.createElement('OPTION');  
					  opt.value = result[i].id;      
					  opt.text  = result[i].name;  
					  document.getElementById('wangdian2').add(opt);
					}
				}
			})
			$("#wangdian2").show();
			
		}else{
			$("#wangdian2").html('');
			$("#wangdian2").hide();
		}
	})
	$("#wangdian2").change(function(){
		$("#tj_tan").html("");
		var uu=$(this).val();
		if(uu>0){
			if($("#wangdian").val()==1){
				data = {'shopId':uu,'goodsName':$("#goodsName").val(),'spec_list':$("#spec_list").val()};
				$.ajax({
					type:'post',
					url:WST.U('admin/Replenishment/get_tuihuo_list'),
					data:data,
					dataType:'json',
					success:function(data){
//						console.log(data);
						if(data.length>0){
							
							 var tr="<tr><td><input type='checkbox' id='dsb' style='display:none;'/><label for='dsb'>全选</label></td><td>申请时间</td><td>商品名称</td><td>备注</td><td>商品数量</td><td>调拨数量</td></tr>";
				        	 for (var i = data.length - 1; i >= 0; i--) {
				        	 	tr=tr+"<tr><td><input class='dsb' type='checkbox' value='" +data[i].buhuo_shopId+"'/></td>";
				        	 	tr=tr+"<td class='bianhao'>"+data[i].buhuo_time+"</td><td>"+data[i].buhuo_goodsName+"</td><td>"+data[i].buhuo_remark+"</td><td>"+data[i].buhuo_do_num+"</td>";
				        	 	tr=tr+"<td><input type='text' class='shuliang' /><span style='display:none;' class='yuanb' >"+data[i].buhuo_shopId+","+data[i].tuihuo_spec+","+data[i].buhuo_goodsName+"</span></td></tr>"
				        	 	
				        	 }
				        	 $("#tj_tan").html(tr);
				        	 $("#dsb").click(function(){
				        	 	if ($(this).is(':checked')) {
				        	 		$('.dsb').each(function(){
				        	 			$(this).prop("checked",true);
				        	 		})
				        	 	}else{
				        	 		$('.dsb').each(function(){
				        	 			$(this).prop("checked",false);
				        	 		})
				        	 	}
				        	 })
						}
					}
				})
			}
			
		}
	})
})









