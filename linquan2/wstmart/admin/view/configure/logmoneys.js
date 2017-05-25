var ugrid,sgrid,mgrid,h,sgridYz;
$(function(){
//	alert(1);
	var flag = true;
	var flagx = true;
	var flagy = true;
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
               
              }
           }else if(n=='shopsx'){
           		if(flagx){
                shopGridInitX();
               
              }
           }else if(n=='shopsy'){
           		if(flagy){
                shopGridInitY();
               
              }
           }
         }
    })
    userGridInit();
})
function userGridInit(){
	$("#startDateA").ligerDateEditor();
	$("#endDateA").ligerDateEditor();
	ugrid = $("#userGrid").ligerGrid({
		url:WST.U('admin/configure/pageQueryByShop'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:'100%',
        minColToggle:7,
        rownumbers:true,
        columns: [
	        { display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x1" onclick="WST.checkChks(this,\'.chk_x1\')"/><label for="chk_x1">全选</label></p>', name: 'checkbox1',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x1" val="'+rowdata['shopId']+'" />';
	        }},
	        { display: '店铺名称', name: 'shopName',isSort: false},
	        { display: '联系人', name: 'shopkeeper',isSort: false},
	        { display: '联系方式', name: 'telephone',isSort: false},
	        { display: '店铺地址', name: 'shopAddress',isSort: false},
	        { display: '操作', name: 'op',width: 150,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<a class="bianji" href="javascript:getForEditA(1,'+rowdata['shopId']+')">编辑</a><a class="kucun" href="javascript:XINA('+rowdata['shopId']+')">库存</a><a class="shanchux"  href="javascript:toDelA('+rowdata['shopId']+')">删除</a>';
	        	//return '<a class="bianji" href="javascript:getForEditA(1,'+rowdata['shopId']+')">编辑</a><a class="shanchux"  href="javascript:toDelA('+rowdata['shopId']+')">删除</a>';
	        }}
        ]
    });
}


function toDelA(id){
	var box = WST.confirm({content:"您确定要删除该网店吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/configure/del_shop'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            //grid.reload();
								userGridInit();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
								userGridInit();
	           			  }
	           		});
	            }});
}

//批量删除
function toBatchDelA(){
	var ids = WST.getChks('.chk_x1');
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
	           		            grid.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}



//lif
function getForEditA(se,id){
	
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/configure/get_shop'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           if(json.shopId){
           		WST.setValues(json);
           		toEditA(se,json.shopId);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditA(se,id){
	var title =(se==0)?"新增":"编辑";
	var box = WST.open({title:title,type:1,content:$('#expressBoxA'),area: ['430px', 'auto'],btn:['确定','取消'],yes:function(){
		$('#expressFormA').submit();
	}});
	
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
		        var params = WST.getParams('.ipta');
	                params.expressId = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/configure/'+((id==0)?"add_shop":"edit_shop")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormA')[0].reset();
	           			    	layer.close(box);
	           		            //grid.reload();
								userGridInit();
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
								userGridInit();
	           			  }
	           		});

    	}

  });

}
//翻页
function XINA(id){
	
	location.href=WST.U('admin/configure/shop_stock','id='+id);
}
function moneyGridInitA(id){
	$("#startDate").ligerDateEditor();
	$("#endDate").ligerDateEditor();
    mgrid = $("#moneyGrid").ligerGrid({
		url:WST.U('admin/configure/pageQueryShopGoods','&id='+id),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:10,
        rownumbers:true,
        columns: [
	        { display: '调拨号', name: 'call_number',isSort: false},
	        { display: '商品名称', name: 'goodsName',isSort: false},
	        { display: '进货数量', name: 'call_goods_number',isSort: false},
	        { display: '规格', name: 'call_goods_huohao',isSort: false},
	        { display: '进价', name: 'marketPrice',isSort: false},
	        { display: '市场价', name: 'shopPrice',isSort: false},
	        { display: '库存', name: 'goodsStock',width:150,isSort: false}
        ]
    });
}
function AuserGridInit(){
	ugrid = $("#userGrid").ligerGrid({
		height:h-100,
    });
}

//第二个


function shopGridInit(){
	$("#startDateB").ligerDateEditor();
	$("#endDateB").ligerDateEditor();
	sgrid = $("#shopGrid").ligerGrid({
		url:WST.U('admin/configure/pageQueryByStock'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:'100%',
        minColToggle:8,
        rownumbers:true,
        columns: [
        	{ display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x2" onclick="WST.checkChks(this,\'.chk_x2\')"/><label for="chk_x2">全选</label></p>', name: 'checkbox2',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x2" val="'+rowdata['staffId']+'" />';
	        }},
	        { display: '管理账号', name: 'loginName',isSort: false},
	        { display: '联系方式', name: 'tel',isSort: false},
	        { display: '分组', name: 'roleName',isSort: false},
	        { display: '添加时间', name: 'createTime',isSort: false},
	        { display: '操作', name: 'op',width: 150,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<a class="bianji" href="javascript:getForEditB(1,'+rowdata['staffId']+')">编辑</a><a class="kucun" href="javascript:XINB('+rowdata['roleId']+')">库存</a><a class="shanchux"  href="javascript:toDelB('+rowdata['staffId']+')">删除</a>';
	        }}
        ]
    });
}
function AshopGridInit(){
	sgrid = $("#shopGrid").ligerGrid({
		height:h-100,
    });
}



function toDelB(id){
	var box = WST.confirm({content:"您确定要删除该仓库账号吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/configure/del_stock'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		           // grid.reload();
							   shopGridInit()
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
								shopGridInit()
	           			  }
	           		});
	            }});
}

//批量删除
function toBatchDelB(){
	var ids = WST.getChks('.chk_x2');
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
	           		           // grid.reload();
							   shopGridInit()
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
								shopGridInit()
	           			  }
	           		});
	            }});
}


//
function getForEditB(se,id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/configure/get_stock'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           if(json.staffId){
           		WST.setValuesA(json,"#expressFormB");
           		toEditB(se,json.staffId);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditB(se,id){
	var title =(se==0)?"新增":"编辑";
	var box = WST.open({title:title,type:1,content:$('#expressBoxB'),area: ['430px', 'auto'],btn:['确定','取消'],yes:function(){
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
		        var params = WST.getParams('.iptb');
	                params.expressId = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/configure/'+((id==0)?"add_stock":"edit_stock")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormB')[0].reset();
	           			    	layer.close(box);
	           		            //grid.reload();
								shopGridInit()
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});

    	}

  });

}
//翻页
function XINB(id){
	
	location.href=WST.U('admin/configure/sum_store','id='+id);
}
var fanyeB=""
function moneyGridInitB(id,p_id){
	fanyeB=id;
	$("#startDate").ligerDateEditor();
	$("#endDate").ligerDateEditor();
    mgrid = $("#moneyGrid").ligerGrid({
		url:WST.U('admin/configure/sum_goods','&id='+id+'&p_id='+p_id),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:10,
        rownumbers:true,
        columns: [
        	{ display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x2" onclick="WST.checkChks(this,\'.chk_x2\')"/><label for="chk_x2">全选</label></p>', name: 'checkbox2',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x2" val="'+rowdata['userId']+'" />';
	        }},
	        { display: '商品名称', name: 'goodName',isSort: false},
	        { display: '规格', name: 'spec_value',isSort: false},
	        { display: '进价', name: 'marketPrice',isSort: false},
	        { display: '卖价', name: 'shopPrice',isSort: false},
	        { display: '货号', name: 'huohao',isSort: false},
	        { display: '采购单号', name: 'pur_number',isSort: false},
	        { display: '经手人', name: 'manager',isSort: false},
	        { display: '库存', name: 'pnumber',width:150,isSort: false},
	        { display: '时间', name: 'pur_time',isSort: false},
	         
        ]
    });
}
function toDelB1(id){
	var box = WST.confirm({content:"您确定要删除该文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/articles/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            //grid.reload();
								moneyGridInitB(fanyeB);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

//批量删除
function toBatchDelB1(){
	var ids = WST.getChks('.chk_x2');
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
	           		           // grid.reload();
							   moneyGridInitB(fanyeB);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

//2014.4.18完

//第三个
function shopGridInitX(){
	
	$("#startDateC").ligerDateEditor();
	$("#endDateC").ligerDateEditor();
	sgridYz = $("#shopGridx").ligerGrid({
		url:WST.U('admin/configure/supplier'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:'100%',
        minColToggle:9,
        rownumbers:true,
        columns: [
	       { display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x3" onclick="WST.checkChks(this,\'.chk_x3\')"/><label for="chk_x3">全选</label></p>', name: 'checkbox3',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x3" val="'+rowdata['id']+'" />';
	        }},
	        { display: '公司名称', name: 'company',isSort: false},
	        { display: '分组', name: 'group_name',isSort: false},
	        { display: '添加时间', name: 'times',isSort: false},
	        { display: '状态', name: 'status',isSort: false},
	        { display: '操作', name: 'op',width: 150,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<a class="bianji" href="javascript:getForEditC(1,'+rowdata['id']+')">编辑</a><a class="kucun"  href="javascript:XINC('+rowdata['id']+')">库存</a><a class="shanchux"  href="javascript:toDelC('+rowdata['id']+')">删除</a>';
	        }}
        ]
    });
}
function AshopGridInitX(){
	sgridYz = $("#shopGridx").ligerGrid({
		height:h-100,
    });
}


function toDelC(id){
	var box = WST.confirm({content:"您确定要删除该文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/configure/del_supplier'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            shopGridInitX();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

//批量删除
function toBatchDelC(){
	var ids = "";
	
	$(".chk_x3").each(function(){
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
	           $.post(WST.U('admin/configure/dels_supplier'),{ids:ids},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            // grid.reload();
	           		            shopGridInitX();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}



//
function getForEditC(se,id){
	$.post(WST.U('admin/configure/get_groups'),function(data,textStatus){
         var t="<option value='0'>请选择</option>";
         for (var i =0 ; i<data.length; i++) {
             t=t+"<option value='"+data[i].id+"'>"+data[i].group_name+"</option>"
         };
         $("#group_id").html(t);
     })
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/configure/get_supplier'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           console.log(json.id);
           if(json.id){
           		WST.setValues(json);
           		toEditC(se,json.id);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditC(se,id){

	if(id==0){
		$('#expressFormC').get(0).reset();
		$.post(WST.U('admin/configure/get_groups'),function(data,textStatus){
         var t="<option value='0'>请选择</option>";
         for (var i =0 ; i<data.length; i++) {
             t=t+"<option value='"+data[i].id+"'>"+data[i].group_name+"</option>"
         };
         $("#group_id").html(t);
     })
	}
	var title =(se==0)?"新增":"编辑";
	var box = WST.open({title:title,type:1,content:$('#expressBoxC'),area: ['690px', 'auto'],btn:['确定','取消'],yes:function(){
		$('#expressFormC').submit();
	}});
	$('#expressFormC').validator({

       valid: function(form){
		        var params = WST.getParams('.iptc');
	                params.id = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/configure/'+((id==0)?"supplier_add":"supplier_edit")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormC')[0].reset();
	           			    	layer.close(box);
	           		            shopGridInitX();
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});

    	}

  });

}


//翻页
function XINC(id){
	
	location.href=WST.U('admin/Supplier/index','id='+id);
}
var fanyeC="";
function moneyGridInitC(id){
	fanyeC=id;
	$("#startDate").ligerDateEditor();
	$("#endDate").ligerDateEditor();
    mgrid = $("#moneyGrid").ligerGrid({
		url:WST.U('admin/Supplier/get_supplier','id='+id),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99%',
        width:'100%',
        minColToggle:10,
        rownumbers:true,
        columns: [
        	{ display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x2" onclick="WST.checkChks(this,\'.chk_x2\')"/><label for="chk_x2">全选</label></p>', name: 'checkbox2',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x2" val="'+rowdata['id']+'" />';
	        }},
	        { display: '商品编号', name: 'goodsSn',isSort: false},
	        { display: '商品名称', name: 'goodsName',isSort: false},
	        { display: '库存', name: 'goodsStock',isSort: false},
	        { display: '进价', name: 'marketPrice',isSort: false},
	        { display: '市场价', name: 'shopPrice',isSort: false},
	        { display: '操作', name: 'op',width: 150,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<a class="bianji" href="javascript:XINC1(1,'+rowdata['id']+')">编辑产品规格</a><a class="shanchux"  href="javascript:toDelB1('+rowdata['id']+')">删除</a>';
	        }}
        ]
    });
}
function XINC1(flag,id){
	
	location.href=WST.U('admin/Supplier/get_spec_list','id='+id);
}
function toDelC1(id){
	var box = WST.confirm({content:"您确定要删除该文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/articles/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            //grid.reload();
								moneyGridInitC(fanyeC);

	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

//批量删除
function toBatchDelC1(){
	var ids = WST.getChks('.chk_x2');
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
	           		            //grid.reload();
								moneyGridInitC(fanyeC);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

function getForEditC1(se,id){
	alert(id);
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/express/get'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           console.log(json.expressId);
           if(json.expressId){
           		WST.setValues(json);
           		toEditC1(se,json.expressId);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditC1(se,id){
    
	var title =(se==0)?"新增":"编辑";
	var box = WST.open({title:title,type:1,content:$('#expressBoxC1'),area: ['690px', 'auto'],btn:['确定','取消'],yes:function(){
		$('#expressFormC1').submit();
	}});
	$('#expressFormC1').validator({
//      fields: {
//          expressName: {
//          	rule:"required;",
//          	msg:{required:"快递名称不能为空"},
//          	tip:"请输入快递名称",
//          	ok:"",
//          }
//      },
       valid: function(form){
				var class_id = $('.j-goodsCats').eq(2).find('option:selected').val();
		        var params = WST.getParams('.ipts');
	                params.expressId = id;
					params.class_id = class_id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/supplier/'+((id==0)?"add_good":"edit")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormC1')[0].reset();
	           			    	layer.close(box);
	           		            //grid.reload();
								moneyGridInitC(fanyeC);
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
	sgridY = $("#shopGridy").ligerGrid({
		url:WST.U('admin/configure/supplier_group'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:'100%',
        minColToggle:4,
        rownumbers:true,
        columns: [
	       { display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x4" onclick="WST.checkChks(this,\'.chk_x4\')"/><label for="chk_x4">全选</label></p>', name: 'checkbox4',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x4" value="'+rowdata['id']+'" />';
	        }},

	        { display: '分组名称', name: 'group_name',isSort: false},
	        { display: '排序', name: 'sort',isSort: false},
	        { display: '备注', name: 'remark',isSort: false},
	        { display: '操作', name: 'op',width: 80,isSort: false,render: function (rowdata, rowindex, value){
	        	
	        	return '<a class="bianji" href="javascript:getForEditD(1,'+rowdata['id']+')">编辑</a>';
//	        	return '<a href="javascript:tologmoneys(1,'+rowdata['shopId']+')">查看</a>&nbsp;&nbsp;&nbsp;<a href="javascript:tologmoneys(1,'+rowdata['shopId']+')">caozu</a>';
	        }}
        ]
    });
}
function AshopGridInitY(){
	sgridY = $("#shopGridy").ligerGrid({
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
	           		            grid.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

//批量删除
function toBatchDelD(){
	var ids = "";
	$(".chk_x4").each(function(){
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
	           $.post(WST.U('admin/configure/del_group'),{ids:ids},function(data,textStatus){

	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
                         console.log(json);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           			    	shopGridInitY();
	           		           
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}



//
function getForEditD(se,id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/configure/get_group'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           console.log(json.id);
           console.log(json);

           if(json.id){
           		WST.setValues(json);
           		toEditD(se,json.id);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditD(se,id){
	if(id==0){
		//WST.setValues({group_name:'',sort:'',remark:''});
		$('#expressFormD').get(0).reset();
	}
	var title =(se==0)?"新增":"编辑";
	var box = WST.open({title:title,type:1,content:$('#expressBoxD'),area: ['430px', 'auto'],btn:['确定','取消'],yes:function(){
		$('#expressFormD').submit();
	}
    });
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
		        var params = WST.getParams('.iptd');
	                params.id = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/configure/'+((id==0)?"add_group":"edit_group")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormD')[0].reset();
	           			    	layer.close(box);
	           		           
	           		            shopGridInitY();
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});
    	}
  });
}

function loadShopGrids2(){
	var params = WST.getParams('.s2_ipt');
	sgrid.set('url',WST.U('admin/configure/pageQueryByStock',params));
}

function loadShopGrids3(){
	var params = WST.getParams('.s3_ipt');
	sgridYz.set('url',WST.U('admin/configure/supplier',params));
}

function loadShopGrids4(){
	var params = WST.getParams('.s4_ipt');
	sgridY.set('url',WST.U('admin/configure/supplier_group',params));
}

