var grid;
function initGrid(){
	grid = $("#maingrid").ligerGrid({
		url:WST.U('admin/Accreds/classes'),
		pageSize:WST.pageSize,
		pageSizeOptions:WST.pageSizeOptions,
		height:'99.5%',
        width:'100%',
        minColToggle:3,
        rownumbers:true,
        columns: [
	        { display: '行业分类名称', name: 'class_name',isSort: false},
	        { display: '操作', name: 'op',width: 200,isSort: false,render: function (rowdata, rowindex, value){
	            return "<a href='javascript:getForEditA(" + rowdata['class_id'] + ")'>修改</a><span class='kongge'></span><a href='javascript:toDelA(" + rowdata['class_id'] + ")'>删除</a> ";
	        }}
        ]
    });
}

function toDelA(id){
	var box = WST.confirm({content:"您确定要删除该行业分类吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/Accreds/toDels'),{id:id},function(data,textStatus){
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
     $.post(WST.U('admin/Accreds/edit_class'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           if(json.class_id){
			  
           		WST.setValuesA(json,"#expressBoxA");
           		toEditA(json.class_id);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
//  弹窗
function toEditA(id){
	if(id==0){
		$('#expressFormA')[0].reset();
	    layer.close(box);
	}
	var title =(id==0)?"新增":"修改";
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
	                console.log(params);
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/accreds/'+((id==0)?"add_classes":"toEdits")),params,function(data,textStatus){
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
