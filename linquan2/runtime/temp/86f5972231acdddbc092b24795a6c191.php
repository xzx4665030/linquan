<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\configure\box.html";i:1493956786;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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
	#uesrTable {
		width: 100%;
		text-align: center;
	}
	
	#uesrTable tr {
		background-color: #f5f5f5;
	}
	
	#uesrTable tr:nth-child(2n) {
		background-color: #f0f0f0;
	}
	
	#uesrTable tr:hover {
		background-color: #e0ecff;
	}
#tianjia{
	display: inline-block;
    background: #3521fc;
    padding: 7px 16px;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    margin: 10px;
    color: #f0d0d0;
	}
	
#uesrTable tr {
    background-color: #f5f5f5;
    height: 36px;
    line-height: 36px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}
#uesrTable td {
    border-right: 1px solid #ccc;
    box-sizing: border-box;
}
#goods_id{display: none;}
#jiaru{background: #fff;border-radius: 6px;width: 600px;left: 50%;margin-left: -300px;top: 150px;padding: 30px 0px;border: 1px solid #ccc;}
#jiaru p{height: 30px;line-height: 30px;margin: 8px 0px;width: 299px;display: inline-block;}
#jiaru .ca{display: inline-block;width: 80px;text-align: right;margin-right: 5px;}
#jiaru p i{display: none;}
#jiaru .bjh{text-align: center;width: 100%;margin-top: 20px;}
#jiaru .bjh a{padding: 4px 13px;margin: 0px 5px;border-radius:3px ;cursor:pointer;}
#jiaru .bjh .qd_x{background-color: #2e8ded;color: #fff;}
#jiaru .bjh .qx_x{background-color: #f1f1f1;color: #000;}
</style>
<span id="tianjia" style="background-color: #356ad3;color: #fff;">添加</span>
<span style="cursor:pointer;float: right;margin-right: 20px;padding: 7px 16px;border-radius: 3px;margin: 10px;color: #000;background: #fff;border: 1px solid #ddd;" onclick="javascript:history.go(-1);">返回</span>
<div id="jiaru" style="display:none;position:absolute;">
	<form></form>
</div>
<form id="userForm" autocomplete="off">
	<table id="uesrTable">
	
	</table>

</form>
<span id="goods_id"><?php echo $id; ?></span>
<script>
	var ss;
	var kk = "";
	var goods_id;
	$(function() {

		goods_id = $("#goods_id").text();

		data = {
			'goods_id': goods_id
		};
		$.ajax({
			url: WST.U('admin/Supplier/get_spec_cats'),
			data: data,
			type: 'post',
			dataType: 'json',
			success: function(data) {
				var len = data.spec_list.length;
				ss = len;

				for(var i = 0; i < len; i++) {
					//tr=tr+"<td>"+data.spec_list[i].catName+"</td>";
					kk = kk + "<p><span class='ca'>" + data.spec_list[i].catName + "</span><i>" + data.spec_list[i].catId + "</i><input  type='text'/></p>";
				}
				var tr = "<tr><td>序号</td><td>规格</td><td style='display:none;'>货号</td><td>市场价</td><td>本店价</td><td>库存</td><td>库存预警</td><td>操作</td></tr>";
				kk = kk + "<p style='display:none;'><span class='ca'>货号</span><input type='text'/></p><p><span class='ca'>市场价</span><input type='text'/></p><p><span class='ca'>本店价</span><input type='text'/></p><p><span class='ca'>库存</span><input type='text'/></p><p><span class='ca'>库存预警</span><input type='text'/></p><p class='bjh'><a class='qd_x'>确定</a><a class='qx_x'>取消</a></p>"

				for(var j = 0; j < data.goods_list.length; j++) {
					tr = tr + '<tr><td>' + (j + 1) + '</td><td>' + data.goods_list[j].spec_value + '</td><td>' + data.goods_list[j].marketPrice + '</td><td>' + data.goods_list[j].specPrice + '</td><td>';
					tr = tr + data.goods_list[j].stock + '</td><td>' + data.goods_list[j].warning + '</td><td><a style="margin-right:10px" href="javascript:xiuG(' + data.goods_list[j].s_id + ')">修改</a>';
					tr = tr + '<a href="javascript:shanC(' + data.goods_list[j].s_id + ')">删除</a></td></tr>'
				}
				$("#uesrTable").html(tr);
			}
		})
		$("#tianjia").click(function() {
			xiuG(0);
		})

	})

	function xiuG(id) {

		$("#jiaru form").html(kk);

		if(id > 0) {
			var data1 = {
				'id': id
			};
			$.ajax({
				type: 'post',
				data: data1,
				url: WST.U('admin/Supplier/edit_spec_cats'),
				dataType: 'json',
				success: function(json) {
					arr = json.spec_value.split(",");
					var sss = arr.length - 1;
					for(var m = 0; m < sss; m++) {
						$("#jiaru form input").eq(m).val(arr[m]);
					}
					$("#jiaru form input").eq(sss).val(json.s_huohao);
					$("#jiaru form input").eq((sss + 1)).val(json.marketPrice);
					$("#jiaru form input").eq((sss + 2)).val(json.specPrice);
					$("#jiaru form input").eq((sss + 3)).val(json.stock);
					$("#jiaru form input").eq((sss + 4)).val(json.warning);

				}
			})
		}
		$("#jiaru").show();
		$("#jiaru form .qd_x").click(function() {
			var dat1 = "";
			var dat2 = "";
			for(var k = 0; k < ss; k++) {
				dat1 = dat1 + $("#jiaru form i").eq(k).text() + ",";
				dat2 = dat2 + $("#jiaru form input").eq(k).val() + ",";
			}
			var dat3 = $("#jiaru form input").eq(ss).val();

			var dat4 = $("#jiaru form input").eq((ss + 1)).val();
			var dat5 = $("#jiaru form input").eq((ss + 2)).val();
			var dat6 = $("#jiaru form input").eq((ss + 3)).val();
			var dat7 = $("#jiaru form input").eq((ss + 4)).val();
			var datas = {
				'spec_id': dat1,
				'spec_value': dat2,
				'marketPrice': dat4,
				'shopPrice': dat5,
				'goodsStock': dat6,
				'alarm': dat7,
				'goods_id': goods_id,
				'id': id
			};

			$.ajax({
				url: WST.U('admin/Supplier/add_spec_cats'),
				data: datas,
				type: 'post',
				dataType: 'json',
				success: function(e) {
					if(e.status == 1) {
						alert(e.msg);
						window.location.reload();
					} else {
						alert(e.msg);
					}
				}
			})
		})
		$("#jiaru form .qx_x").click(function(){
			$("#jiaru form").html("");
			$("#jiaru").hide();
		})
	}

	function shanC(id) {
		$.ajax({
			url: WST.U('admin/Supplier/del_spec_cats'),
			data: {
				'id': id
			},
			type: 'post',
			dataType: 'json',
			success: function(e) {
				if(e.status == 1) {
					alert(e.msg);
					window.location.reload();
				} else {
					alert(e.msg);
				}
			}
		})

	}
</script>

 
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