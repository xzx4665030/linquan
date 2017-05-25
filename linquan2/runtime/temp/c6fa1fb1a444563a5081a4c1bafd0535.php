<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:58:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\navs\edit.html";i:1488332792;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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
<form id="navForm">
<table class='wst-form wst-box-top'>
       <tr>
          <th width='120'>导航位置<font color='red'>  </font>：</th>
          <td>
            <select id="navType" class='ipt' maxLength='20'>
              <option value="0">顶部</option>
              <option value="1">底部</option>
            </select>
          </td>
       </tr>
       <tr>
          <th>导航名称<font color='red'>*</font>：</th>
          <td>
              <input type="text" id="navTitle" name="navTitle" class="ipt" maxLength='50' style='width:300px;'/>
          </td>
       </tr>
       <tr>
          <th>链接来自<font color='red'>*</font>：</th>
          <td>
            <select id="linkfrom" onchange="changeFlink(this);">
                <option value="1">外部链接</option>
                <option value="2">系统文章</option>
            </select>
          </td>
       </tr>
       <tr>
          <th>导航链接<font color='red'>*</font>：</th>
          <td>
              <select id="articles" style="display:none;" onchange="changeArticles(this)">
                <volist name="articles" id="vo" key="kv"> 
                  <option value="0">-请选择-</option>
                  <option value="1">-请选择1-</option>
                  <option value="2">-请选择2-</option>
                </volist>
              </select>
            <input type='text' id='navUrl' name="navUrl"  class='ipt' style='width:500px;'/>
          </td>
       </tr>
       <tr>
          <th>是否显示<font color='red'>  </font>：</th>
          <td>
            <lable>
              <input type="radio" name="isShow" value="1" id="isShow" class="ipt" <?=($data['isShow']!==0)?'checked="checked"':'';?> />显示
            </lable>
            <lable>
              <input type="radio" name="isShow" value="0" id="isShow" class="ipt" <?=($data['isShow']===0)?'checked="checked"':'';?> />隐藏
            </lable>
          </td>
       </tr>
       <tr>
          <th>打开方式<font color='red'>*</font>：</th>
          <td>

            <lable>
              <input type="radio" name="isOpen" value="1" id="isOpen" class="ipt" <?=($data['isOpen']!==0)?'checked="checked"':'';?> />新窗口打开
            </lable>
            <lable>
              <input type="radio" name="isOpen" value="0" id="isOpen" class="ipt" <?=($data['isOpen']===0)?'checked="checked"':'';?> />页面跳转
            </lable>
          </td>
       </tr>
       <tr>
          <th>导航排序号<font color='red'>*</font>：</th>
          <td>
            <input type="text" id="navSort" class="ipt" maxLength="20"  />
          </td>
       </tr>
       
    <tr>
     <td colspan='2' align='center'>
       <input type="hidden" id="id" value="<?php echo $data['id']+0; ?>" />
       <input type="submit" value="提交" class='btn btn-blue'/>
       <input type="button" onclick="javascript:history.go(-1)" class='btn' value="返回" />
     </td>
  </tr>
</table>
</form>


<script>
$(function(){
    WST.setValues(<?=json_encode($data)?>);
});
</script>


<script src="__ADMIN__/navs/navs.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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