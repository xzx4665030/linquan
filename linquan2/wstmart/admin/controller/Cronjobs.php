<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\CronJobs as M;
/**

 * 定时任务控制器
 */
class Cronjobs extends Base{
	/**
	 * 取消未付款订单
	 */
	public function autoCancelNoPay(){
		$m = new M();
        $rs = $m->autoCancelNoPay();
        return json($rs);
	}
	/**
	 * 自动好评
	 */
	public function autoAppraise(){
        $m = new M();
        $rs = $m->autoAppraise();
        return json($rs);
	}
	/**
	 * 自动确认收货
	 */
	public function autoReceive(){
	 	$m = new M();
        $rs = $m->autoReceive();
        return json($rs);
	}
}