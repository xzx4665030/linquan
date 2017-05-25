<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:57:"D:\phpStudy\WWW\linquan2\addons\cron\view\admin\edit.html";i:1489042492;s:79:"D:\phpStudy\WWW\linquan2\addons\cron\view\..\..\..\wstmart\admin\view\base.html";i:1490282400;}*/ ?>
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
<form id="editForm">
<table class='wst-form wst-box-top'>
  <tr>
      <th width='150'>计划任务名称：</th>
      <td style='line-height:30px;'>
           <?php echo $data['cronName']; ?>
      </td>
  </tr>
  <tr>
      <th>计划任务描述：</th>
      <td style='line-height:30px;'>
        <?php echo $data['cronDesc']; ?>
      </td>
  </tr>
  <tr>
      <th>定时任务网址：</th>
      <td style='line-height:30px;'>
        <?php echo $data['cronUrl']; ?>
      </td>
  </tr>
 <?php if($data['cronJson']!=''): if(is_array($data['cronJson']) || $data['cronJson'] instanceof \think\Collection): $i = 0; $__LIST__ = $data['cronJson'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vj): $mod = ($i % 2 );++$i;?>
  <tr>
      <th><?php echo $vj['fieldLabel']; ?>：</th>
      <td>
        <input type="text" id="<?php echo $vj['fieldCode']; ?>" class="ipt" style='width:70%;' maxLength="255" value='<?php echo $vj['fieldVal']; ?>' />
      </td>
  </tr>
  <?php endforeach; endif; else: echo "" ;endif; endif; ?>
  <tr>
      <th>计划时间<font color='red'></font>：</th>
      <td>
            <label>
               <input type='radio' name='cronCycle' value='0' id='cronCycle0' class='ipt' onclick='javascript:checkType(0)' <?php if($data['cronCycle']==0): ?>checked<?php endif; ?>/>每月
            </label>
            <label>
               <input type='radio' name='cronCycle' value='1' id='cronCycle1' class='ipt' onclick='javascript:checkType(1)'  <?php if($data['cronCycle']==1): ?>checked<?php endif; ?>/>每周
            </label>
            <label>
               <input type='radio' name='cronCycle' value='2' id='cronCycle2' class='ipt' onclick='javascript:checkType(2)'  <?php if($data['cronCycle']==2): ?>checked<?php endif; ?>/>每日
               
            </label>
    </td>
  </tr>
  <tr class='cycle0 cycle' <?php if($data['cronCycle']!=0): ?>style='display:none'<?php endif; ?>>
    <th>日期<font color='red'></font>：</th>
    <td>
            <select id='cronDay' class='ipt'>
               <?php $__FOR_START_3251__=1;$__FOR_END_3251__=32;for($i=$__FOR_START_3251__;$i < $__FOR_END_3251__;$i+=1){ ?>
               <option value='<?php echo $i; ?>' <?php if($data['cronDay']==$i): ?>selected<?php endif; ?>><?php echo $i; ?>日</option>
               }
               <?php } ?>
            </select>
    </td>
  </tr>
  <tr class='cycle1 cycle' <?php if($data['cronCycle']!=1): ?>style='display:none'<?php endif; ?>>
    <th>星期<font color='red'></font>：</th>
    <td>
            <select id='cronWeek' class='ipt'>
                 <option value='1' <?php if($data['cronWeek']==1): ?>selected<?php endif; ?>>星期一</option>
                 <option value='2' <?php if($data['cronWeek']==2): ?>selected<?php endif; ?>>星期二</option>
                 <option value='3' <?php if($data['cronWeek']==3): ?>selected<?php endif; ?>>星期三</option>
                 <option value='4' <?php if($data['cronWeek']==4): ?>selected<?php endif; ?>>星期四</option>
                 <option value='5' <?php if($data['cronWeek']==5): ?>selected<?php endif; ?>>星期五</option>
                 <option value='6' <?php if($data['cronWeek']==6): ?>selected<?php endif; ?>>星期六</option>
                 <option value='0' <?php if($data['cronWeek']==0): ?>selected<?php endif; ?>>星期日</option>
            </select>
    </td>
  </tr>
  <tr>
    <th>小时<font color='red'></font>：</th>
    <td>
            <select id='cronHour' class='ipt'>
               <option value='-1' <?php if($data['cronHour']==-1): ?>selected<?php endif; ?>>每小时</option>
               <?php $__FOR_START_16815__=0;$__FOR_END_16815__=24;for($i=$__FOR_START_16815__;$i < $__FOR_END_16815__;$i+=1){ ?>
               <option value='<?php echo $i; ?>' <?php if($data['cronHour']==$i): ?>selected<?php endif; ?>><?php echo $i; ?>时</option>
               }
               <?php } ?>
            </select>
    </td>
  </tr>
  <tr>
    <th>分钟<font color='red'></font>：</th>
    <td>
            <input type="text" id="cronMinute" class="ipt" style='width:70%' maxLength="255" value='<?php echo $data['cronMinute']; ?>' />(如多个分钟则以,分隔，-1表示每分钟)
    </td>
  </tr>
  <tr>
    <th>计划任务状态<font color='red'></font>：</th>
    <td>
            <label>
              <input type='radio' name='isEnable' class='ipt' value='1' <?php if($data['isEnable']==1): ?>checked<?php endif; ?>/>启用
            </label>
            <label>
              <input type='radio' name='isEnable' class='ipt' value='0' <?php if($data['isEnable']==0): ?>checked<?php endif; ?>/>停用
            </label>
    </td>
  </tr>
  <tr>
      <td colspan='2' align='center'>
            <input type="button" value="提交" class='btn btn-blue' onclick='javascript:edit(<?php echo $data['id']+0; ?>)' style='margin-right:15px;'/>
            <input type="button" onclick="javascript:history.go(-1)" class='btn' value="返回" />
      </td>
  </tr>
</table>
</form>


<script src="__ROOT__/addons/cron/view/admin/crons.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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