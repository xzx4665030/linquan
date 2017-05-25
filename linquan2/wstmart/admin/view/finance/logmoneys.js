var ugrid,sgrid,mgrid,sgridX,sgridY,h;
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
	$("#endDateA").ligerDateEditor();
	ugrid = $("#userGrid").ligerGrid({
		url:WST.U('admin/finance/pageQueryAccount'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:'100%',
        minColToggle:14,
        rownumbers:true,
        columns: [
	        { display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x1" onclick="WST.checkChks(this,\'.chk_x1\')"/><label for="chk_x1">全选</label></p>', name: 'checkbox1',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x1" value="'+rowdata['id']+'"  />';
	        }},
	        { display: '名称', name: 'name',isSort: false},
	        { display: '账号', name: 'number',isSort: false},
	        { display: '账号名称', name: 'account_name',isSort: false},
	        { display: '余额', name: 'lockMoney',isSort: false},
	        { display: '排序', name: 'sort',isSort: false},
	        { display: '操作', name: 'op',width: 100,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<a class="bianji" href="javascript:getForEditA(1,'+rowdata['id']+')">编辑</a><a class="shanchux"  href="javascript:toDelA('+rowdata['id']+')">删除</a>';
	        }}
        ]
    });
}


function toDelA(id){
	var box = WST.confirm({content:"您确定要删除该文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/finance/del_account'),{id:id},function(data,textStatus){
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
	           $.post(WST.U('admin/finance/dels_account'),{ids:ids},function(data,textStatus){
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
function getForEditA(se,id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/finance/get_account'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           console.log(json.id);
           if(json.id){
           		WST.setValuesA(json,'#expressFormA');
           		toEditA(se,json.id);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditA(se,id){
	if(id==0){
		$('#expressFormA').get(0).reset();
	}
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
	                params.id = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/finance/'+((id==0)?"add_account":"edit_account")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormA')[0].reset();
	           			    	layer.close(box);
	           		            ugrid.reload();
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});

    	}

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
	$("#time").ligerDateEditor();
	$(".time1").ligerDateEditor();
	sgrid = $("#shopGrid").ligerGrid({
		url:WST.U('admin/finance/pageQueryFinance'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:'100%',
        minColToggle:14,
        rownumbers:true,
        columns: [
        	{ display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x2" onclick="WST.checkChks(this,\'.chk_x2\')"/><label for="chk_x2">全选</label></p>', name: 'checkbox2',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x2" value="'+rowdata['id']+'" />';
	        }},
	        { display: '单号', name: 'number',isSort: false},
	        { display: '日期', name: 'time',isSort: false},
	        { display: '类型', name: 'type',isSort: false,render: function (rowdata, rowindex, value){
	        	var hh;
	        	if(rowdata['type']==1){
	        		hh="收入";
	        	}else if(rowdata['type']==2){
	        		hh="支出";
	        	}else if(rowdata['type']==3){
	        		hh="内部转账";
	        	}
	        	return hh;
	        }},
	        { display: '财务类别', name: 'account_type',isSort: false},
	        { display: '金额', name: 'money',isSort: false},
	        { display: '收款银行', name: 'recive_bank',isSort: false},
	        { display: '付款银行', name: 'pay_bank',isSort: false},
	        { display: '发票', name: 'invoice',isSort: false},
	        { display: '经手人', name: 'operator',isSort: false},
	        { display: '客户名称', name: 'name',isSort: false},
	        { display: '备注', name: 'remark',isSort: false},
	        { display: '状态', name: 'status',isSort: false},
	        { display: '操作', name: 'op',width: 100,isSort: false,render: function (rowdata, rowindex, value){
	        	if(rowdata['type']==3){
	        		return '<a class="bianji" href="javascript:yhang2('+rowdata['type']+','+rowdata['id']+')">编辑</a><a class="shanchux"  href="javascript:toDelB('+rowdata['id']+')">删除</a>';
	        	}else{
	        		return '<a class="bianji" href="javascript:getForEditB('+rowdata['type']+','+rowdata['id']+')">编辑</a><a class="shanchux"  href="javascript:toDelB('+rowdata['id']+')">删除</a>';
	        	}
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
	var box = WST.confirm({content:"您确定要删除该文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/finance/del_detail'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            sgrid.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

//批量删除
function toBatchDelB(){
	var ids = "";
	
	$(".chk_x2").each(function(){
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
	           $.post(WST.U('admin/finance/dels_detail'),{ids:ids},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            sgrid.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

//获取类型
function leix(se,qu){
	$.ajax({
		type:"post",
		url:WST.U('admin/finance/get_types'),
		async:true,
		data:{'type':se},
		dataType:'json',
		success:function(data){
			var op="<option value=''>请选择</option>";
			for (var p=0;p<data.length;p++) {
				op=op+'<option value="'+data[p].id+'">'+data[p].name+'</option>';
			}
			$("#account_type").html(op);
		}
	});
	yhang(se,qu);
}

//获取银行
function yhang(se,qu){
	$.ajax({
		type:"post",
		url:WST.U('admin/finance/get_accounts'),
		async:true,
		data:{'type':se},
		dataType:'json',
		success:function(data){
			var ds="<option value=''>请选择</option>";
			if (se==1) {
				ds='<select id="recive_bank"  name="recive_bank" class="iptb1">'+ds;
			}else if(se==2){
				ds='<select id="pay_bank"  name="pay_bank" class="iptb1">'+ds;
			}
			for (var p=0;p<data.length;p++) {
				ds=ds+'<option value="'+data[p].id+'">'+data[p].name+'</option>';
			}
			ds=ds+'</select>'
			$(".bank").html(ds);
		}
	});
	if(qu>0){
		kk(se,qu);
	}
}

//
function getForEditB(se,id){
	leix(se,id);
}
function kk(se,id){
	var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/finance/get_detail'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           console.log(json.id);
           if(json.id){
           		WST.setValuesA(json,'#expressFormB');
           		toEditB(se,json.id);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditB(se,id){
	var title =(id==0)?"新增":"编辑";
	
	if(se==1){
		$("#leixing_x").html("收入");
		$("#ss_ylf").html("收");
		$("#ff_ylf").html("收");
	}else{
		$("#leixing_x").html("支出");
		$("#ss_ylf").html("付");
		$("#ff_ylf").html("付");
	}
	if(id==0){
		$('#expressFormB').get(0).reset();
		$("#type").val(se);
		var tt=(new Date().getTime()).toString().substring(5);
		$(".number").val((new Date().getTime()).toString().substring(5)+Math.ceil(Math.random()*100));
		leix(se,0);
	}
	var box = WST.open({title:title,type:1,content:$('#expressBoxB'),area: ['760px', 'auto'],btn:['确定','取消'],yes:function(){
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
		        var params = WST.getParams('.iptb1');
	                params.id = id;
	                console.log(params);
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/finance/'+((id==0)?"add_detail":"edit_detail")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormB')[0].reset();
	           			    	layer.close(box);
	           		            sgrid.reload();
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});

    	}

  });

}



function yhang2(se,id){
	$.ajax({
		type:"post",
		url:WST.U('admin/finance/get_accounts'),
		async:true,
		data:{'type':se},
		dataType:'json',
		success:function(data){
			var yh1='<select id="recive_bank"  name="recive_bank" class="iptb2"><option value="">请选择</option>';
			var yh2='<select id="pay_bank"  name="pay_bank" class="iptb2"><option value="">请选择</option>';
			for (var p=0;p<data.length;p++) {
				yh1=yh1+'<option value="'+data[p].id+'">'+data[p].name+'</option>';
				yh2=yh2+'<option value="'+data[p].id+'">'+data[p].name+'</option>';
			}
			yh1=yh1+'</select>'
			yh2=yh2+'</select>'
			$(".bank1").html(yh1);
			$(".bank2").html(yh2);
			if(id>0){
				getForEditB2(se,id);
			}
		}
	});
}


function getForEditB2(se,id){
	var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/finance/get_detail'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           console.log(json.id);
           if(json.id){
           		WST.setValuesA(json,'#expressFormB2');
           		toEditB2(se,json.id);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditB2(se,id){
	var title =(id==0)?"新增":"编辑";
	
	
	if(id==0){
		$('#expressFormB2').get(0).reset();
		$(".number").val((new Date().getTime()).toString().substring(5)+Math.ceil(Math.random()*100));
		yhang2(se,0);
	}
	var box = WST.open({title:title,type:1,content:$('#expressBoxB2'),area: ['760px', 'auto'],btn:['确定','取消'],yes:function(){
		$('#expressFormB2').submit();
	}});
	$('#expressFormB2').validator({
//      fields: {
//          expressName: {
//          	rule:"required;",
//          	msg:{required:"快递名称不能为空"},
//          	tip:"请输入快递名称",
//          	ok:"",
//          }
//      },
       valid: function(form){
		        var params = WST.getParams('.iptb2');
	                params.id = id;
	                console.log(params);
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/finance/'+((id==0)?"add_detail":"edit_detail")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormB2')[0].reset();
	           			    	layer.close(box);
	           		            sgrid.reload();
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
	$("#riqi").ligerDateEditor();
	sgridX = $("#shopGridx").ligerGrid({
		url:WST.U('admin/finance/pageQueryByShop'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:h-100,
        width:'100%',
        minColToggle:6,
        rownumbers:true,
        columns: [
	       { display: '<p class="quanxuan"><input type="checkbox" style="display:none;" id="chk_x3" onclick="WST.checkChks(this,\'.chk_x3\')"/><label for="chk_x3">全选</label></p>', name: 'checkbox3',width: 60,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<input type="checkbox" class="chk_x3" value="'+rowdata['id']+'" />';
	        }},
	        { display: '名称', name: 'name',isSort: false},
	        { display: '类型', name: 'type',isSort: false},
	        { display: '排序', name: 'sort',isSort: false},
	        { display: '操作', name: 'op',width: 100,isSort: false,render: function (rowdata, rowindex, value){
	        	return '<a class="bianji" href="javascript:getForEditC(1,'+rowdata['id']+')">编辑</a>';
	        }}
        ]
    });
}
function AshopGridInitX(){
	sgridX = $("#shopGridx").ligerGrid({
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
	           		            sgridX.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

//批量删除
function toBatchDelC(){
	//var ids = WST.getChks('.chk3');
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
	           $.post(WST.U('admin/finance/dels_type'),{ids:ids},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            sgridX.reload();
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}



//
function getForEditC(se,id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/finance/get_type'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           console.log(json.id);
           if(json.id){
           		WST.setValuesA(json,'#expressFormC');
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
	}
	var title =(se==0)?"新增":"编辑";
	var box = WST.open({title:title,type:1,content:$('#expressBoxC'),area: ['400px', 'auto'],btn:['确定','取消'],yes:function(){
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
		        var params = WST.getParams('.iptc');
	                params.id = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/finance/'+((id==0)?"add_type":"edit_type")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormC')[0].reset();
	           			    	layer.close(box);
	           		            sgridX.reload();
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});

    	}
  });
}





//第四个
var z_name=new Array();
var z_y=new Array();
var z_m=new Array();
var z_w=new Array();
var s_name=new Array();
var s_y=new Array();
var s_m=new Array();
var s_w=new Array();
function shopGridInitY(){
	$("#shopGridy").height(h-100);
     $.ajax({
     	type:"post",
     	url:WST.U('admin/finance/pageQueryStatistics'),
     	async:true,
     	success:function (data){
     		console.log(data);
     		var sr="<tr><td>收入</td><td>"+data.total.total_sw+"</td><td>"+data.total.total_sm+"</td><td>"+data.total.total_sy+"</td><td>"+data.total.total_ss+"</td></tr>";
     		var zc="<tr><td>支出</td><td>"+data.total.total_zw+"</td><td>"+data.total.total_zm+"</td><td>"+data.total.total_zy+"</td><td>"+data.total.total_zs+"</td></tr>";
     		$("#tongji").append(sr+zc);
	     	for(var p=0;p<data.zhichu.length;p++){
	     		z_name[p]=data.zhichu[p].name;
	     		z_y[p]=data.zhichu[p].zm;
	     		z_m[p]=data.zhichu[p].zm;
	     		z_w[p]=data.zhichu[p].zw;
	     	}
	     	for(var q=0;q<data.shouru.length;q++){
	     		s_name[q]=data.shouru[q].name;
	     		s_y[q]=data.shouru[q].sm;
	     		s_m[q]=data.shouru[q].sm;
	     		s_w[q]=data.shouru[q].sw;
	     	}
	     	zhichut();
	     	shourut();
	     	console.log(z_name);
     	}
     });
	
}
function zhichut(){
	var myChart = echarts.init(document.getElementById('zhichu'));
	var option={
		//鼠标悬浮
	    tooltip: {
	        trigger: 'axis',
	        axisPointer: {
	            type: 'cross',
	            
	        }
	    },
	    //功能：切换，下载
	    toolbox: {
	        feature: {
	            dataView: {show: true, readOnly: false},
	            magicType: {show: true, type: ['line', 'bar']},
	            restore: {show: true},
	            saveAsImage: {show: true}
	        }
	    },
	    //标题
	    legend: {
	        data:['本周','本月','本年']
	    },
	    xAxis: [
	        {
	            type: 'category',
	            data: z_name,
	            axisPointer: {
	                type: 'shadow'
	            }
	        }
	    ],
	    yAxis: [
	        {
	            type: 'value',
	            name: '金额',
	            axisLabel: {
	                formatter: '{value} 元'
	            }
	        }
	    ], 
	    series: [
	        {
	            name:'本周',
	            type:'bar',
	            data:z_w,
	            label: {
	                normal: {
	                    show: true,
	                    position: 'top',
	                    formatter: '{c}元'
	                }
	            }
	        },
	        {
	            name:'本月',
	            type:'bar',
	            data:z_m,
	            label: {
	                normal: {
	                    show: true,
	                    position: 'top',
	                    formatter: '{c}元'
	                }
	            }
	        },
	        {
	            name:'本年',
	            type:'bar',
	            data:z_y,
	            label: {
	                normal: {
	                    show: true,
	                    position: 'top',
	                    formatter: '{c}元'
	                }
	            }
	        }
	    ]
	}
	 myChart.setOption(option);
}

function shourut(){
	var myChart = echarts.init(document.getElementById('shouru'));
	var options={
		//鼠标悬浮
	    tooltip: {
	        trigger: 'axis',
	        axisPointer: {
	            type: 'cross',
	            
	        }
	    },
	    //功能：切换，下载
	    toolbox: {
	        feature: {
	            dataView: {show: true, readOnly: false},
	            magicType: {show: true, type: ['line', 'bar']},
	            restore: {show: true},
	            saveAsImage: {show: true}
	        }
	    },
	    //标题
	    legend: {
	        data:['本周','本月','本年']
	    },
	    xAxis: [
	        {
	            type: 'category',
	            data: s_name,
	            axisPointer: {
	                type: 'shadow'
	            }
	        }
	    ],
	    yAxis: [
	        {
	            type: 'value',
	            name: '金额',
	            axisLabel: {
	                formatter: '{value} 元'
	            }
	        }
	    ], 
	    series: [
	        {
	            name:'本周',
	            type:'bar',
	            data:s_w,
	            label: {
	                normal: {
	                    show: true,
	                    position: 'top',
	                    formatter: '{c}元'
	                }
	            }
	        },
	        {
	            name:'本月',
	            type:'bar',
	            data:s_m,
	            label: {
	                normal: {
	                    show: true,
	                    position: 'top',
	                    formatter: '{c}元'
	                }
	            }
	        },
	        {
	            name:'本年',
	            type:'bar',
	            data:s_y,
	            label: {
	                normal: {
	                    show: true,
	                    position: 'top',
	                    formatter: '{c}元'
	                }
	            }
	        }
	    ]
	}
	 myChart.setOption(options);
}

function AshopGridInitY(){
	$("#shopGridy").height(h-100);
}

function loadShopGrids2(){
	var params = WST.getParams('.s2_ipt');
	sgrid.set('url',WST.U('admin/finance/pageQueryFinance',params));
}

function loadShopGrids3(){
	var params = WST.getParams('.s3_ipt');
	sgridX.set('url',WST.U('admin/finance/pageQueryByShop',params));
}

function loadShopGrids4(){
	var params = WST.getParams('.s4_ipt');
	sgridX.set('url',WST.U('admin/finance/pageQueryStatistics',params));
}

