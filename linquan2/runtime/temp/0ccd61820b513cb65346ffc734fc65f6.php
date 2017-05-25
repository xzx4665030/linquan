<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:65:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\settlements\view.html";i:1488332784;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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
<div id="wst-tabs" style="width:100%; height:99%;overflow: hidden; border: 1px solid #D3D3d3;" class="liger-tab">

   <div id="wst-tab-1" tabId="wst-tab-1"  title="结算详情" class='wst-tab'  style="height: 99%"> 
      <form autocomplete='off'>
      <input type='hidden' id='settlementId' class='ipt' value="<?php echo $object['settlementId']; ?>"/>
      <table class='wst-form wst-box-top'>
        <tr>
           <td colspan='2' class='head-ititle'>结算信息</td>
        </tr>
        <tr>
           <th>店铺：</th>
           <td><?php echo $object['shopName']; ?></td>
        </tr>
        <tr>
           <th width='150'>申请单号：</th>
           <td>
           <?php echo $object['settlementNo']; ?>
           </td>
        </tr>
        <tr>
           <th>结算金额：</th>
           <td>¥<?php echo $object['settlementMoney']; ?></td>
        </tr>
        <tr>
           <th>结算佣金：</th>
           <td>¥<?php echo $object['commissionFee']; ?></td>
        </tr>
        <tr>
           <th>返还金额：</th>
           <td>¥<?php echo $object['backMoney']; ?></td>
        </tr>
        <tr>
           <th>申请时间：</th>
           <td><?php echo $object['createTime']; ?></td>
        </tr>
        <tr>
           <td align='center' colspan='2'>
             <table class='l-grid-header-table wst-grid-tree' width="100%" cellspacing="0" cellpadding="0" style='border:1px solid #ddd'>
                <tr class='l-grid-hd-row wst-grid-tree-hd' height='28' >
                  <td class='l-grid-hd-cell l-grid-hd-cell-rownumbers' style='width:35px'>序号</th>
                  <td class='l-grid-hd-cell'>订单号</td>
                  <td class='l-grid-hd-cell'>支付方式</td>
                  <td class='l-grid-hd-cell'>商品金额</td>
                  <td class='l-grid-hd-cell'>运费</td>
                  <td class='l-grid-hd-cell'>订单总金额</td>
                  <td class='l-grid-hd-cell'>积分抵扣</td>
                  <td class='l-grid-hd-cell'>实付金额</td>
                  <td class='l-grid-hd-cell'>佣金</td>
                  <td class='l-grid-hd-cell'>下单时间</td>
                </tr>
                <?php if(is_array($object["list"]) || $object["list"] instanceof \think\Collection): $i = 0; $__LIST__ = $object["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr class='l-grid-row wst-grid-tree-row' height='28' <?php if($vo['payType']==0): ?>style='background:#eeeeee;'<?php endif; ?>>
                   <td class='l-grid-row-cell l-grid-row-cell-rownumbers'><?php echo $key+1; ?></td>
                   <td class='l-grid-row-cell'><?php echo $vo['orderNo']; ?></td>
                   <td class='l-grid-row-cell'><?php echo WSTLangPayType($vo['payType']); ?></td>
                   <td class='l-grid-row-cell'>¥<?php echo $vo['goodsMoney']; ?></td>
                   <td class='l-grid-row-cell'>¥<?php echo $vo['deliverMoney']; ?></td>
                   <td class='l-grid-row-cell'>¥<?php echo $vo['totalMoney']; ?></td>
                   <td class='l-grid-row-cell'>¥<?php echo $vo['scoreMoney']; ?></td>
                   <td class='l-grid-row-cell'>¥<?php echo $vo['realTotalMoney']; ?></td>
                   <td class='l-grid-row-cell' style='background:#ffffff;'>¥<?php echo $vo['commissionFee']; ?></td>
                   <td class='l-grid-row-cell'><?php echo $vo['createTime']; ?></td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
             </table>
           </td>
        </tr>
        <tr >
           <th valign='top'>结算备注：<br/>(店铺可见)&nbsp;&nbsp;</th>
           <td><?php echo $object['remarks']; ?></td>
        </tr>
        <tr>
           <td colspan='2' align='center'>
             <input type='button' value='返回' class='btn' onclick='javascript:history.go(-1)'>
           </td>
        </tr>
      </table>
      </form>
  </div>
  <div id="wst-tab-2" tabId="wst-tab-2"  title="结算商品列表" class='wst-tab'  style="height: 99%">
   <div id="maingrid"></div>
  </div>
</div>
<script>
$(function(){
   intView('<?php echo $object["settlementId"]; ?>');
})
</script>


<script src="__ADMIN__/settlements/shopsettlements.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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