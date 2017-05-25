<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:63:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\cashdraws\edit.html";i:1488332790;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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
<form autocomplete='off'>
    <input type='hidden' id='cashId' class='ipt' value="<?php echo $object['cashId']; ?>"/>
    <table class='wst-form wst-box-top'>
        <tr>
           <th width='150'>会员类型：</th>
           <td>
           <?php if($object['targetType']==1): ?>商家<?php else: ?>普通会员<?php endif; ?>
           </td>
        </tr>
        <tr>
           <th width='150'>提现单号：</th>
           <td>
           <?php echo $object['cashNo']; ?>
           </td>
        </tr>
        <tr>
           <th>提现金额：</th>
           <td>¥<?php echo $object['money']; ?></td>
        </tr>
        <tr>
           <th>提现银行：</th>
           <td><?php echo $object['accTargetName']; ?></td>
        </tr>
        <tr>
           <th>开卡地区：</th>
           <td>
             <?php echo $object['accAreaName']; ?>
           </td>
        </tr>
        <tr>
           <th>卡号：</th>
           <td>
             <?php echo $object['accNo']; ?>
           </td>
        </tr>
        <tr>
           <th>持卡人：</th>
           <td>
             <?php echo $object['accUser']; ?>
           </td>
        </tr>
        <tr>
           <th>申请时间：</th>
           <td><?php echo $object['createTime']; ?></td>
        </tr>
        <tr >
           <th valign='top'>提现备注：<br/>(用户可见)&nbsp;&nbsp;</th>
           <td>
             <textarea id='cashRemarks' class='ipt' style='width:70%;height:80px;'></textarea>
           </td>
        </tr>
        <tr>
           <td colspan='2' align='center'>
             <input type='button' value='提交' class='btn btn-blue' onclick='javascript:save()'>
             <input type='button' value='返回' class='btn' onclick='javascript:history.go(-1)'>
           </td>
        </tr>
    </table>
</form>


<script src="__ADMIN__/cashdraws/cashdraws.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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