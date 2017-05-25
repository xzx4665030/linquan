<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:68:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\goodsappraises\edit.html";i:1488332792;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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

<script type="text/javascript" src="__STATIC__/plugins/raty/jquery.raty.min.js"></script>
<script>
$(function(){
var options = {
      hints         : ['很不满意', '不满意', '一般', '满意', '非常满意'],
      width:200,
      targetKeep: true,
      starHalf:'__STATIC__/plugins/raty/img/star-half-big.png',
      starOff:'__STATIC__/plugins/raty/img/star-off-big.png',
      starOn:'__STATIC__/plugins/raty/img/star-on-big.png',
      cancelOff: '__STATIC__/plugins/raty/img/cancel-off-big.png',
        cancelOn: '__STATIC__/plugins/raty/img/cancel-on-big.png'
    }
  options.target='#goodsScore_hint';
  options.score='<?php echo $data['goodsScore']; ?>';
  $('.goodsScore').raty(options);

  options.target='#timeScore_hint';
  options.score='<?php echo $data['timeScore']; ?>';
  $('.timeScore').raty(options);

  options.target='#serviceScore_hint';
  options.score='<?php echo $data['serviceScore']; ?>';
  $('.serviceScore').raty(options);

  editInit();
      

});
</script>
<form id="goodsAppraisesForm" autocomplete="off">
<table class='wst-form wst-box-top'>
  <tr>
      <th width='150'>商品：</th>
          <td>
            <img src='__ROOT__/<?php echo str_replace(".","_thumb.",$data["goodsImg"]); ?>' width='50' style="float:left;" />&nbsp;
            <p style="float:left;height:50px;line-height:25px;width:245px;overflow:hidden;margin-left:5px;"><?php echo $data['goodsName']; ?></p>
          </td>
       </tr>
       <tr>
          <th>所属订单：</th>
          <td>
              <?php echo $data['orderNo']; ?>
          </td>
       </tr>
       <tr>
          <th>用户：</th>
          <td>
              <?php echo $data['loginName']; ?>
          </td>
       </tr>
       <tr>
          <th>评价：</th>
          <td>
                <div style='width:500px;'>
                  <div style='float:left;width:70px;'>商品评分：</div>
                  <div style='float:left;width:430px;'>
                    <div class="goodsScore" class="ipt" style='float:left'></div>
                    <div id="goodsScore_hint"  style='float:left'></div>
                  </div>
                </div>
                <div id="score_error"></div>

               <div style='width:500px;'>
                    <div style='float:left;width:70px;'> 时效评分：</div>
                    <div style='float:left;width:430px;'>
                      <div class="timeScore" class="ipt" style='float:left'></div>
                      <div id="timeScore_hint" style='float:left'></div>
                    </div>
               </div>

               <div style='width:500px;'>
                  <div style='float:left;width:70px;'>服务评分：</div>
                  <div style='float:left;width:430px;'>
                      <div class="serviceScore" class="ipt" style='float:left'></div>
                      <div id="serviceScore_hint"  style='float:left'></div>
                  </div>
               </div>
          </td>

       </tr>
       <tr>
          <th>状态：</th>
          <td>
            <label><input type="radio" class="ipt" id="isShow" name="isShow" value="1" <?=$data['isShow']==1?'checked':'';?>  />显示</label>
            <label><input type="radio" class="ipt" id="isShow" name="isShow" value="0" <?=$data['isShow']==0?'checked':'';?>  />隐藏</label>
          </td>
       </tr>
       <tr>
          <th>评语：</th>
          <td>
              <textarea style="width:300px;height:100px" id="content" name="content" class="ipt"><?php echo $data['content']; ?></textarea>
          </td>
       </tr>
       <tr>
          <th>附件：</th>
          <td>
              <div id="appraise-img">
              <?php if(!empty($data['images'])): if(is_array($data['images']) || $data['images'] instanceof \think\Collection): $i = 0; $__LIST__ = $data['images'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?>
                <img src="__ROOT__/<?php echo $img; ?>" layer-src="__ROOT__/<?php echo str_replace('_thumb.','.',$img); ?>" width="50" />
                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
            </div>
          </td>
       </tr>
  
  <tr>
     <td colspan='2' align='center'>

       <input type="hidden" name="id" id="id" class="ipt" value="<?php echo $data['id']+0; ?>" />
       <input type="submit" value="提交" class='btn btn-blue' />
       <input type="button" onclick="javascript:history.go(-1)" class='btn' value="返回" />
     </td>
  </tr>
</table>
</form>
<script>
$(function(){
  parent.showImg({photos: $('#appraise-img')});
});

</script>


<script src="__ADMIN__/goodsappraises/goodsappraises.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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