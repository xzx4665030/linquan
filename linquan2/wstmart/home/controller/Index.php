<?php
namespace wstmart\home\controller;
/**
 * 默认控制器
 */
class Index extends Base{
	
    public function index(){
    	$categorys = model('GoodsCats')->getFloors();
    	$this->assign('floors',$categorys);
    	$this->assign('hideCategory',1);
    	return $this->fetch('index');
    }
    /**
     * 保存目录ID
     */
    public function getMenuSession(){
    	$menuId = input("post.menuId");
    	$menuType = session('WST_USER.loginTarget');
    	session('WST_MENUID3'.$menuType,$menuId);
    } 
    /**
     * 获取用户信息
     */
    public function getSysMessages(){
    	$rs = model('Systems')->getSysMessages();
    	return $rs;
    }
    /**
     * 定位菜单以及跳转页面
     */
    public function position(){
    	$menuId = (int)input("post.menuId");
    	$menuType = ((int)input("post.menuType")==1)?1:0;
        $menus = model('HomeMenus')->getParentId($menuId);
        session('WST_MENID'.$menus['menuType'],$menus['parentId']);
    	session('WST_MENUID3'.$menuType,$menuId);
    }

    /**
     * 转换url
     */
    public function transfor(){
        $data = input('param.');
        $url = $data['url'];
        unset($data['url']);
        echo Url($url,$data);
    }
}
