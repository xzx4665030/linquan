<?php
namespace wstmart\wechat\controller;
use wstmart\wechat\model\Index as M;
/**
 * 默认控制器
 */
class Index extends Base{
	/**
     * 首页
     */
    public function index(){
    	$m = new M();
    	hook('wechatControllerIndexIndex',['getParams'=>input()]);
    	$news = $m->getSysMsg('msg');
    	$this->assign('news',$news);
    	return $this->fetch('index');
    }
    /**
     * 楼层
     */
    public function pageQuery(){
    	$m = new M();
    	$rs = $m->pageQuery();
    	if(isset($rs['goods'])){
    		foreach ($rs['goods'] as $key =>$v){
    			$rs['goods'][$key]['goodsImg'] = WSTImg($v['goodsImg'],2);
    		}
    	}
        return $rs;
    }
    /**
     * 跳去登陆之前的地址
     */
    public function sessionAddress(){
    	session('WST_WX_WlADDRESS',input('url'));
    	return $rs;
    }
}
