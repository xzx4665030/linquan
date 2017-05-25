<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\Hooks as M;
/**

 * 广告控制器
 */
class Hooks extends Base{
	
    public function index(){
    	return $this->fetch("list");
    }
    /**
     * 获取分页
     */
    public function pageQuery(){
        $m = new M();
        return $m->pageQuery();
    }
 
    /**
    * 获取数据
    */
    public function get(){
        $m = new M();
        return $m->getById(Input("id/d",0));
    }
    
}
