var grid;
function initGrid(){
	grid = $("#maingrid").ligerGrid({
		url:WST.U('admin/mobile/pageQueryByMobile'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99.5%',
        width:'100%',
        minColToggle:4,
        rownumbers:true,
        columns: [
            { display: '专题编号', name: 'special_id',width: 100,Sort: false},
	        { display: '专题描述', name: 'special_desc',isSort: false},
	        { display: '操作', name: 'op',width: 200,isSort: false,render: function (rowdata, rowindex, value){
	            return "<a href='javascript:getForEditA(" + rowdata['special_id'] + ")'>修改</a><span class='kongge'></span><a href='javascript:toEdit(" + rowdata['special_id'] + ")'>编辑</a><span class='kongge'></span><a href='javascript:toDelA(" + rowdata['special_id'] + ")'>删除</a> ";
	        }}
        ]
    });
}

function toDelA(id){
	var box = WST.confirm({content:"您确定要删除该文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/mobile/special_del'),{id:id},function(data,textStatus){
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
function getForEditA(id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/mobile/special_get'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           console.log(json.special_id);
           if(json.special_id){
           		WST.setValues(json);
           		toEditA(json.special_id);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditA(id){
	var title =(id==0)?"新增":"修改";
	if(id==0){
		//WST.setValues({group_name:'',sort:'',remark:''});
		$('#expressFormA').get(0).reset();
		$("#tj_tan  tr:not(:first)").html("");
	}
	var box = WST.open({title:title,type:1,content:$('#expressBoxA'),area: ['550px', 'auto'],btn:['确定','取消'],yes:function(){
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
		        var params = WST.getParams('.ipt');
	                params.id = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/mobile/'+((id==0)?"special_add":"special_edit")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#expressFormA')[0].reset();
	           			    	layer.close(box);
	           		            grid.reload();
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});

    	}

  });

}

function toEdit(id){
	location.href=WST.U('admin/mobile/item_index','id='+id);
}
function toEditx(leibie,id){
	location.href=WST.U('admin/mobile/item_edit','id='+id+'&leibie='+leibie);
}
//function loadGrid(){
//	grid.set('url',WST.U('admin/cashdraws/pageQuery','cashNo='+$('#cashNo').val()+"&cashSatus="+$('#cashSatus').val()+"&targetType="+$('#targetType').val()));
//}

//function save(){
//	if(WST.confirm({content:'您确定通过该提现申请吗？',yes:function(){
//      var params = WST.getParams('.ipt');
//		var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
//	    $.post(WST.U('admin/cashdraws/handle'),params,function(data,textStatus){
//	    	layer.close(loading);
//	    	var json = WST.toAdminJson(data);
//	    	if(json.status=='1'){
//	    		WST.msg("操作成功",{icon:1});
//	    		location.href=WST.U('admin/cashdraws/index');
//	    	}else{
//	    		WST.msg(json.msg,{icon:2});
//	    	}
//	    });
//	}}));
//}