<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\shops\cashdraws\box_draw.html";i:1488332796;}*/ ?>
  <form id='drawForm' autocomplete='off' >
    <table width='100%' style='margin-top:10px;' class='wst-form' style='dislay:none'>
      <tr>
        <th width='120' align='right'>提现账号：</th>
          <td style='line-height:25px;'>
              【<?php echo $object['bankName']; ?>】<?php echo $object['bankNo']; ?>
          </td>
        </tr>
        <tr>
          <th width='120' align='right'>账号持有人：</th>
          <td><?php echo $object['bankUserName']; ?></td>
        </tr>
        <tr> 
          <th align='right'>提现金额<font color='red'>*</font>：</th>
          <td>
            <input type='text' id='money' class='j-ipt' style='width:250px' data-rule="提现金额: required;" onkeypress="return WST.isNumberdoteKey(event)" onblur="javascript:WST.limitDecimal(this,2)" onkeyup="javascript:WST.isChinese(this,1)"/>
          </td>
        </tr>
        <tr height='40'>
            <th align='right'>支付密码<font color='red'>*</font>：</th>
            <td><input type='password' id='payPwd' class='j-ipt' style='width:250px' data-rule="支付密码: required;"/></td>
        </tr>
        <tr>
              <td colspan='2' style='text-align: center;padding-top:5px;'>
                  <a class='s-btn' onclick="drawMoney()">保存</a>
                  <a class='s-btn2' style='margin-left:10px;' onclick='layerclose()'>取消</a>
              </td>
           </tr>
        </table>
        </form>
