<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:63:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\configure\list.html";i:1495608189;s:53:"D:\phpStudy\WWW\linquan2/wstmart/admin\view\base.html";i:1490867328;}*/ ?>
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

<style>
	
</style>

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

<style type="text/css">
	body {
		overflow: hidden
	}
	.wst-toolbar{
		border-top: 1px solid #f4f4f4;
	}
	.quanxuan label{display:block;width: 100%;height: 100%;background: #88b547;color: #fff;cursor: pointer;}
	#wst-tabs .l-tab-links,.wst-toolbar{
		background-color: #fff;
		margin-top: 0px;
		text-indent: 6px;
	}
	#wst-tabs .l-tab-links ul{
		margin-top: 12px;
	}
	#wst-tabs .l-tab-links{
		height: 50px ;
	}
	.layui-layer{ border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;overflow: hidden;}
	select,option{height: 38px;line-height: 38px;width: 80px;}
	input[type="text"]{padding: 0px;height: 28px;}
	td{line-height: 28px}
	input[type="checkbox"]{vertical-align: top;}
	.bianji,.kucun,.shanchux{color: #069add;margin:0px 10px;cursor:pointer;}
	.biaoge_p{margin: 0px ;padding: 0px;line-height: 28px;margin:auto;margin-top: 8px;width: 385px;display: block;}
	.biaoge_p1{margin: 0px ;padding: 0px;line-height: 28px;margin:auto;margin-top: 8px;width: 660px;display: block;}
	.biaoge_p .biaoti{display: inline-block;width: 75px;text-align: right;vertical-align: top;}
	.biaoge_p .changdu1{width: 120px;}
	.biaoge_p .changdu2{width: 200px;}
	.biaoge_p1 .changdu2{width: 200px;margin-right: 30px;}
	.biaoge_p .changdu3{width: 290px;}
	.biaoge_p .changdu4{width:370px;display: inline-block;}
	.layui-layer-btn {padding-right: 26px;}
	.l-text-wrapper{display: inline-block;}
	.biaoge_p select,.biaoge_p option{height: 28px;line-height: 28px;}
</style>
<!--<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>-->
<div class="l-loading" style='display:block' id="wst-loading"></div>
<div id="wst-tabs" style="width:100%; height:100%;overflow: hidden; border: 1px solid #D3D3d3;" class="liger-tab">
	<!--
    	作者：1351661878@qq.com
    	时间：2017-04-13
    	描述：第一个页面
    -->
	<div id="users" tabId="users" title="网店管理" class='wst-tab' style="height: 99%">
		<div class="wst-toolbar">
			<button class="tianjia" onclick="javascript:toEditA(0,0)">添加</button>
			<button class="shanchu" onclick="javascript:toBatchDelA(0,0)" >删除</button>
			<!--账号：<input type='text' id='key1' placeholder='账号' />
			<button class="btn btn-blue" onclick="javascript:loadUserGrid(0)">查询</button>-->
		</div>
		<div id='userGrid'></div>
	</div>
	<!--
    	作者：1351661878@qq.com
    	时间：2017-04-13
    	描述：第二个页面
    -->
	<div id="shops" tabId="shops" title="总仓库管理" class='wst-tab' style="height: 99%">
		<div class="wst-toolbar">
			<button class="tianjia" onclick="javascript:toEditB(0,0)">添加</button>
			<button class="shanchu" onclick="javascript:toBatchDelB(0,0)" >删除</button>
			<select name="s2_type" id='s2_type' class="s2_ipt" >
				<option value="">仓库组</option>
				<?php if(is_array($stock_list) || $stock_list instanceof \think\Collection): $i = 0; $__LIST__ = $stock_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s_li): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $s_li['roleId']; ?>"><?php echo $s_li['roleName']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			<!-- <select name="">
				<option value=""></option>
				<option value=""></option>
			</select> -->
			<!-- 操作日期：
			<input type="text" style="margin:0px;vertical-align:baseline;" id="startDateB" name="startDateB" class="ipt" maxLength="20"  />
			至
			<input type="text" style="margin:0px;vertical-align:baseline;" id="endDateB" name="endDateB" class="ipt" maxLength="20"  /> -->
			<!-- <input type='text' id='key2' placeholder='账号/手机号' /> -->
			<button class="btn btn-blue" onclick="javascript:loadShopGrids2(0)">查询</button>
		</div>
		<div id='shopGrid'></div>
	</div>
	<!--
    	作者：1351661878@qq.com
    	时间：2017-04-13
    	描述：第三个
    -->
	<div id="shopsx" tabId="shopsx" title="供应商管理" class='wst-tab' style="height: 99%">
		<div class="wst-toolbar">
			<button class="tianjia" onclick="javascript:toEditC(0,0)">添加</button>
			<button class="shanchu" onclick="javascript:toBatchDelC(0,0)" >删除</button>
			<select name="s3_type" id="s3_type" class="s3_ipt" >
				<option value=""></option>
				<option value=""></option>
			</select>
			<select name="s3_status" id="s3_status" class="s3_ipt" >
				<option value="">审核状态</option>
				<option value="未审核">未审核</option>
                <option value="已审核">已审核</option>
                <option value="已停用">已停用</option>
                <option value="冻结">冻结</option>
			</select>
			操作日期：
			<input type="text" style="margin:0px;vertical-align:baseline;" id="startDateC" name="startDateC" class="s3_ipt" maxLength="20"  />
			至
			<input type="text" style="margin:0px;vertical-align:baseline;" id="endDateC" name="endDateC" class="s3_ipt" maxLength="20"  />
			<input type='text' id='s3_key' class="s3_ipt" placeholder='公司名称' />
			<button class="btn btn-blue" onclick="javascript:loadShopGrids3(0)">查询</button>
			<!--账号：<input type='text' id='key2x' placeholder='账号/店铺名称' />
			<button class="btn btn-blue" onclick="javascript:loadShopGrid(0)">查询</button>-->
		</div>
		<div id='shopGridx'></div>
	</div>
	<!--
    	作者：1351661878@qq.com
    	时间：2017-04-13
    	描述：第四个
    -->
	<div id="shopsy" tabId="shopsy" title="供应商分组" class='wst-tab' style="height: 99%">
		<div class="wst-toolbar">
			<button class="tianjia" onclick="javascript:toEditD(0,0)">添加</button>
			<button class="shanchu" onclick="javascript:toBatchDelD(0,0)" >删除</button>
			<!--<select name="">
				<option value=""></option>
				<option value=""></option>
			</select>
			<select name="">
				<option value=""></option>
				<option value=""></option>
			</select>
			操作日期：
			<input type="text" style="margin:0px;vertical-align:baseline;" id="startDate" name="startDate" class="ipt" maxLength="20"  />
			至
			<input type="text" style="margin:0px;vertical-align:baseline;" id="endDate" name="endDate" class="ipt" maxLength="20"  />-->
			<input type='text' id='s4_key' class="s4_ipt"  placeholder='名称' />
			<button class="btn btn-blue" onclick="javascript:loadShopGrids4(0)">查询</button>
			<!--账号：<input type='text' id='key2x' placeholder='账号/店铺名称' />
			<button class="btn btn-blue" onclick="javascript:loadShopGrid(0)">查询</button>-->
		</div>
		<div id='shopGridy'></div>
	</div>
</div>
<!--
	作者：1351661878@qq.com
	时间：2017-04-14
	描述：第一个
-->

<div id='expressBoxA' style='display:none'>
    <form id='expressFormA' autocomplete="off" style="height:400px">
    <input type="hidden" />
    <p class="biaoge_p">
    	<span class="biaoti">网点名称<font color='red'>*</font>：</span>
    	<input type='text' id='shopName' name="shopName"  class='ipta changdu2' maxLength='20'/>
    </p>
    <p class="biaoge_p">
    	<span class="biaoti">账号<font color='red'>*</font>：</span>
    	<input type='text' id='loginName' name="loginName"  class='ipta changdu2' maxLength='20'/>
    </p>
    <p class="biaoge_p">
    	<span class="biaoti">密码<font color='red'>*</font>：</span>
    	<input type='text' id='pwd' name="pwd"  class='ipta changdu2' maxLength='20'/>
    </p>
    
    <p class="biaoge_p">
    	<span class="biaoti">联系人<font color='red'>*</font>：</span>
    	<input type='text' id='shopkeeper' name="shopkeeper"  class='ipta changdu1' maxLength='20'/>
    </p>
    <p class="biaoge_p">
    	<span class="biaoti">联系电话<font color='red'>*</font>：</span>
    	<input type='text' id='telephone' name="telephone"  class='ipta changdu2' maxLength='20'/>
    </p>
    <p class="biaoge_p">
    	<span class="biaoti">网店地址<font color='red'>*</font>：</span>
    	<input type='text' id='shopAddress' name="shopAddress"  class='ipta changdu3' maxLength='20'/>
    </p>
    <div class="biaoge_p">
    	<span class="biaoti">地图坐标<font color='red'>*</font>：</span>
    	<div class="changdu4" style="height: 250px;" id="mapContainer" >
    		
    	</div>
    	<div id="tip">
            <b>请输入关键字进行定位：</b>
            <input type="text" id="keyword" name="keyword" value="" onkeydown='keydown(event)' style="width: 95%;"/>
            <div id="result1" name="result1"></div>
        </div>
    	<div id="pos" style="display: none;">
            <b>鼠标左键在地图上单击获取坐标</b>
            <br><div>X：<input type="text" id="lngX" class="ipta" name="lngX" value=""/>&nbsp;Y：<input type="text" class="ipta" id="latY" name="latY" value=""/></div>
        </div>
    </div>
    </form>
 </div>
<!--
	作者：1351661878@qq.com
	时间：2017-04-14
	描述：第er个
-->
<div id='expressBoxB' style='display:none'>
    <form id='expressFormB' autocomplete="off">
    <input type="hidden" />
    
    
    <p class="biaoge_p">
    	<span class="biaoti">管理账号<font color='red'>*</font>：</span>
    	<input type='text' id='loginName' name="loginName"  class='iptb changdu1' maxLength='20'/>
    </p>
	<p class="biaoge_p">
    	<span class="biaoti">登录密码<font color='red'>*</font>：</span>
    	<input type='text' id='loginPwd' name="loginPwd"  class='iptb loginPwd' maxLength='20'/>
    </p>
    <p class="biaoge_p">
    	<span class="biaoti">联系方式<font color='red'>*</font>：</span>
    	<input type='text' id='tel' name="tel"  class='iptb changdu1' maxLength='20'/>
    </p>
    <p class="biaoge_p">
    	<span class="biaoti">分组<font color='red'>*</font>：</span>
    	<select name="staffRoleId" class='iptb' id="staffRoleId">
			<option value="0">请选择</option>
			<?php if(is_array($stock_list) || $stock_list instanceof \think\Collection): $i = 0; $__LIST__ = $stock_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s_li): $mod = ($i % 2 );++$i;?>
				<option value="<?php echo $s_li['roleId']; ?>"><?php echo $s_li['roleName']; ?></option>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
    </p>
    <p class="biaoge_p">
    	<span class="biaoti">状态<font color='red'>*</font>：</span>
    	<input type="radio" name="staffStatus" id="sss1" value="1" class='iptb' checked="checked"/><label for="sss1">正常</label>
    	<input type="radio" name="staffStatus" id="sss2" value="0" class='iptb'/><label for="sss2">停用</label>
    </p>
    </form>
 </div>
<!--
	作者：1351661878@qq.com
	时间：2017-04-14
	描述：第san个
-->
<div id='expressBoxC' style='display:none'>
    <form id='expressFormC' autocomplete="off">
    <input type="hidden" />
    <p class="biaoge_p biaoge_p1">
    	<span class="biaoti">公司名称<font color='red'>*</font>：</span>
    	<input type='text' id='company' name="company"  class='iptc changdu2' maxLength='20'/>
    	<span class="biaoti">简称<font color='red'>*</font>：</span>
    	<input type='text' id='introductions' name="introductions"  class='iptc changdu2' maxLength='20'/>
    </p>
    <p class="biaoge_p biaoge_p1">
    	<span class="biaoti">联系人<font color='red'>*</font>：</span>
    	<input type='text' id='contact' name="contact"  class='iptc changdu2' maxLength='20'/>
    	<span class="biaoti">手机号码<font color='red'>*</font>：</span>
    	<input type='text' id='mobile' name="mobile"  class='iptc changdu2' maxLength='20'/>
    </p>
    <p class="biaoge_p biaoge_p1">
    	<span class="biaoti">电话号码<font color='red'>*</font>：</span>
    	<input type='text' id='dianhua' name="dianhua"  class='iptc changdu2' maxLength='20'/>
    	<span class="biaoti">QQ号码<font color='red'>*</font>：</span>
    	<input type='text' id='qqNum' name="qqNum"  class='iptc changdu2' maxLength='20'/>
    </p>
    <p class="biaoge_p biaoge_p1">
    	<span class="biaoti">Email地址<font color='red'>*</font>：</span>
    	<input type='text' id='email' name="email"  class='iptc changdu2' maxLength='20'/>
    	<span class="biaoti">邮政编码<font color='red'>*</font>：</span>
    	<input type='text' id='postcode' name="postcode"  class='iptc changdu2' maxLength='20'/>
    </p>
    <p class="biaoge_p biaoge_p1">
    	<span class="biaoti"  class='iptc changdu1'>地区<font color='red'>*</font>：</span>
    	<select name="locality"  id="locality" class="iptc"  >
    		<option value="0">请选择</option>
            <?php if(is_array($province) || $province instanceof \think\Collection): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vos): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vos['areaId']; ?>"><?php echo $vos['areaName']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
    	</select>
        
    </p>
    <p class="biaoge_p biaoge_p1">
    	<span class="biaoti">联系地址<font color='red'>*</font>：</span>
    	<input type='text' id='address' name="address"  class='iptc changdu3' maxLength='20'/>
    </p>
    <p class="biaoge_p biaoge_p1">
    	<span class="biaoti">商家分组<font color='red'>*</font>：</span>
    	<select name="group_id" id="group_id"  class='iptc changdu1'>
            <option value="0">请选择</option>
    		
    	</select>
    </p>
    <p class="biaoge_p biaoge_p1">
    	<span class="biaoti">状态<font color='red'>*</font>：</span>
    	<input type="radio" class="iptc" name="status" id="sss1" value="未审核"/><label for="sss1">未审核 </label>
    	<input type="radio" class="iptc" name="status" id="sss2" value="已审核" checked="checked"/><label for="sss2">已审核</label>
    	<input type="radio" class="iptc" name="status" id="sss3" value="已停用"/><label for="sss3">已停用</label>
    	<input type="radio" class="iptc" name="status" id="sss4" value="冻结"/><label for="sss4">冻结</label>
    </p>
    <p class="biaoge_p biaoge_p1">
    	<span class="biaoti">备注<font color='red'>*</font>：</span>
    	<textarea class="iptc  changdu3" id="remarks" name="remarks"  style="height: 80px;resize: none;"></textarea>
    </p>
   <!--  <p class="biaoge_p biaoge_p1">
    	<span class="biaoti">备注<font color='red'>*</font>：</span>
    	2017/4/6 10:54:25
    </p> -->
    </form>
 </div>
<!--
	作者：1351661878@qq.com
	时间：2017-04-14
	描述：第si个
-->
<div id='expressBoxD' style='display:none'>
    <form id='expressFormD' autocomplete="off">
    <input type="hidden" />
    <p class="biaoge_p">
    	<span class="biaoti">分组名称<font color='red'>*</font>：</span>
    	<input type='text' id='group_name' name="group_name"  class='iptd changdu2' maxLength='20'/>
    </p>
    <p class="biaoge_p">
    	<span class="biaoti">排序序号<font color='red'>*</font>：</span>
    	<input type='text' id='sort' name="sort"  class='iptd changdu2' maxLength='20'/>
    </p>
    <p class="biaoge_p">
    	<span class="biaoti">内部备注<font color='red'>*</font>：</span>
    	<textarea class="iptd changdu3" name="remark" id="remark" style="height: 80px;resize: none;"></textarea>
    </p>
    </form>
 </div>
 <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=057592713eb8024cb6751ef9732d8e3d"></script>
 <script type="text/javascript">
            var windowsArr = [];
            var marker = [];
            var mapObj = new AMap.Map("mapContainer", {
                resizeEnable: true,
                view: new AMap.View2D({
                    resizeEnable: true,
                    zoom:12//地图显示的缩放级别
                }),
                keyboardEnable:false
            });
             var markerT = new AMap.Marker({
	            map:mapObj,
	            bubble:true
	        })
            var clickEventListener=AMap.event.addListener(mapObj,'click',function(e){
            	 markerT.setPosition(e.lnglat);
                document.getElementById("lngX").value=e.lnglat.getLng();
                document.getElementById("latY").value=e.lnglat.getLat();
            });
//   	  var message = document.getElementById('message');
//	        mapObj.on('click',function(e){
//		        alert(1)
//	            markerT.setPosition(e.lnglat);
//		          geocoder.getAddress(e.lnglat,function(status,result){
//		            if(status=='complete'){
//		               input.value = result.regeocode.formattedAddress
//		               message.innerHTML = ''
//		            }else{
//		               message.innerHTML = '无法获取地址'
//		            }
//		         })
//      	})
     
            document.getElementById("keyword").onkeyup = keydown;
            //输入提示
            function autoSearch() {
                var keywords = document.getElementById("keyword").value;
                var auto;
                //加载输入提示插件
                    AMap.service(["AMap.Autocomplete"], function() {
                    var autoOptions = {
                        city: "" //城市，默认全国
                    };
                    auto = new AMap.Autocomplete(autoOptions);
                    //查询成功时返回查询结果
                    if ( keywords.length > 0) {
                        auto.search(keywords, function(status, result){
                            autocomplete_CallBack(result);
                        });
                    }
                    else {
                        document.getElementById("result1").style.display = "none";
                    }
                });
            }
     
            //输出输入提示结果的回调函数
            function autocomplete_CallBack(data) {
                var resultStr = "";
                var tipArr = data.tips;
                if (tipArr&&tipArr.length>0) {
                    for (var i = 0; i < tipArr.length; i++) {
                        resultStr += "<div id='divid" + (i + 1) + "' onmouseover='openMarkerTipById(" + (i + 1)
                                    + ",this)' onclick='selectResult(" + i + ")' onmouseout='onmouseout_MarkerStyle(" + (i + 1)
                                    + ",this)' style=\"font-size: 13px;cursor:pointer;padding:5px 5px 5px 5px;\"" + "data=" + tipArr[i].adcode + ">" + tipArr[i].name + "<span style='color:#C1C1C1;'>"+ tipArr[i].district + "</span></div>";
                    }
                }
                else  {
                    resultStr = " π__π 亲,人家找不到结果!<br />要不试试：<br />1.请确保所有字词拼写正确<br />2.尝试不同的关键字<br />3.尝试更宽泛的关键字";
                }
                document.getElementById("result1").curSelect = -1;
                document.getElementById("result1").tipArr = tipArr;
                document.getElementById("result1").innerHTML = resultStr;
                document.getElementById("result1").style.display = "block";
            }
     
            //输入提示框鼠标滑过时的样式
            function openMarkerTipById(pointid, thiss) {  //根据id打开搜索结果点tip
                thiss.style.background = '#CAE1FF';
            }
     
            //输入提示框鼠标移出时的样式
            function onmouseout_MarkerStyle(pointid, thiss) {  //鼠标移开后点样式恢复
                thiss.style.background = "";
            }
     
            //从输入提示框中选择关键字并查询
            function selectResult(index) {
                if(index<0){
                    return;
                }
                if (navigator.userAgent.indexOf("MSIE") > 0) {
                    document.getElementById("keyword").onpropertychange = null;
                    document.getElementById("keyword").onfocus = focus_callback;
                }
                //截取输入提示的关键字部分
                var text = document.getElementById("divid" + (index + 1)).innerHTML.replace(/<[^>].*?>.*<\/[^>].*?>/g,"");
                var cityCode = document.getElementById("divid" + (index + 1)).getAttribute('data');
                document.getElementById("keyword").value = text;
                document.getElementById("result1").style.display = "none";
                //根据选择的输入提示关键字查询
                mapObj.plugin(["AMap.PlaceSearch"], function() {
                    var msearch = new AMap.PlaceSearch();  //构造地点查询类
                    AMap.event.addListener(msearch, "complete", placeSearch_CallBack); //查询成功时的回调函数
                    msearch.setCity(cityCode);
                    msearch.search(text);  //关键字查询查询
                });
            }
     
            //定位选择输入提示关键字
            function focus_callback() {
                if (navigator.userAgent.indexOf("MSIE") > 0) {
                    document.getElementById("keyword").onpropertychange = autoSearch;
               }
            }
     
            //输出关键字查询结果的回调函数
            function placeSearch_CallBack(data) {
                //清空地图上的InfoWindow和Marker
                windowsArr = [];
                marker     = [];
                mapObj.clearMap();
				markerT = new AMap.Marker({
					map:mapObj,
					bubble:true
				})
                var resultStr1 = "";
                var poiArr = data.poiList.pois;
                var resultCount = poiArr.length;
                for (var i = 0; i < resultCount; i++) {
                    resultStr1 += "<div id='divid" + (i + 1) + "' onmouseover='openMarkerTipById1(" + i + ",this)' onmouseout='onmouseout_MarkerStyle(" + (i + 1) + ",this)' style=\"font-size: 12px;cursor:pointer;padding:0px 0 4px 2px; border-bottom:1px solid #C1FFC1;\"><table><tr><td><img src=\"http://webapi.amap.com/images/" + (i + 1) + ".png\"></td>" + "<td><h3><font color=\"#00a6ac\">名称: " + poiArr[i].name + "</font></h3>";
                        resultStr1 += TipContents(poiArr[i].type, poiArr[i].address, poiArr[i].tel) + "</td></tr></table></div>";
                        addmarker(i, poiArr[i]);
                }
                mapObj.setFitView();
            }
     
            //鼠标滑过查询结果改变背景样式，根据id打开信息窗体
            function openMarkerTipById1(pointid, thiss) {
                thiss.style.background = '#CAE1FF';
                windowsArr[pointid].open(mapObj, marker[pointid]);
            }
     
            //添加查询结果的marker&infowindow
            function addmarker(i, d) {
                var lngX = d.location.getLng();
                var latY = d.location.getLat();
                var markerOption = {
                    map:mapObj,
                    icon:"http://webapi.amap.com/images/" + (i + 1) + ".png",
                    position:new AMap.LngLat(lngX, latY)
                };
                var mar = new AMap.Marker(markerOption);
                marker.push(new AMap.LngLat(lngX, latY));
     
                var infoWindow = new AMap.InfoWindow({
                    content:"<h3><font color=\"#00a6ac\">  " + (i + 1) + ". " + d.name + "</font></h3>" + TipContents(d.type, d.address, d.tel),
                    size:new AMap.Size(300, 0),
                    autoMove:true,
                    offset:new AMap.Pixel(0,-30)
                });
                windowsArr.push(infoWindow);
               var aa = function (e) {
                    var nowPosition = mar.getPosition(),
                        lng_str = nowPosition.lng,
                        lat_str = nowPosition.lat;
                    infoWindow.open(mapObj, nowPosition);
                    document.getElementById("lngX").value = lng_str;
                    document.getElementById("latY").value = lat_str;
                };
                AMap.event.addListener(mar, "mouseover", aa);
            }
     
            //infowindow显示内容
			
            function TipContents(type, address, tel) {  //窗体内容
                if (type == "" || type == "undefined" || type == null || type == " undefined" || typeof type == "undefined") {
                    type = "暂无";
                }
                if (address == "" || address == "undefined" || address == null || address == " undefined" || typeof address == "undefined") {
                    address = "暂无";
                }
                if (tel == "" || tel == "undefined" || tel == null || tel == " undefined" || typeof address == "tel") {
                    tel = "暂无";
                }
                var str = "  地址：" + address + "<br />  电话：" + tel + " <br />  类型：" + type;
                return str;
            }
            function keydown(event){
                var key = (event||window.event).keyCode;
                var result = document.getElementById("result1")
                var cur = result.curSelect;
                if(key===40){  //down
                    if(cur + 1 < result.childNodes.length){
                        if(result.childNodes[cur]){
                            result.childNodes[cur].style.background='';
                        }
                        result.curSelect=cur+1;
                        result.childNodes[cur+1].style.background='#CAE1FF';
                        document.getElementById("keyword").value = result.tipArr[cur+1].name;
                    }
                }else if(key===38){  //up
                    if(cur-1>=0){
                        if(result.childNodes[cur]){
                            result.childNodes[cur].style.background='';
                        }
                        result.curSelect=cur-1;
                        result.childNodes[cur-1].style.background='#CAE1FF';
                        document.getElementById("keyword").value = result.tipArr[cur-1].name;
                    }
                }else if(key === 13){
                    var res = document.getElementById("result1");
                    if(res && res['curSelect'] !== -1){
                        selectResult(document.getElementById("result1").curSelect);
                    }
                }else{
                    autoSearch();
                }
            }
			
            
        </script>


<script src="__ADMIN__/configure/logmoneys.js?v=<?php echo $v; ?>" type="text/javascript"></script>


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