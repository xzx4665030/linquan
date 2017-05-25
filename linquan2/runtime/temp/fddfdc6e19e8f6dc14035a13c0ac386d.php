<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"D:\phpStudy\WWW\linquan2/wstmart/home\view\default\users\cashdraws\box_config.html";i:1488332794;}*/ ?>
  <form id='configForm' autocomplete='off'>
    <input type='hidden' id='id' class='j-ipt' value='<?php echo $object["id"]; ?>'/>
    <table width='100%' style='margin-top:10px;' class='wst-form'>
      <tr>
        <th width='120' align='right'>开卡银行<font color='red'>*</font>：</th>
          <td>
              <select id='accTargetId' class='j-ipt' data-rule="开卡银行: required;">
                <option value=''>请选择</option>
                <?php if(is_array($banks) || $banks instanceof \think\Collection): $i = 0; $__LIST__ = $banks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value='<?php echo $vo["bankId"]; ?>' <?php if($object['accTargetId'] == $vo['bankId']): ?>selected<?php endif; ?>><?php echo $vo["bankName"]; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
          </td>
        </tr>
        <tr> 
          <th align='right'>开卡地区<font color='red'>*</font>：</th>
          <td>
            <select id="area_0" class='j-areas' level="0" onchange="WST.ITAreas({id:'area_0',val:this.value,isRequire:true,className:'j-areas'});" data-rule="开卡地区: required;">
            <option value="">-请选择-</option>
            <?php foreach($areas as $v): ?>
              <option value="<?php echo $v['areaId']; ?>"><?php echo $v['areaName']; ?></option>
            <?php endforeach; ?>
          </select>
          </td>
        </tr>
        <tr height='40'> 
            <th align='right'>卡号<font color='red'>*</font>：</th>
            <td><input type='text' id='accNo' class='j-ipt' value='<?php echo $object["accNo"]; ?>' style='width:250px' data-rule="卡号: required;"/></td>
        </tr>
        <tr> 
            <th align='right'>持卡人<font color='red'>*</font>：</th>
            <td><input type='text' id='accUser' class='j-ipt' value='<?php echo $object["accUser"]; ?>' style='width:250px' data-rule="持卡人: required;"/></td>
        </tr>
        <tr> 
              <td colspan='2' style='text-align: center;padding-top:5px;'>
                  <button type='button' class='wst-sec-but u-btn' onclick="editConfig()">保存</button>
                  <button type='button' style='margin-left:10px;' class='wst-user-buta2 u-btn' onclick='layerclose()'>取消</button>
              </td>
           </tr>
        </table>
        </form>
<script>
$(function(){
    var bankAreaIdPath = '<?php echo $object["accAreaIdPath"]; ?>';
    if(bankAreaIdPath!=''){
        var areaIdPath = bankAreaIdPath.split("_");
        $('#area_0').val(areaIdPath[0]);
        var aopts = {id:'area_0',val:areaIdPath[0],childIds:areaIdPath,className:'j-areas',isRequire:true}
        WST.ITSetAreas(aopts);
    }
})
</script>