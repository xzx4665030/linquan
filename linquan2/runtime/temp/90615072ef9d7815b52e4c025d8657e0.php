<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\shops\orders\box_refund.html";i:1488332796;}*/ ?>
<table class='wst-form' style='margin-top:10px;width:90%'>
   <tr>
     <th width='120'>订单号：</th>
     <td><?php echo $object['orderNo']; ?></td>
   </tr>
   <tr>
     <th width='120'>实付金额：</th>
     <td>¥<?php echo $object['realTotalMoney']; ?></td>
   </tr>
   <tr>
     <th width='120'>退款金额：</th>
     <td style='color:red'>¥<?php echo $object['backMoney']; ?></td>
   </tr>
   <tr>
     <th width='120'>退款积分：</th>
     <td style='color:red'><?php echo $object['useScore']; ?>个（积分抵扣¥<?php echo $object['scoreMoney']; ?>）</td>
   </tr>
   <tr>
     <th width='120'>商家意见：</th>
     <td>
       <label><input type='radio' onclick='WST.showHide(0,"#tr")' name='refundStatus' id='refundStatus1' value='1' checked/>同意</label>
       <label style='margin-left:15px;'><input type='radio' onclick='WST.showHide(1,"#tr")' name='refundStatus' id='refundStatus0' value='-1'/>不同意</label>
     </td>
   </tr>
   <tr id='tr' style='display:none'>
     <th width='120'>原因<font color='red'>*</font>：</th>
     <td>
       <textarea id='shopRejectReason' style='width:90%;height:50px;'></textarea>
     </td>
   </tr>
</table>