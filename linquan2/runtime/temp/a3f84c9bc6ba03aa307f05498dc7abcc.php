<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:63:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\userranks\edit.html";i:1488332792;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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

<link rel="stylesheet" type="text/css" href="__STATIC__/plugins/webuploader/webuploader.css?v=<?php echo $v; ?>" />

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
<form id="userRankForm" autocomplete="off">
<table class='wst-form wst-box-top'>
      <tr>
      <th width='150'>会员等级名称<font color='red'>*</font>：</th>
          <td>
            <input type="text" class="ipt" id="rankName" name="rankName" value="<?php echo $data['rankName']; ?>" />
          </td>
       </tr>
       <tr>
          <th width='100'>会员等级图标：</th>
          <td><div id='userranksPicker'>上传图标</div><span id='uploadMsg'></span></td>
       </tr>
       <tr>
          <th width='100'>预览图：</th>
          <td>
            <div style="min-height:30px;" id="preview">
              <?php if((isset($data['userrankImg']))): ?>
                <img src="__ROOT__/<?php echo $data['userrankImg']; ?>" height="25" />
              <?php endif; ?>
            </div>
            <input type="hidden" name="userrankImg" id="userrankImg" value="<?php echo $data['userrankImg']; ?>" class="ipt" />

          </td>
       </tr>

       <tr>
          <th>积分下限(大于或等于)<font color='red'>*</font>：</th>
          <td>
              <input type="text" class="ipt" id="startScore" name="startScore" value="<?php echo $data['startScore']; ?>" />
          </td>
       </tr>
       <tr>
          <th>积分上限(小于)<font color='red'>*</font>：</th>
          <td>
              <input type="text" class="ipt" id="endScore" name="endScore" value="<?php echo $data['endScore']; ?>" />
          </td>
       </tr>
       <tr>
          <th>折扣率<font color='red'>*</font>：</th>
          <td><input type="text" class="ipt" id="rebate" name="rebate" value="<?php echo $data['rebate']; ?>" maxLength="3" /></td>
       </tr>
  
  <tr>
     <td colspan='2' align='center'>
       <input type="hidden" name="id" id="rankId" class="ipt" value="<?php echo $data['rankId']+0; ?>" />
       <input type="submit" value="提交" class='btn btn-blue' />
       <input type="button" onclick="javascript:history.go(-1)" class='btn' value="返回" />
     </td>
  </tr>
</table>
</form>
<script>
$(function(){editInit()});
</script>



<script type='text/javascript' src='__STATIC__/plugins/webuploader/webuploader.js?v=<?php echo $v; ?>'></script>
<script src="__ADMIN__/userranks/userranks.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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