<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:59:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\stock\list.html";i:1493970484;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>后台管理中心 - <?php echo WSTConf('CONF.mallName'); ?></title>
<meta name="Keywords" content=""/>
<meta name="Description" content=""/> 
<link href="__ADMIN__/js/ligerui/skins/Aqua/css/ligerui-all.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" /> 
<link href="__STATIC__/plugins/validator/jquery.validator.css?v=<?php echo $v; ?>" rel="stylesheet">

<style>
	
</style>

<link href="__ADMIN__/css/style.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" />   
<script src="__STATIC__/js/jquery.min.js?v=<?php echo $v; ?>"></script>  
<script src="__ADMIN__/js/ligerui/js/ligerui.all.js?v=<?php echo $v; ?>" type="text/javascript"></script> 
<script type='text/javascript' src='__STATIC__/plugins/layer/layer.js?v=<?php echo $v; ?>'></script> 
<script src="__STATIC__/js/common.js?v=<?php echo $v; ?>"></script>
<script>
window.conf = {"DOMAIN":"<?php echo str_replace('index.php','',\think\Request::instance()->root(true)); ?>","ROOT":"__ROOT__","APP":"__APP__","STATIC":"__STATIC__","SUFFIX":"<?php echo config('url_html_suffix'); ?>","GOODS_LOGO":"<?php echo WSTConf('CONF.goodsLogo'); ?>","SHOP_LOGO":"<?php echo WSTConf('CONF.shopLogo'); ?>","MALL_LOGO":"<?php echo WSTConf('CONF.mallLogo'); ?>","USER_LOGO":"<?php echo WSTConf('CONF.userLogo'); ?>",'GRANT':'<?php echo implode(",",session("WST_STAFF.privileges")); ?>',"ROUTES":'<?php echo WSTRoute(); ?>'}
</script>
<script src="__ADMIN__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="__STATIC__/plugins/validator/jquery.validator.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="__STATIC__/plugins/validator/local/zh-CN.js?v=<?php echo $v; ?>"></script>
</head>
<body>

<style type="text/css">
	body {
		overflow: hidden
	}
	.wst-toolbar{
		border-top: 1px solid #f4f4f4;
	}
	.quanxuan label{display:block;width: 100%;height: 100%;background: #88b547;color: #fff;cursor: pointer;}
	#wst-tabs .l-tab-links,.wst-toolbar{
		background-color: #fff;
		margin-top: 0px;
		text-indent: 6px;
	}
	#wst-tabs .l-tab-links ul{
		margin-top: 12px;
	}
	#wst-tabs .l-tab-links{
		height: 50px ;
	}
	.layui-layer{ border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;overflow: hidden;}
	select,option{height: 38px;line-height: 38px;width: 80px;}
	input[type="text"]{padding: 0px;height: 28px;}
	td{line-height: 28px}
	input[type="checkbox"]{vertical-align: top;}
	.bianji,.kucun,.shanchux{color: #069add;margin-left: 20px;cursor:pointer;}
	.biaoge_p{margin: 0px ;padding: 0px;line-height: 28px;margin:auto;margin-top: 8px;width: 737px;display: block;}
	.biaoge_p1{margin: 0px ;padding: 0px;line-height: 28px;margin:auto;margin-top: 8px;width: 660px;display: block;}
	.biaoge_p .biaoti{display: inline-block;width: 75px;text-align: right;vertical-align: top;}
	.biaoge_p .changdu1{width: 120px;}
	.biaoge_p .changdu2{width: 200px;}
	.biaoge_p1 .changdu2{width: 200px;margin-right: 30px;}
	.biaoge_p .changdu3{width: 290px;}
	.biaoge_p .changdu4{width:370px;background: #f00;display: inline-block;}
	.layui-layer-btn {padding-right: 26px;}
	.l-text-wrapper{display: inline-block;}
	.biaoge_p select,.biaoge_p option{height: 28px;line-height: 28px;}
	.l-box-dateeditor.l-box-dateeditor-absolute{z-index: 200000000}
	form .l-text{width: 155px;}

	/*
	table样式
	*/
	#tj_tan,#tj_tanb{margin: auto;width: 92%}
	#tj_tan td{padding: 2px 5px;text-align: center;}
	#tj_tanB td{padding: 2px 5px;text-align: center;}
	
	#tj_tanB .cangku{display:none;}
</style>
<!--<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>-->
<div class="l-loading" style='display:block' id="wst-loading"></div>
<div id="wst-tabs" style="width:100%; height:100%;overflow: hidden; border: 1px solid #D3D3d3;" class="liger-tab">
	<!--
    	作者：1351661878@qq.com
    	时间：2017-04-13
    	描述：第一个页面
    -->
	<div id="users" tabId="users" title="采购进货" class='wst-tab' style="height: 99%">
		<div class="wst-toolbar">
			<button class="tianjia" onclick="javascript:toEditA(0,0)">添加</button>
			<button class="shanchu" onclick="javascript:toBatchDelA(0,0)" >删除</button>
			<select name="">
				<option value="">供应商</option>
				<option value=""></option>
			</select>
			<select name="">
				<option value="">仓库</option>
				<option value=""></option>
			</select>
			操作日期：
			<input type="text" style="margin:0px;vertical-align:baseline;" id="startDateA" name="startDateA" class="ipt" maxLength="20"  />
			至
			<input type="text" style="margin:0px;vertical-align:baseline;" id="endDateA" name="endDateA" class="ipt" maxLength="20"  />
			<input type='text' id='key2' placeholder='账号/店铺名称' />
			<button class="btn btn-blue" onclick="javascript:loadShopGrid(0)">查询</button>
		</div>
		<div id='userGrid'></div>
	</div>
	<!--
    	作者：1351661878@qq.com
    	时间：2017-04-13
    	描述：第二个页面
    -->
	<div id="shops" tabId="shops" title="调拨出库" class='wst-tab' style="height: 99%">
		<div class="wst-toolbar">
			<button class="tianjia" onclick="javascript:toEditB(0,0)">添加</button>
			<button class="shanchu" onclick="javascript:toBatchDelB(0,0)" >删除</button>
			<select name="">
				<option value=""></option>
				<option value=""></option>
			</select>
			<select name="">
				<option value=""></option>
				<option value=""></option>
			</select>
			操作日期：
			<input type="text" style="margin:0px;vertical-align:baseline;" id="startDateB" name="startDateB" class="ipt" maxLength="20"  />
			至
			<input type="text" style="margin:0px;vertical-align:baseline;" id="endDateB" name="endDateB" class="ipt" maxLength="20"  />
			<input type='text' id='key2' placeholder='账号/店铺名称' />
			<button class="btn btn-blue" onclick="javascript:loadShopGrid(0)">查询</button>
		</div>
		<div id='shopGrid'></div>
	</div>
	<!--
    	作者：1351661878@qq.com
    	时间：2017-04-13
    	描述：第三个
    -->
	<div id="shopsx" tabId="shopsx" title="调拨入库" class='wst-tab' style="height: 99%">
		<div class="wst-toolbar">
			<button class="tianjia" onclick="javascript:toEditC(0,0)">添加</button>
			<button class="shanchu" onclick="javascript:toBatchDelC(0,0)" >删除</button>
			<select name="">
				<option value="">出仓</option>
				<option value=""></option>
			</select>
			<select name="">
				<option value="">仓库</option>
				<option value=""></option>
			</select>
			操作日期：
			<input type="text" style="margin:0px;vertical-align:baseline;" id="startDateC" name="startDateC" class="ipt" maxLength="20"  />
			至
			<input type="text" style="margin:0px;vertical-align:baseline;" id="endDateC" name="endDateC" class="ipt" maxLength="20"  />
			<input type='text' id='key2' placeholder='账号/店铺名称' />
			<button class="btn btn-blue" onclick="javascript:loadShopGrid(0)">查询</button>
		</div>
		<div id='shopGridx'></div>
	</div>
	<!--
    	作者：1351661878@qq.com
    	时间：2017-04-13
    	描述：第四个
    -->
	<div id="shopsy" tabId="shopsy" title="库存盘点" class='wst-tab' style="height: 99%">
		<div class="wst-toolbar">
			<button class="tianjia" onclick="javascript:toEditD(0,0)">添加</button>
			<button class="shanchu" onclick="javascript:toBatchDelD(0,0)" >删除</button>
			<!--<select name="">
				<option value="">出仓</option>
				<option value=""></option>
			</select>-->
			<select name="">
				<option value="">仓库</option>
				<option value=""></option>
			</select>
			操作日期：
			<input type="text" style="margin:0px;vertical-align:baseline;" id="startDateD" name="startDateD" class="ipt" maxLength="20"  />
			至
			<input type="text" style="margin:0px;vertical-align:baseline;" id="endDateD" name="endDateD" class="ipt" maxLength="20"  />
			<input type='text' id='key2' placeholder='账号/店铺名称' />
			<button class="btn btn-blue" onclick="javascript:loadShopGrid(0)">查询</button>
		</div>
		<div id='shopGridy'></div>
	</div>
	<!--
    	作者：1351661878@qq.com
    	时间：2017-04-13
    	描述：第无个页面
    -->
	<div id="shopsE" tabId="shopsE" title="库存调整" class='wst-tab' style="height: 99%">
		<div class="wst-toolbar">
			<button class="tianjia" onclick="javascript:toEditE(0,0)">添加</button>
			<button class="shanchu" onclick="javascript:toBatchDelE(0,0)" >删除</button>
			<!--<select name="">
				<option value=""></option>
				<option value=""></option>
			</select>-->
			<select name="">
				<option value="">仓库</option>
				<option value=""></option>
			</select>
			操作日期：
			<input type="text" style="margin:0px;vertical-align:baseline;" id="startDateE" name="startDateE" class="ipt" maxLength="20"  />
			至
			<input type="text" style="margin:0px;vertical-align:baseline;" id="endDateE" name="endDateE" class="ipt" maxLength="20"  />
			<input type='text' id='key2' placeholder='账号/店铺名称' />
			<button class="btn btn-blue" onclick="javascript:loadShopGrid(0)">查询</button>
		</div>
		<div id='shopGridE'></div>
	</div>
	<!--
    	作者：1351661878@qq.com
    	时间：2017-04-13
    	描述：第六个页面
    -->
	<div id="shopsF" tabId="shopsF" title="订单发货" class='wst-tab' style="height: 99%">
		<div class="wst-toolbar">
			<!-- <button class="tianjia" onclick="javascript:toEditF(0,0)">添加</button> -->
			<button class="shanchu" onclick="javascript:toBatchDelF(0,0)" >删除</button>
			<select name="">
				<option value="">状态</option>
				<option value=""></option>
			</select>
			<select name="">
				<option value="">仓库</option>
				<option value=""></option>
			</select>
			操作日期：
			<input type="text" style="margin:0px;vertical-align:baseline;" id="startDateF" name="startDateF" class="ipt" maxLength="20"  />
			至
			<input type="text" style="margin:0px;vertical-align:baseline;" id="endDateF" name="endDateF" class="ipt" maxLength="20"  />
			<input type='text' id='key2' placeholder='账号/店铺名称' />
			<button class="btn btn-blue" onclick="javascript:loadShopGrid(0)">查询</button>
		</div>
		<div id='shopGridF'></div>
	</div>
</div>
<!--
	作者：1351661878@qq.com
	时间：2017-04-14
	描述：第一个
-->
<div id='expressBoxA' style='display:none'>
    <form id='expressFormA' autocomplete="off">
    <input type="hidden" />
	    <p class="biaoge_p"  >
	    	单号:<span  id="pur_number"></span>
	    	<!-- <span style="float: right;">
	    		最后编辑：sdsdsds
	    	</span> -->
	    </p>
	    <p class="biaoge_p">
	    	<span class="biaoti">调入仓库<font color='red'>*</font>：</span>
	    	<select class="changdu1 ipta" name="store_id" id="store_id" >
	    		<option value="0">请选择</option>
	    		<?php if(is_array($stock_list) || $stock_list instanceof \think\Collection): $i = 0; $__LIST__ = $stock_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vos): $mod = ($i % 2 );++$i;?>
	    		   <option value="<?php echo $vos['roleId']; ?>"><?php echo $vos['roleName']; ?></option>
	    		<?php endforeach; endif; else: echo "" ;endif; ?>
	    	</select>
	    	<span class="biaoti" style="margin-left: 60px;">经手人<font color='red'>*</font>：</span>
	    	<select class="changdu1 ipta" name="manager_id" id="manager_id" >
	    		<option value="0">请选择</option>
	    	</select>
	    	<span class="biaoti" style="margin-left: 60px;">供应商<font color='red'>*</font>：</span>
	    	<select class="changdu1 ipta" name="supplier_id"  id="supplier_id"  >
	    		<option value="0">请选择</option>
	    		<?php if(is_array($supplier) || $supplier instanceof \think\Collection): $i = 0; $__LIST__ = $supplier;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	    		<option value="<?php echo $vo['id']; ?>"><?php echo $vo['company']; ?></option>
	    		<?php endforeach; endif; else: echo "" ;endif; ?>
	    	</select>
	    </p>
	    <p class="biaoge_p">
	    	<span class="biaoti">日期<font color='red'>*</font>：</span>
	    	<input type="text" style="margin:0px;vertical-align:baseline;" id="pur_time" name="pur_time" class="ipta" maxLength="20"  />
	    	<span style="float: right;">
		    	<span class="biaoti">备注<font color='red'>*</font>：</span>
		    	<input type='text' id='note' name="note"  class='ipta changdu3' maxLength='20'/>
	    	</span>
	    </p>
	    <table id="tj_tan">
    	

    </table>
    </form>

 </div>
<!--
	作者：1351661878@qq.com
	时间：2017-04-14
	描述：第er个
-->
<div id='expressBoxB' style='display:none'>
    <form id='expressFormB' autocomplete="off">
    <input type="hidden" />
    	<p class="biaoge_p">
	    	单号：<span  id="stock_number" class="iptb"></span>
	    	
	    </p>
	    <p class="biaoge_p">
	    	<span class="biaoti">调拨仓库<font color='red'>*</font>：</span>
	    	<select class="changdu1 iptb" name="stock_id" id="a" >
	    		<option value="0">请选择</option>
	    		<?php if(is_array($stock_list) || $stock_list instanceof \think\Collection): $i = 0; $__LIST__ = $stock_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vos): $mod = ($i % 2 );++$i;?>
	    		   <option value="<?php echo $vos['roleId']; ?>"><?php echo $vos['roleName']; ?></option>
	    		<?php endforeach; endif; else: echo "" ;endif; ?>
	    	</select>
	    	<span class="biaoti">经手人<font color='red'>*</font>：</span>
	    	<select class="changdu1 iptb" id="jsr" name="jsr_id">
	    		<option value="">请选择</option>
	    	</select>
	    	<span class="changdu1" class="biaoti">调拨对象<font color='red'>*</font>：</span>
			<select id="b"  name="call_obj" class="iptb">
	    		<option value="">请选择</option>
	    	</select>
	    	<select style="display:none;" id="c" name="call_obj_id" class="iptb">
	    		
	    	</select>
	    </p>
	    <p class="biaoge_p">
	    	<span class="biaoti">日期<font color='red'>*</font>：</span>
	    	<input type="text" style="margin:0px;vertical-align:baseline;" id="timeB" name="timeB" class="iptb" maxLength="20"  />
	    	<span style="float:right;">
	    		
	    	<span class="biaoti">备注<font color='red'>*</font>：</span>
	    	<input type='text' id='expressName' name="expressName"  class='iptb changdu3' maxLength='20'/>
	    	</span>
	    </p>
		<table id="tj_tanB">
    	

		</table>
    </form>
 </div>
 <script>
	$(function(){
	$("#timeB").ligerDateEditor();
		$("#a").change(function(){
			$("#c").hide();
			$("#c").html("");
			$("#b").unbind();
			$("#c").unbind();
			$("#b").html('<option value="">请选择</option>');
			var stock_id = $(this).val();   //仓库id变量
			if(stock_id>0){
				//alert(stock_id);
				data = {'stock_id':stock_id};
				$.ajax({
					type:'post',
					url:WST.U('admin/stock/get_staff'),
					data:data,
					dataType:'json',
					success:function(json){
					console.log(json);
						var hhh='<option value="">请选择</option>';
						for(var m=0;m<json.staff_list.length;m++){
							hhh=hhh+'<option value="'+json.staff_list[m].staffId+'">'+json.staff_list[m].loginName+'</option>';
						}
						$("#jsr").html(hhh);
						var trB="<tr><td><input type='checkbox' id='dsbB' style='display:none;'/><label for='dsbB'>全选</label></td><td>商品编号</td><td>商品名称</td><td>规格型号</td><td>单位</td><td>库存数量</td><td>调拨数量</td></tr>";
						 for (var i = 0; i < json.goods_list.length; i++) {
							trB=trB+"<tr><td><input class='dsbB' type='checkbox' value='" +json.goods_list[i].p_good_id+"'/></td>";
							trB=trB+"<td>"+(i+1)+"</td><td class='bianhao'>"+json.goods_list[i].p_huohao+"</td><td>"+json.goods_list[i].goodsName+"</td><td>"+json.goods_list[i].spec_value+"</td><td>"+json.goods_list[i].goodsUnit+"</td><td>"+json.goods_list[i].pnumber+"</td>";
							trB=trB+"<td><input type='text' class='shuliang' /></td><td class='cangku'>"+json.goods_list[i].store_id+"</td></tr>"
							
						 }
						 $("#tj_tanB").html(trB);
						 $("#dsbB").click(function(){
							if ($(this).is(':checked')) {
								$('.dsbB').each(function(){
									$(this).prop("checked",true);
								})
							}else{
								$('.dsbB').each(function(){
									$(this).prop("checked",false);
								})
							}
						 })
						
					}
				})

				$("#b").html('<option value="">请选择</option><option value="1">仓库</option><option value="2">网店</option>');
				$("#b").change(function(){
					var select_id = $(this).val(); //选择的是网店还是仓库
					if(select_id>0){
						datas = {'stock_id':stock_id,'select_id':select_id};
						$.ajax({
							type:'post',
							url:WST.U('admin/stock/get_stockinfo'),
							data:datas,
							dataType:'json',
							success:function(result){
								document.getElementById('c').options.length=0;
								var opt = document.createElement('option');
								opt.text = "请选择";
								document.getElementById('c').add(opt);
								for (i = 0; i < result.length; i++)  
								{  
								  var opt = document.createElement('OPTION');  
								  opt.value = result[i].id;      
								  opt.text  = result[i].name;  
								  document.getElementById('c').add(opt);
								}
							}
						})
						$("#c").show();
						
					}else{
						$("#c").html('');
						$("#c").hide();
					}
				})
			}
		})
	})
 </script>
<!--
	作者：1351661878@qq.com
	时间：2017-04-14
	描述：第san个
-->
<div id='expressBoxC' style='display:none'>
    <form id='expressFormC' autocomplete="off">
    <input type="hidden" />
    	<p class="biaoge_p">
	    	单号：1545454545
	    	<span style="float: right;">
	    		最后编辑：sdsdsds
	    	</span>
	    </p>
	    <p class="biaoge_p">
	    	<span class="biaoti">调入仓库<font color='red'>*</font>：</span>
	    	<select name="">
	    		<option value="">2315</option>
	    	</select>
	    	<span class="biaoti">经手人<font color='red'>*</font>：</span>
	    	<select name="">
	    		<option value="">2315</option>
	    	</select>
	    	<span class="biaoti">供应商<font color='red'>*</font>：</span>
	    	<select name="">
	    		<option value="">2315</option>
	    	</select>
	    </p>
	    <p class="biaoge_p">
	    	<span class="biaoti">日期<font color='red'>*</font>：</span>
	    	<input type="text" style="margin:0px;vertical-align:baseline;" id="timeC" name="timeC" class="ipt" maxLength="20"  />
	    	<span class="biaoti">备注<font color='red'>*</font>：</span>
	    	<input type='text' id='expressName' name="expressName"  class='ipt changdu1' maxLength='20'/>
	    </p>
    </form>
 </div>
<!--
	作者：1351661878@qq.com
	时间：2017-04-14
	描述：第si个
-->
<div id='expressBoxD' style='display:none'>
    <form id='expressFormD' autocomplete="off">
    <input type="hidden" />
    	<p class="biaoge_p">
	    	单号：1545454545
	    	<span style="float: right;">
	    		最后编辑：sdsdsds
	    	</span>
	    </p>
	    <p class="biaoge_p">
	    	<span class="biaoti">调入仓库<font color='red'>*</font>：</span>
	    	<select name="">
	    		<option value="">2315</option>
	    	</select>
	    	<span class="biaoti">经手人<font color='red'>*</font>：</span>
	    	<select name="">
	    		<option value="">2315</option>
	    	</select>
	    	<span class="biaoti">供应商<font color='red'>*</font>：</span>
	    	<select name="">
	    		<option value="">2315</option>
	    	</select>
	    </p>
	    <p class="biaoge_p">
	    	<span class="biaoti">日期<font color='red'>*</font>：</span>
	    	<input type="text" style="margin:0px;vertical-align:baseline;" id="timeD" name="timeD" class="ipt" maxLength="20"  />
	    	<span class="biaoti">备注<font color='red'>*</font>：</span>
	    	<input type='text' id='expressName' name="expressName"  class='ipt changdu1' maxLength='20'/>
	    </p>
    </form>
 </div>
<!--
	作者：1351661878@qq.com
	时间：2017-04-14
	描述：第wu 个
-->
<div id='expressBoxD' style='display:none'>
    <form id='expressFormD' autocomplete="off">
    <input type="hidden" />
    	<p class="biaoge_p">
	    	单号：1545454545
	    	<span style="float: right;">
	    		最后编辑：sdsdsds
	    	</span>
	    </p>
	    <p class="biaoge_p">
	    	<span class="biaoti">调入仓库<font color='red'>*</font>：</span>
	    	<select name="">
	    		<option value="">2315</option>
	    	</select>
	    	<span class="biaoti">经手人<font color='red'>*</font>：</span>
	    	<select name="">
	    		<option value="">2315</option>
	    	</select>
	    	<span class="biaoti">供应商<font color='red'>*</font>：</span>
	    	<select name="">
	    		<option value="">2315</option>
	    	</select>
	    </p>
	    <p class="biaoge_p">
	    	<span class="biaoti">日期<font color='red'>*</font>：</span>
	    	<input type="text" style="margin:0px;vertical-align:baseline;" id="timeE" name="timeE" class="ipt" maxLength="20"  />
	    	<span class="biaoti">备注<font color='red'>*</font>：</span>
	    	<input type='text' id='expressName' name="expressName"  class='ipt changdu1' maxLength='20'/>
	    </p>
    </form>
 </div>
<!--
	作者：1351661878@qq.com
	时间：2017-04-14
	描述：第六个
-->
<div id='expressBoxD' style='display:none'>
    <form id='expressFormD' autocomplete="off">
    <input type="hidden" />
    	<p class="biaoge_p">
	    	单号：1545454545
	    	<span style="float: right;">
	    		最后编辑：sdsdsds
	    	</span>
	    </p>
	    <p class="biaoge_p">
	    	<span class="biaoti">调入仓库<font color='red'>*</font>：</span>
	    	<select name="">
	    		<option value="">2315</option>
	    	</select>
	    	<span class="biaoti">经手人<font color='red'>*</font>：</span>
	    	<select name="">
	    		<option value="">2315</option>
	    	</select>
	    	<span class="biaoti">供应商<font color='red'>*</font>：</span>
	    	<select name="">
	    		<option value="">2315</option>
	    	</select>
	    </p>
	    <p class="biaoge_p">
	    	<span class="biaoti">日期<font color='red'>*</font>：</span>
	    	<input type="text" style="margin:0px;vertical-align:baseline;" id="timeF" name="timeF" class="ipt" maxLength="20"  />
	    	<span class="biaoti">备注<font color='red'>*</font>：</span>
	    	<input type='text' id='expressName' name="expressName"  class='ipt changdu1' maxLength='20'/>
	    </p>
    </form>
    
 </div>
 <script type="text/javascript">
    $("#store_id").change(function(){
    	var id=$('#store_id').val();
        $.post(WST.U('admin/purchase/get_manager'),{id:id},function(data,textStatus){
        	 var t="<option value='0'>请选择</option>";
   			 if(data!=1){
   			 	for (var i =0 ; i<data.length; i++) {
		             t=t+"<option value='"+data[i].staffId+"'>"+data[i].loginName+"</option>"
		         };
   			 }
		    $("#manager_id").html(t);
   		});
      });


    $("#supplier_id").change(function(){
    	var id=$('#supplier_id').val();
        $.post(WST.U('admin/purchase/get_goods'),{id:id},function(data,textStatus){
        	 console.log(data);
			 var tr="<tr><td><input type='checkbox' id='dsb' style='display:none;'/><label for='dsb'>全选</label></td><td>商品编号</td><td>商品名称</td><td>规格型号</td><td>单位</td><td>库存数量</td><td>调拨数量</td></tr>";
        	 for (var i = data.length - 1; i >= 0; i--) {
        	 	tr=tr+"<tr><td><input class='dsb' type='checkbox' value='" +data[i].id+"'/></td>";
        	 	tr=tr+"<td class='bianhao'>"+data[i].huohao+"</td><td>"+data[i].goodsName+"</td><td>"+data[i].spec+"</td><td>"+data[i].goodsUnit+"</td><td>"+data[i].stock+"</td>";
        	 	tr=tr+"<td><input type='text' class='shuliang' /></td></tr>"
        	 	
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
   		});
      });
 </script>


<script src="__ADMIN__/stock/logmoneys.js?v=<?php echo $v; ?>" type="text/javascript"></script>


<script>
function showImg(opt){
	layer.photos(opt);
}
function showBox(opts){
	return WST.open(opts);
}
</script>
<?php echo hook('initCronHook'); ?>
</body>
</html>