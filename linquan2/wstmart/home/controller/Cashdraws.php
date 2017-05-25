<?php
namespace wstmart\home\controller;
use wstmart\common\model\CashDraws as M;
/**
 * 提现记录控制器
 */
class Cashdraws extends Base{
    /**
     * 查看用户资金流水
     */
	public function index(){
		return $this->fetch('users/cashdraws/list');
	}
    /**
     * 获取用户数据
     */
    public function pageQuery(){
        $userId = (int)session('WST_USER.userId');
        $data = model('CashDraws')->pageQuery(0,$userId);
        return WSTReturn("", 1,$data);
    }

    /**
     * 跳转提现页面
     */
    public function toEdit(){
        $this->assign('accs',model('CashConfigs')->listQuery(0,(int)session('WST_USER.userId')));
        return $this->fetch('users/cashdraws/box_draw');
    }

    /**
     * 提现
     */ 
    public function drawMoney(){
        $m = new M();
        return $m->drawMoney();
    }


    /**
     * 查看用户资金流水
     */
    public function shopIndex(){
        return $this->fetch('shops/cashdraws/list');
    }
    /**
     * 获取用户数据
     */
    public function pageQueryByShop(){
        $shopId = (int)session('WST_USER.shopId');
        $data = model('CashDraws')->pageQuery(1,$shopId);
        return WSTReturn("", 1,$data);
    }
    /**
     * 申请提现
     */
    public function toEditByShop(){
        $this->assign('object',model('shops')->getShopAccount());
        return $this->fetch('shops/cashdraws/box_draw');
    }
    /**
     * 提现
     */ 
    public function drawMoneyByShop(){
        $m = new M();
        return $m->drawMoneyByShop();
    }
}
