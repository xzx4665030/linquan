<?php
namespace wstmart\home\controller;
use wstmart\common\model\Carts as M;
use wstmart\common\model\Payments as PM;

use think\Db;
/**
 * 购物车控制器
 */
class Carts extends Base{
	//xzx  判断当购物车中数量加购买数量大于库存数量时不允许点击添加购物车的操作
	public function is_addCart(){
		$userId = (int)session('WST_USER.userId');
		$goodsId = (int)input('post.goodsId');
		$goodsSpecId = (int)input('post.goodsSpecId');
		$cartNum = (int)input('post.buyNum',1);
		$cartNum = ($cartNum>0)?$cartNum:1;
		
		//先获取购物车中相对应的产品规格id的产品数量
		$where['goodsId'] = $goodsId;
		$where['userId'] = $userId;
		$where['goodsSpecId'] = $goodsSpecId;
		$cart_num = Db::name('carts')->where($where)->find();
		$cart_number = $cart_num['cartNum'];
			
		$m = new M();
		$rs = $m->is_addCart($goodsId,$goodsSpecId,$cartNum,$cart_number);
		return $rs;
	}
	
	
    /**
    * 查看商城消息
    */
	public function addCart(){
		$m = new M();
		$rs = $m->addCart();
		return $rs;
	}
	/**
	 * 查看购物车列表
	 */
	public function index(){
		$m = new M();
		$carts = $m->getCarts(false);
		$this->assign('carts',$carts);
		return $this->fetch('carts');
	}
	/**
	 * 删除购物车里的商品
	 */
	public function delCart(){
		$m = new M();
		$rs= $m->delCart();
		return $rs;
	}
	/**
	 * 虚拟商品下单
	 */
	public function quickSettlement(){
		$m = new M();
		//获取支付方式
		$pm = new PM();
		$payments = $pm->getByGroup('1',1);
        $carts = $m->getQuickCarts();
        if(empty($carts['carts'])){
        	$this->assign('message','Sorry~您还未选择商品。。。');
			return $this->fetch('error_msg');
        }
        hook("homeControllerCartsSettlement",["carts"=>$carts,"payments"=>&$payments]);
        //获取用户积分
        $user = model('users')->getFieldsById((int)session('WST_USER.userId'),'userScore');
        $this->assign('userScore',$user['userScore']);
        $this->assign('payments',$payments);
        $this->assign('carts',$carts);
        return $this->fetch('settlement_quick');
	}
	/**
	 * 跳去购物车结算页面
	 */
    public function settlement(){
		$m = new M();
		//获取一个用户地址
		$userAddress = model('UserAddress')->getDefaultAddress();
		$this->assign('userAddress',$userAddress);
		//获取省份
		$areas = model('Areas')->listQuery();
		$this->assign('areaList',$areas);
		//获取支付方式
		$pm = new PM();
		$payments = $pm->getByGroup('1');
		$carts = $m->getCarts(true);
		if(empty($carts['carts'])){
        	$this->assign('message','Sorry~您还未选择商品。。。');
			return $this->fetch('error_msg');
        }
		hook("homeControllerCartsSettlement",["carts"=>$carts,"payments"=>&$payments]);
        //获取用户积分
        $user = model('users')->getFieldsById((int)session('WST_USER.userId'),'userScore');
        //计算可用积分和金额
        $goodsTotalMoney = $carts['goodsTotalMoney'];
        $goodsTotalScore = WSTScoreToMoney($goodsTotalMoney,true);
        $useOrderScore =0;
        $useOrderMoney = 0;
        if($user['userScore']>$goodsTotalScore){
            $useOrderScore = $goodsTotalScore;
            $useOrderMoney = $goodsTotalMoney;
        }else{
        	$useOrderScore = $user['userScore'];
            $useOrderMoney = WSTScoreToMoney($useOrderScore);
        }
        $this->assign('userOrderScore',$useOrderScore);
        $this->assign('userOrderMoney',$useOrderMoney);
		$this->assign('carts',$carts);
		$this->assign('payments',$payments);
		return $this->fetch('settlement');
	}
	
	/**
	 * 计算运费、积分和总商品价格
	 */
	public function getCartMoney(){
		$m = new M();
		$data = $m->getCartMoney();
		return $data;
	}
	/**
	 * 计算运费、积分和总商品价格
	 */
	public function getQuickCartMoney(){
		$m = new M();
		$data = $m->getQuickCartMoney();
		return $data;
	}
	/**
	 * 修改购物车商品状态
	 */
	public function changeCartGoods(){
		$m = new M();
		$rs = $m->changeCartGoods();
		return $rs;
	}
	/**
	 * 获取购物车商品
	 */
    public function getCart(){
		$m = new M();
		$carts = $m->getCarts(false);
		return WSTReturn("", 1,$carts);;
	}
	/**
	 * 获取购物车信息
	 */
	public function getCartInfo(){
		$m = new M();
		$rs = $m->getCartInfo();
		return WSTReturn("", 1,$rs);
	}
}
