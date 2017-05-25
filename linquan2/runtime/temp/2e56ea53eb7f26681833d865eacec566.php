<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\users\cashdraws\box_draw.html";i:1488332794;}*/ ?>
  <form id='drawForm' autocomplete='off' >
    <table width='100%' style='margin-top:10px;' class='wst-form' style='dislay:none'>
      <tr>
        <th width='120' align='right'>提现账号<font color='red'>*</font>：</th>
          <td>
              <select id='accId' class='j-ipt' data-rule="开卡银行: required;">
                <option value=''>请选择</option>
                <?php if(is_array($accs) || $accs instanceof \think\Collection): $i = 0; $__LIST__ = $accs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value='<?php echo $vo["id"]; ?>'><?php echo $vo["accUser"]; ?>|<?php echo $vo["accNo"]; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
          </td>
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
                  <button type='button' class='wst-sec-but u-btn' onclick="drawMoney()">保存</button>
                  <button type='button' style='margin-left:10px;' class='wst-user-buta2 u-btn' onclick='layerclose()'>取消</button>
              </td>
           </tr>
        </table>
        </form>
