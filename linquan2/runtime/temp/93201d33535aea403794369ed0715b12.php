<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\orderrefunds\box_refund.html";i:1488332790;}*/ ?>
<?php if(!empty($object)): ?>
<form id='editFrom'>
<table class='wst-form'>
   <tr>
    <td colspan='2' class='head-ititle'>订单信息</td>
  </tr>
   <tr>
      <th width='100'>订单编号：</th>
      <td><?php echo $object['orderNo']; ?></td>
   </tr>
   <?php if($object['payFrom']!=''): ?>
   <tr>
      <th>支付方式：</th>
      <td>【<?php echo WSTLangPayFrom($object['payFrom']); ?>】<?php echo $object['tradeNo']; ?></td>
  </tr>
  <?php endif; ?>
  <tr>
     <th>订单总金额：</th>
     <td>¥<?php echo $object['totalMoney']; ?>&nbsp;&nbsp;&nbsp;&nbsp;【商品总金额：¥<?php echo $object['goodsMoney']; ?>&nbsp;&nbsp;&nbsp;&nbsp;运费：¥<?php echo $object['deliverMoney']; ?>】</td>
  </tr>
  <tr>
     <th>实收总金额：</th>
     <td>¥<?php echo $object['realTotalMoney']; ?></td>
  </tr>
  <tr>
    <td colspan='2' class='head-ititle'>退款信息</td>
  </tr>
  <tr>
     <th>退款原因：</th>
     <td>
     <?php 
     $rs = WSTDatas(4,$object['refundReson']);
     echo $rs['dataName'].(($object['refundOtherReson']!='')?"：".$object['refundOtherReson']:"");
      ?></td>
  </tr>
  <tr>
     <th>申请退款：</th>
     <td>¥<?php echo $object['backMoney']; ?></td>
  </tr>
  <tr>
     <th>申请退回积分：</th>
     <td>¥<?php echo $object['useScore']; ?>（积分抵扣¥<?php echo $object['scoreMoney']; ?>）</td>
  </tr>
  <tr>
     <th>操作备注：</th>
     <td>
       <textarea id='content' style='width:90%;height:60px;' placeholder='操作备注，用户可见' maxLength='200'></textarea>
     </td>
  </tr>
  <tr>
     <td colspan='2' style='text-align:center;padding-top:30px;'>
        <input type='button' value='确&nbsp;&nbsp;定' class='btn btn-blue' onclick="javascript:orderRefund(<?php echo $object['refundId']; ?>)"">&nbsp;&nbsp;&nbsp;&nbsp;
        <input type='button' value='取&nbsp;&nbsp;消' class='btn' onclick='javascript:layer.close(w)'>
     </td>
  </tr>
</table>
</form>
<?php else: ?>
<div style='color:red;margin:20px;'>
该订单不存在或已退款。
</div>
<?php endif; ?>
