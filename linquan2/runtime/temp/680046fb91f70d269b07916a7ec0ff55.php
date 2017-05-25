<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:58:"D:\phpStudy\WWW\linquan2\addons\kuaidi\view/home/view.html";i:1493697108;}*/ ?>
<link href="__ROOT__/addons/kuaidi/view/home/express.css" rel="stylesheet">
<div class='order-box'>
	<div class='box-head'>物流信息</div>
	<table class='wst-form' id="wst-express">
		<tr>
			<th width='200' class="title">时间</th>
			<th class="title">地点和跟踪进度</th>
		</tr>
		<?php if(isset($expressLogs['data'])){ if(is_array($expressLogs['data']) || $expressLogs['data'] instanceof \think\Collection): $i = 0; $__LIST__ = $expressLogs['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		<tr>
			<th width='200'><?php echo $vo['time']; ?>  <?php echo WSTgetWeek($vo['time']); ?></th>
			<td><?php echo $vo['context']; ?></td>
		</tr>
		<?php endforeach; endif; else: echo "" ;endif; if(empty($expressLogs['data']) || ($expressLogs['data'] instanceof \think\Collection && $expressLogs['data']->isEmpty())): ?>
		<tr>
			<th colspan="2">物流单暂无结果！</th>
		</tr>
		<?php endif; }else{ ?>
		<tr>
			<th colspan="2">物流单暂无结果！</th>
		</tr>
		<?php } ?>
	</table>
</div>