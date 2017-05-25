<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\SysConfigs as M;
/**

 * 商城配置控制器
 */
class Sysconfigs extends Base{
	
    public function index(){
    	$m = new M();
    	$object = $m->getSysConfigs();
    	$this->assign("object",$object);
    	return $this->fetch("edit");
    }
    
    /**
     * 保存
     */
    public function edit(){
    	$m = new M();
    	return $m->edit();
    }
}
