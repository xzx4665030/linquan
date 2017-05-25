var ugridA,ugridB,ugridC,ugridD,ugridE,ugridA,sgridF,mgrid,h;
$(function(){
//	alert(1);
	var flag = true;
	var flagx = true;
	var flagy = true;
	var flagE = true;
	var flagF = true;
	h = WST.pageHeight();

	$('.l-tab-content').height(h-50);
	$('.l-tab-content-item').height(h-50);
	$('.l-tab-content-item').css('overflow','hidden');
	$(window).resize(function(){
		h = WST.pageHeight();
		$('.l-tab-content').height(h-45);
		$('.l-tab-content-item').height(h-45);
		AuserGridInit();
		AshopGridInit();
		AshopGridInitX();
		AshopGridInitY();
		AshopGridInitE();
		AshopGridInitF();
	})
	var tab = $("#wst-tabs").ligerTab({
         height: '99%',
         changeHeightOnResize:true,
         showSwitchInTab : false,
         showSwitch: false,
         onAfterSelectTabItem:function(n){
           if(n=='shops'){
              if(flag){
                shopGridInit();
                flag = false;
              }
           }else if(n=='shopsx'){
           		if(flagx){
                shopGridInitX();
                flagx = false;
              }
           }else if(n=='shopsy'){
           		if(flagy){
                shopGridInitY();
                flagy = false;
              }
           }else if(n=='shopsE'){
           		if(flagE){
                shopGridInitE();
                flagy = false;
              }
           }else if(n=='shopsF'){
           		if(flagF){
                shopGridInitF();
                flagy = false;
              }
           }
         }
    })
    userGridInit();
})

function userGridInit(){
	$("#startDateA").ligerDateEditor();
	$("#timeA").ligerDateEditor();
	$("#endDateA").ligerDateEditor();
	$("#pur_time").ligerDateEditor();
	ugridA = $("#userGrid").ligerGrid({
		url:WST.U('admin/Purchase/index'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:'100%',
        minColToggle:14,
        rownumbers:true,
        columns: [
	        { display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x1" onclick="WST.checkChks(this,\'.chk_x1\')"/><label for="chk_x1">全选</label></p>', name: 'checkbox1',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x1" value="'+rowdata['id']+'" />';
	        }},
	        { display: '单号', name: 'pur_number',isSort: false},
	        { display: '仓库', name: 'roleName',isSort: false},
	        { display: '供应商', name: 'company',isSort: false},
	        { display: '状态', name: 'lockMoney',isSort: false},
	        { display: '经手人', name: 'loginName',isSort: false},
	        { display: '备注', name: 'note',isSort: false},
	        { display: '添加时间', name: 'pur_time',isSort: false},
	        { display: '操作', name: 'op',width: 100,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<a class="bianji"  href="javascript:getForEditA(1,'+rowdata['id']+')">查看</a><a class="shanchux"  href="javascript:toDelA('+rowdata['id']+')">删除</a>';
	        }}
        ]
    });
}


function toDelA(id){
	var box = WST.confirm({content:"您确定要删除该文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/Purchase/del_purchase'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            ugridA.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

//批量删除
function toBatchDelA(){
	var ids = "";
	$(".chk_x1").each(function(){
		if($(this).is(':checked')){
			ids=$(this).val()+","+ids;
		}
	})
    
	if(ids.length==0){
		 WST.msg('请选择要删除的文章',{icon:2});
		 return;
	}
	var box = WST.confirm({content:"您确定要删除这些文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           $.post(WST.U('admin/Purchase/dels_purchase'),{ids:ids},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            ugridA.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}



//
function getForEditA(se,id){
	
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/Purchase/get_purchase'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           //
            $("#tj_tan").html("");
           if(data.goods){
           	
           var tr="<tr><td><input type='checkbox' id='dsb' style'display:none;'/><label for='dsb'>全选</label></td><td>商品编号</td><td>商品名称</td><td>规格型号</td><td>单位</td><td>库存数量</td><td>调拨数量</td></tr>";
        	

        	
        	 for (var i = data.goods.length - 1; i >= 0; i--) {
        	 	tr=tr+"<tr><td><input class='dsb' type='checkbox' value='" +data.goods[i].id+"'/></td>";
        	 	tr=tr+"<td class='bianhao'>"+data.goods[i].s_huohao+"</td><td>"+data.goods[i].goodsName+"</td><td>"+data.goods[i].spec_value+"</td><td>"+data.goods[i].goodsUnit+"</td><td>"+data.goods[i].stock+"</td>";
        	 	tr=tr+"<td><input type='text' class='shuliang'  value='" +data.goods[i].sum+"' /></td></tr>"
        	 	
        	 }
        	 $("#tj_tan").html(tr);

		}
           $.post(WST.U('admin/Purchase/get_manager'),{id:json.store_id},function(datas,textStatuss){

	         var t="<option value='0'>请选择</option>";
	         for (var i =0 ; i<datas.length; i++) {
	         	 if(data.manager_id==datas[i].staffId){
                    t=t+"<option value='"+datas[i].staffId+"' selected='selected' >"+datas[i].loginName+"</option>";
	         	 }else{
	         	 	t=t+"<option value='"+datas[i].staffId+"'>"+datas[i].loginName+"</option>";
	         	 }
	             
	         	
	         };
	         $("#manager_id").html(t);
	       })
           if(json.id){
           		WST.setValues(json);
           		toEditA(se,json.id);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditA(se,id){
	
	if(id==0){
		//WST.setValues({group_name:'',sort:'',remark:''});
		$('#expressFormA').get(0).reset();
		$("#tj_tan  tr:not(:first)").html("");
	}

	var title =(se==0)?"新增":"编辑";
	if(se==0){
        var timestamp = Date.parse(new Date());
        var randomNum = Math.floor(Math.random() * 10);
		$('#pur_number').html('CS'+timestamp+randomNum);
		var box = WST.open({title:title,type:1,content:$('#expressBoxA'),area: ['760px', '350px'],btn:['确定','取消'],yes:function(){
		$('#expressFormA').submit();
	   }});
	}else{
		var box = WST.open({title:title,type:1,content:$('#expressBoxA'),area: ['760px', '350px']});
	}
	
	$('#expressFormA').validator({
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
       				$("#tj_tan .dsb").each(function(){
       					if($(this).is(':checked')){
       						if($("#tj_tan .shuliang").eq($("#tj_tan .dsb").index(this)).val()>0){
       							yy=yy+$(this).val()+","+$("#tj_tan .bianhao").eq($("#tj_tan .dsb").index(this)).text()+","+$("#tj_tan .shuliang").eq($("#tj_tan .dsb").index(this)).val()+";";
       					
       						}else{

       						}
       						
       					}
       				})
       				
		            var params = WST.getParams('.ipta');
                    var pur_number=$('#pur_number').text();
	                params.expressId = id;
	                params.goods = yy;
	                params.pur_number = pur_number;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/Purchase/'+((id==0)?"add_purchase":"edit")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormA')[0].reset();
	           			    	layer.close(box);
	           		            ugridA.reload();
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});

    	}

  });

}


function AuserGridInit(){
	ugridA = $("#userGrid").ligerGrid({
		height:h-100,
    });
}

//第二个

function shopGridInit(){
	$("#startDateB").ligerDateEditor();
	$("#endDateB").ligerDateEditor();
	ugridB = $("#shopGrid").ligerGrid({
		url:WST.U('admin/stock/pageQueryByCallOut'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:'100%',
        minColToggle:14,
        rownumbers:true,
        columns: [
        	{ display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x2" onclick="WST.checkChks(this,\'.chk_x2\')"/><label for="chk_x2">全选</label></p>', name: 'checkbox2',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x2" value="'+rowdata['call_id']+'"/>';
	        }},
	        { display: '单号', name: 'call_number',isSort: false},
	        { display: '类型', name: 'call_style',isSort: false},
	        { display: '出仓', name: 'shopMoney',isSort: false},
	        { display: '状态', name: 'call_status1',isSort: false},
	        { display: '经手人', name: 'jsr',isSort: false},
	        { display: '签收人', name: 'lockMoney',isSort: false},
	        { display: '备注', name: 'call_note',isSort: false},
	        { display: '添加时间', name: 'call_select_time',isSort: false},
	        { display: '操作', name: 'op',width: 300,isSort: false,render: function (rowdata, rowindex, value){
	        	var hh="";
				
				hh = hh + '<a class="bianji"  href="javascript:chakanxq('+rowdata['call_id']+')">查看详情</a><a class="shanchux"  href="javascript:toDelF('+rowdata['call_id']+')">删除</a>';
	        	return hh;
	        	// return '<a class="bianji" style="display:none;" href="javascript:getForEditB(1,'+rowdata['call_id']+')">编辑</a><a class="shanchux"  href="javascript:toDelB('+rowdata['call_id']+')">删除</a>';
	        }}
        ]
    });
}
function AshopGridInit(){
	ugridB = $("#shopGrid").ligerGrid({
		height:h-100,
    });
}



function toDelB(id){
	var box = WST.confirm({content:"您确定要删除该调拨订单吗?",yes:function(){
	var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	$.post(WST.U('admin/stock/del_call_out'),{id:id},function(data,textStatus){
			  layer.close(loading);
			  var json = WST.toAdminJson(data);
			  if(json.status=='1'){
					WST.msg(json.msg,{icon:1});
					layer.close(box);
					ugridB.reload();
			  }else{
					WST.msg(json.msg,{icon:2});
			  }
		});
	}});
}

//批量删除
function toBatchDelB(){
	var ids = WST.getChks('.chk_x2');
	if(ids.length==0){
		 WST.msg('请选择要删除的调拨订单',{icon:2});
		 return;
	}
	var box = WST.confirm({content:"您确定要删除这些调拨订单吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           $.post(WST.U('admin/stock/del_call_out_all'),{ids:ids.join(',')},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            ugridB.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}


//
function getForEditB(se,id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/express/get'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           console.log(json.expressId);
           if(json.expressId){
           		WST.setValues(json);
           		toEditB(se,json.expressId);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditB(se,id){
	var title =(se==0)?"新增":"编辑";
	if(se==0){
        var timestamp = Date.parse(new Date());
        var randomNum = Math.floor(Math.random() * 10);
		$('#stock_number').html('DB'+timestamp+randomNum);
	}
	var box = WST.open({title:title,type:1,content:$('#expressBoxB'),area: ['760px', '350px'],btn:['确定','取消'],yes:function(){
		$('#expressFormB').submit();
	}});
	$('#expressFormB').validator({
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
			$("#tj_tanB .dsbB").each(function(){
				if($(this).is(':checked')){
					if($("#tj_tanB .shuliang").eq($("#tj_tanB .dsbB").index(this)).val()>0){
						yy=yy+$(this).val()+","+$("#tj_tanB .bianhao").eq($("#tj_tanB .dsbB").index(this)).text()+","+$("#tj_tanB .shuliang").eq($("#tj_tanB .dsbB").index(this)).val()+","+$("#tj_tanB .cangku").eq($("#tj_tanB .dsbB").index(this)).html()+";";				
					}
				}
			})
			var params = WST.getParams('.iptb');
			params.expressId = id;
			params.selects = yy;   //选择的商品
			var stock_number = $('#stock_number').text();  //调拨号
			
			params.stock_number = stock_number;
			
			var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
			
			$.post(WST.U('admin/stock/'+((id==0)?"add_call_out":"edit")),params,function(data,textStatus){
				  layer.close(loading);
				  var json = WST.toAdminJson(data);
				  if(json.status=='1'){
						WST.msg("操作成功",{icon:1});
						$('#expressFormB')[0].reset();
						layer.close(box);
						ugridB.reload();
				  }else{
						WST.msg(json.msg,{icon:2});
				  }
			});

    	}

  });

}



//第三个
function shopGridInitX(){
	$("#startDateC").ligerDateEditor();
	$("#endDateC").ligerDateEditor();
	ugridC = $("#shopGridx").ligerGrid({
		url:WST.U('admin/logmoneys/pageQueryByShop'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:'100%',
        minColToggle:12,
        rownumbers:true,
        columns: [
	       { display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x3" onclick="WST.checkChks(this,\'.chk_x3\')"/><label for="chk_x3">全选</label></p>', name: 'checkbox3',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x3" value="'+rowdata['shopId']+'"/>';
	        }},
	        { display: '单号', name: 'loginName',isSort: false},
	        { display: '类型', name: 'shopName',isSort: false},
	        { display: '出仓', name: 'shopMoney',isSort: false},
	        { display: '入仓', name: 'lockMoney',isSort: false},
	        { display: '状态', name: 'lockMoney',isSort: false},
	        { display: '经手人', name: 'lockMoney',isSort: false},
	        { display: '签收人', name: 'lockMoney',isSort: false},
	        { display: '备注', name: 'lockMoney',isSort: false},
	        { display: '添加时间', name: 'lockMoney',isSort: false},
	        { display: '进价', name: 'lockMoney',isSort: false},
	        { display: '出库价', name: 'lockMoney',isSort: false},
	        { display: '操作', name: 'op',width: 100,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<a class="bianji" style="display:none;" href="javascript:getForEditC(1,'+rowdata['shopId']+')">编辑</a><a class="shanchux"  href="javascript:toDelC('+rowdata['userId']+')">删除</a>';
	        }}
        ]
    });
}
function AshopGridInitX(){
	ugridC = $("#shopGridx").ligerGrid({
		height:h-100,
    });
}


function toDelC(id){
	var box = WST.confirm({content:"您确定要删除该文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/articles/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            ugridC.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

//批量删除
function toBatchDelC(){
	var ids = WST.getChks('.chk_x3');
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
	           		            ugridC.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}



//
function getForEditC(se,id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/express/get'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           console.log(json.expressId);
           if(json.expressId){
           		WST.setValues(json);
           		toEditC(se,json.expressId);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditC(se,id){
	var title =(se==0)?"新增":"编辑";
	var box = WST.open({title:title,type:1,content:$('#expressBoxC'),area: ['760px', 'auto'],btn:['确定','取消'],yes:function(){
		$('#expressFormC').submit();
	}});
	
	$('#expressFormC').validator({
//      fields: {
//          expressName: {
//          	rule:"required;",
//          	msg:{required:"快递名称不能为空"},
//          	tip:"请输入快递名称",
//          	ok:"",
//          }
//      },
       valid: function(form){
		        var params = WST.getParams('.ipt');
	                params.expressId = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/express/'+((id==0)?"add":"edit")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormC')[0].reset();
	           			    	layer.close(box);
	           		            ugridC.reload();
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});

    	}
  });
}





//第四个
function shopGridInitY(){
	$("#startDateD").ligerDateEditor();
	$("#endDateD").ligerDateEditor();
	ugridD = $("#shopGridy").ligerGrid({
		url:WST.U('admin/logmoneys/pageQueryByShop'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:'100%',
        minColToggle:12,
        rownumbers:true,
        columns: [
	       { display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x4" onclick="WST.checkChks(this,\'.chk_x4\')"/><label for="chk_x4">全选</label></p>', name: 'checkbox4',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x4" value="'+rowdata['shopId']+'" />';
	        }},
	        { display: '单号', name: 'loginName',isSort: false},
	        { display: '类型', name: 'shopName',isSort: false},
	        { display: '仓库', name: 'shopMoney',isSort: false},
	        { display: '状态', name: 'lockMoney',isSort: false},
	        { display: '经手人', name: 'lockMoney',isSort: false},
	        { display: '备注', name: 'lockMoney',isSort: false},
	        { display: '添加时间', name: 'lockMoney',isSort: false},
	        { display: '操作', name: 'op',width: 100,isSort: false,render: function (rowdata, rowindex, value){
	        	
	        	return '<a class="bianji" style="display:none;" href="javascript:getForEditD(1,'+rowdata['shopId']+')">编辑</a><a class="shanchux"  href="javascript:toDelD('+rowdata['userId']+')">删除</a>';
//	        	return '<a href="javascript:tologmoneys(1,'+rowdata['shopId']+')">查看</a>&nbsp;&nbsp;&nbsp;<a href="javascript:tologmoneys(1,'+rowdata['shopId']+')">caozu</a>';
	        }}
        ]
    });
}
function AshopGridInitY(){
	ugridD = $("#shopGridy").ligerGrid({
		height:h-100,
    });
}



function toDelD(id){
	var box = WST.confirm({content:"您确定要删除该文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/articles/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            ugridD.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

//批量删除
function toBatchDelD(){
	var ids = WST.getChks('.chk_x4');
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
	           		            ugridD.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}



//
function getForEditD(se,id){
	// alert(id);
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/express/get'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           console.log(json.expressId);
           if(json.expressId){
           		WST.setValues(json);
           		toEditD(se,json.expressId);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditD(se,id){
	var title =(se==0)?"新增":"编辑";
	var box = WST.open({title:title,type:1,content:$('#expressBoxD'),area: ['760px', 'auto'],btn:['确定','取消'],yes:function(){
		$('#expressFormD').submit();
	}});
	$('#expressFormD').validator({
//      fields: {
//          expressName: {
//          	rule:"required;",
//          	msg:{required:"快递名称不能为空"},
//          	tip:"请输入快递名称",
//          	ok:"",
//          }
//      },
       valid: function(form){
		        var params = WST.getParams('.ipt');
	                params.expressId = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/express/'+((id==0)?"add":"edit")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormD')[0].reset();
	           			    	layer.close(box);
	           		            ugridD.reload();
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});
    	}
  });
}




// alert(1);
//第五个
function shopGridInitE(){
	// alert(1)
	$("#startDateE").ligerDateEditor();
	$("#endDateE").ligerDateEditor();
	ugridE = $("#shopGridE").ligerGrid({
		url:WST.U('admin/logmoneys/pageQueryByShop'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:'100%',
        minColToggle:4,
        rownumbers:true,
        columns: [
	       { display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x5" onclick="WST.checkChks(this,\'.chk_x5\')"/><label for="chk_x5">全选</label></p>', name: 'checkbox5',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x5" value="'+rowdata['shopId']+'" />';
	        }},
	        { display: '单号', name: 'loginName',isSort: false},
	        { display: '类型', name: 'shopName',isSort: false},
	        { display: '仓库', name: 'shopMoney',isSort: false},
	        { display: '状态', name: 'lockMoney',isSort: false},
	        { display: '经手人', name: 'lockMoney',isSort: false},
	        { display: '备注', name: 'lockMoney',isSort: false},
	        { display: '添加时间', name: 'lockMoney',isSort: false},
	        { display: '操作', name: 'op',width: 100,isSort: false,render: function (rowdata, rowindex, value){
	        	
	        	return '<a class="bianji" style="display:none;" href="javascript:getForEditE(1,'+rowdata['shopId']+')">编辑</a><a class="shanchux"  href="javascript:toDelE('+rowdata['userId']+')">删除</a>';
//	        	return '<a href="javascript:tologmoneys(1,'+rowdata['shopId']+')">查看</a>&nbsp;&nbsp;&nbsp;<a href="javascript:tologmoneys(1,'+rowdata['shopId']+')">caozu</a>';
	        }}
        ]
    });
}
function AshopGridInitE(){
	ugridE = $("#shopGridE").ligerGrid({
		height:h-100,
    });
}



function toDelE(id){
	var box = WST.confirm({content:"您确定要删除该文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/articles/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            ugridE.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

//批量删除
function toBatchDelE(){
	var ids = WST.getChks('.chk_x5');
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
	           		            ugridE.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}



//
function getForEditE(se,id){
	// alert(id);
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/express/get'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           console.log(json.expressId);
           if(json.expressId){
           		WST.setValues(json);
           		toEditE(se,json.expressId);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditE(se,id){
	var title =(se==0)?"新增":"编辑";
	var box = WST.open({title:title,type:1,content:$('#expressBoxE'),area: ['760px', 'auto'],btn:['确定','取消'],yes:function(){
		$('#expressFormE').submit();
	}});
	$('#expressFormE').validator({
//      fields: {
//          expressName: {
//          	rule:"required;",
//          	msg:{required:"快递名称不能为空"},
//          	tip:"请输入快递名称",
//          	ok:"",
//          }
//      },
       valid: function(form){
		        var params = WST.getParams('.ipt');
	                params.expressId = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/express/'+((id==0)?"add":"edit")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormE')[0].reset();
	           			    	layer.close(box);
	           		            ugridE.reload();
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});
    	}
  });
}






//第六个
function shopGridInitF(){
	$("#startDateF").ligerDateEditor();
	$("#endDateF").ligerDateEditor();
	ugridF = $("#shopGridF").ligerGrid({
		url:WST.U('admin/stock/pageQueryByOrderDelivery'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:'100%',
        minColToggle:4,
        rownumbers:true,
        columns: [
	       { display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x6" onclick="WST.checkChks(this,\'.chk_x6\')"/><label for="chk_x6">全选</label></p>', name: 'checkbox6',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x6" value="'+rowdata['call_id']+'" />';
	        }},
	        { display: '单号', name: 'call_number',isSort: false},
	        { display: '发货仓', name: 'start_name',isSort: false},
	        { display: '收货人', name: 'end_name',isSort: false},	        
	        { display: '商品', name: 'goodsName',isSort: false},
			{ display: '规格', name: 'spec',isSort: false},
	        { display: '状态', name: 'call_stats',isSort: false},
	        { display: '时间', name: 'call_select_time',isSort: false},
	        { display: '操作', name: 'op',width: 200,isSort: false,render: function (rowdata, rowindex, value){
	        	var hh="";
				if(rowdata['call_status']==1){
					hh=hh+'<a class="bianji"  href="javascript:fahuo(1,'+rowdata['call_id']+')">发货</a>';
				}else if(rowdata['call_status']==2){
					hh=hh+'<a class="bianji"  href="javascript:fahuo(2,'+rowdata['call_id']+')">确认收货</a>';
				}else if(rowdata['call_status']==3){
					
				}
				hh = hh + '<a class="bianji"  href="javascript:chakanxq('+rowdata['call_id']+')">查看详情</a><a class="shanchux"  href="javascript:toDelF('+rowdata['call_id']+')">删除</a>';
	        	return hh;
				//return '<a class="bianji" style="display:none;" href="javascript:getForEditF(1,'+rowdata['call_id']+')">编辑</a>';
//	        	return '<a href="javascript:tologmoneys(1,'+rowdata['shopId']+')">查看</a>&nbsp;&nbsp;&nbsp;<a href="javascript:tologmoneys(1,'+rowdata['shopId']+')">caozu</a>';
	        }}
        ]
    });
}

//订单发货的操作操作方法  xzx
function fahuo(statas,id){
	var box = WST.confirm({content:"您确定要操作吗?",yes:function(){
		var data = {'statas':statas,'id':id};
		$.ajax({
			url:WST.U('admin/stock/do_order'),
			data:data,
			type:'post',
			dataType:'json',
			success:function(data){
				var json = WST.toAdminJson(data);
				
				if(json.status=='1'){
					WST.msg(json.msg,{icon:1});
					layer.close(box);			
					ugridF.reload();
				}else{
					WST.msg(json.msg,{icon:2});
					ugridF.reload();
				}
			}
		})
	}});
}


function AshopGridInitF(){
	ugridF = $("#shopGridF").ligerGrid({
		height:h-100,
    });
}



function toDelF(id){
   var box = WST.confirm({content:"您确定要删除该文章吗?",yes:function(){
   var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	$.post(WST.U('admin/articles/del'),{id:id},function(data,textStatus){
			  layer.close(loading);
			  var json = WST.toAdminJson(data);
			  if(json.status=='1'){
					WST.msg(json.msg,{icon:1});
					layer.close(box);
					ugridF.reload();
			  }else{
					WST.msg(json.msg,{icon:2});
			  }
		});
	}});
}

//批量删除
function toBatchDelF(){
	var ids = WST.getChks('.chk_x6');
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
	           		            ugridF.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}



//
function getForEditF(se,id){
	// alert(id);
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/express/get'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           console.log(json.expressId);
           if(json.expressId){
           		WST.setValues(json);
           		toEditF(se,json.expressId);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditF(se,id){
	var title =(se==0)?"新增":"编辑";
	var box = WST.open({title:title,type:1,content:$('#expressBoxF'),area: ['760px', 'auto'],btn:['确定','取消'],yes:function(){
		$('#expressFormF').submit();
	}});
	$('#expressFormF').validator({
//      fields: {
//          expressName: {
//          	rule:"required;",
//          	msg:{required:"快递名称不能为空"},
//          	tip:"请输入快递名称",
//          	ok:"",
//          }
//      },
       valid: function(form){
		        var params = WST.getParams('.ipt');
	                params.expressId = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/express/'+((id==0)?"add":"edit")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormF')[0].reset();
	           			    	layer.close(box);
	           		            ugridF.reload();
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});
    	}
  });
}

