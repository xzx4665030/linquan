<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\users\orders\box_reject.html";i:1488332794;}*/ ?>
<table class='wst-form' style='margin-top:10px;width:90%'>
   <tr>
     <td colspan='2' style='padding-left:70px;'>请选择您拒收订单的原因，以便我们能更好的为您服务。</td>
   </tr>
   <tr>
     <th width='120'>取消原因：</th>
     <td>
        <select id='reason' onchange='javascript:changeRejectType(this.value)'>
           <?php $_result=WSTDatas(2);if(is_array($_result) || $_result instanceof \think\Collection): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
           <option value='<?php echo $vo["dataVal"]; ?>'><?php echo $vo["dataName"]; ?></option>
           <?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
     </td>
   </tr>
   <tr id='rejectTr' style='display:none'>
     <th width='120'>原因<font color='red'>*</font>：</th>
     <td>
       <textarea id='content' style='width:99%;height:80px;' maxLength='200'></textarea>
     </td>
   </tr>
</table>