<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"D:\phpStudy\WWW\linquan2\addons\distribut\view\admin/user_list.html";i:1490320120;s:84:"D:\phpStudy\WWW\linquan2\addons\distribut\view\..\..\..\wstmart\admin\view\base.html";i:1490282400;}*/ ?>
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

<div class="l-loading" style="display: block" id="wst-loading"></div>
<div class="wst-toolbar">
	
   <div id="query" style="float:left;">
	   		会员账号:<input type="text" name="loginName"  placeholder='账号' id="loginName" class="query" />
	   		手机号码:<input type="text" name="loginPhone" placeholder='手机号码' id="loginPhone" class="query" />
	   		电子邮箱:<input type="text" name="loginEmail" placeholder='电子邮箱' id="loginEmail" class="query" />
	   		<input type="button" class="btn btn-blue" onclick="javascript:userQuery()" value="查询">
	</div>

   <div style="clear:both"></div>
</div>
<div id="maingrid"></div>
<script>
  $(function(){initGrid()});
  var grid;
  function initGrid(){
  	grid = $("#maingrid").ligerGrid({
  		url:"<?php echo addon_url('distribut://distribut/queryAdminDistributUsers'); ?>",
  		pageSize:WST.pageSize,
  		pageSizeOptions:WST.pageSizeOptions,
  		height:'99%',
          width:'100%',
          minColToggle:6,
          rownumbers:true,
          columns: [
  	        { display: '账号', name: 'loginName', isSort: false},
  	        { display: '用户名', name: 'userName', isSort: false},
  	        { display: '手机号码', name: 'userPhone', isSort: false},
  	        { display: '电子邮箱', name: 'userEmail', isSort: false},
  	        { display: '积分', name: 'userScore', isSort: false},
  	        { display: '注册时间', name: 'createTime', isSort: false},
  	        { display: '状态', name: 'userStatus', isSort: false, render:function(rowdata, rowindex, value){
  	        	return (value==1)?'启用':'停用';
  	        }},
  	        { display: '总佣金', name: 'distributMoney', isSort: false},
  	        { display: '推广用户数', name: 'userCnt', isSort: false},
  	        { display: '操作', name: 'op',isSort: false,render: function (rowdata, rowindex, value){
  	            var h = "<a href='"+WST.U('addon/distribut-distribut-admindistributchildusers',{'userId':rowdata['parentId']})+"'>查看</a> ";
  	            return h;
  	        }}
          ]
      });

  }
  function userQuery(){
		var query = WST.getParams('.query');
		grid.set('url',WST.U('addon/distribut-distribut-queryadmindistributusers',query));
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