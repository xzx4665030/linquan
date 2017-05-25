<?php
namespace wstmart\home\controller;
use wstmart\home\model\Goods;
use wstmart\common\model\GoodsCats;
/**
 * 门店控制器
 */

class Shops extends Base{
	/**
	 * 商家登录
	 */
	public function login(){
		$USER = session('WST_USER');
		if(!empty($USER) && isset($USER['shopId'])){
			$this->redirect("shops/index");
		}
		$loginName = cookie("loginName");
		if(!empty($loginName)){
			$this->assign('loginName',cookie("loginName"));
		}else{
			$this->assign('loginName','');
		}
		return $this->fetch('shop_login');
	}
	/**
	 * 商家中心
	 */
	public function index(){
		session('WST_MENID1',null);
		session('WST_MENUID31',null);
		$s = model('shops');
		$data = $s->getShopSummary((int)session('WST_USER.shopId'));
		$this->assign('data',$data);
		return $this->fetch('shops/index');
	}
    /**
     * 店铺街
     */
    public function shopStreet(){
    	$g = new GoodsCats();
    	$goodsCats = $g->listQuery(0);
    	$this->assign('goodscats',$goodsCats);
    	//店铺街列表
    	$s = model('shops');
    	$pagesize = 10;
    	$selectedId = input("get.id/d");
    	$this->assign('selectedId',$selectedId);
    	$list = $s->pageQuery($pagesize);
    	$this->assign('list',$list);
    	$this->assign('keyword',input('keyword'));
    	$this->assign('keytype',1);
    	return $this->fetch('shop_street');
    }
    /**
     * 店铺详情
     */
    public function home(){
    	hook("homeBeforeGoShopHome");
    	$s = model('shops');
    	$shopId = (int)input("param.shopId/d");
    	$data['shop'] = $s->getShopInfo($shopId);
        $ct1 = input("param.ct1/d",0);
        $ct2 = input("param.ct2/d",0);
        $goodsName = input("param.goodsName");
        if(($data['shop']['shopId']==1 || $shopId==0) && $ct1==0 && !isset($goodsName)){
        	$params = input();
        	unset($params["shopId"]);
            $this->redirect(Url('home/shops/selfShop'),$params);
        }
    	if(empty($data['shop']))return $this->fetch('error_lost');
    	$data['shopcats'] = $f = model('ShopCats','model')->getShopCats($shopId);
    	$g = model('goods');
    	$data['list'] = $g->shopGoods($shopId);
    	$this->assign('msort',input("param.msort/d",0));//筛选条件
    	$this->assign('mdesc',input("param.mdesc/d",1));//升降序
    	$this->assign('sprice',input("param.sprice"));//价格范围
    	$this->assign('eprice',input("param.eprice"));
    	$this->assign('ct1',$ct1);//一级分类
    	$this->assign('ct2',$ct2);//二级分类
    	$this->assign('goodsName',urldecode($goodsName));//搜索
    	$this->assign('data',$data);
    	
    	return $this->fetch('shop_home');
    }
    
    /**
     * 店铺分类
     */
    public function cat(){
    	$s = model('shops');
    	$shopId = (int)input("param.shopId/d");
    	$data['shop'] = $s->getShopInfo($shopId);
    
    	$ct1 = input("param.ct1/d",0);
    	$ct2 = input("param.ct2/d",0);
    	$goodsName = input("param.goodsName");
    	if(($data['shop']['shopId']==1 || $shopId==0) && $ct1==0 && !isset($goodsName)){
	    	 $params = input();
	    	 unset($params["shopId"]);
	    	 $this->redirect('shops/selfShop',$params);
    	}
    	if(empty($data['shop']))return $this->fetch('error_lost');
    	$data['shopcats'] = $f = model('ShopCats','model')->getShopCats($shopId);
    	$g = model('goods');
    	$data['list'] = $g->shopGoods($shopId);
    	$this->assign('msort',input("param.msort/d",0));//筛选条件
    	$this->assign('mdesc',input("param.mdesc/d",1));//升降序
    	$this->assign('sprice',input("param.sprice"));//价格范围
    	$this->assign('eprice',input("param.eprice"));
    	$this->assign('ct1',$ct1);//一级分类
    	$this->assign('ct2',$ct2);//二级分类
    	$this->assign('goodsName',urldecode($goodsName));//搜索
    	$this->assign('data',$data);
    	return $this->fetch('shop_home');
    }
    
    /**
     * 查看店铺设置
     */
    public function info(){
    	$s = model('shops');
    	$object = $s->getByView((int)session('WST_USER.shopId'));
    	$this->assign('object',$object);
    	return $this->fetch('shops/shops/view');
    }
    /**
    * 自营店铺
    */
    public function selfShop(){
    	hook("homeBeforeGoSelfShop");
        $s = model('shops');
        $data['shop'] = $s->getShopInfo(1);
        if(empty($data['shop']))return $this->fetch('error_lost');
        $this->assign('selfShop',1);
	    $data['shopcats'] = model('ShopCats')->getShopCats(1);
	    $this->assign('goodsName',urldecode(input("param.goodsName")));//搜索
	    // 店长推荐
	    $data['rec'] = $s->getRecGoods('rec',6);
	    // 热销商品
	    $data['hot'] = $s->getRecGoods('hot',6);
	    $this->assign('data',$data);
	    return $this->fetch('self_shop');
    }

    /**
     * 编辑店铺资料
     */
    public function editInfo(){
        $rs = model('shops')->editInfo();
        return $rs;
    }

    /**
     * 获取店铺金额
     */
    public function getShopMoney(){
        $rs = model('shops')->getFieldsById((int)session('WST_USER.shopId'),'shopMoney,lockMoney');
        $urs = model('users')->getFieldsById((int)session('WST_USER.userId'),'payPwd');
        $rs['isSetPayPwd'] = ($urs['payPwd']=='')?0:1;
        $rs['isDraw'] = ((float)WSTConf('CONF.drawCashShopLimit')<=$rs['shopMoney'])?1:0;
        unset($urs);
        return WSTReturn('',1,$rs);
    }
    
	/**
    * 店铺装修设置
    */
    public function shopDiyset(){
       
	    return $this->fetch('shops/diy/shop_set');
    }
    
    /**
     * 店铺装修
     */
    public function editdecoration(){
    	return $this->fetch('shops/diy/shop_home');
    }
    
    /**
     * 生成店铺装修页面
     */
    public function storedecoration(){
    	return $this->fetch('shops/diy/shop_home');
    }
}
