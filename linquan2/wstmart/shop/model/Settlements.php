<?php 
namespace wstmart\admin\model;
use think\Db;
/**
 * ============================================================================
 * WSTMart多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.wstmart.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！未经本公司授权您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 结算业务处理
 */
class Settlements extends Base{
    /**
	 * 获取结算列表
	 */
	public function pageQuery(){
		$settlementNo = input('settlementNo');
		$shopName = input('shopName');
		$settlementStatus = (int)input('settlementStatus',-1);
		$where = [];
		if($settlementNo!='')$where['settlementNo'] = ['like','%'.$settlementNo.'%'];
        if($shopName!='')$where['shopName|shopSn'] = ['like','%'.$shopName.'%']; 
        if($settlementStatus>=0)$where['settlementStatus'] = $settlementStatus;
		return Db::name('settlements')->alias('st')->join('__SHOPS__ s','s.shopId=st.shopId','left')->where($where)->field('s.shopName,settlementNo,settlementId,settlementMoney,commissionFee,backMoney,settlementStatus,settlementTime,st.createTime')->order('st.settlementId', 'desc')
			->paginate(input('pagesize/d'))->toArray();
	}

	/**
	 * 获取结算订单详情
	 */
	public function getById(){
        $settlementId = (int)input('id');
        $object =  Db::name('settlements')->alias('st')->where('settlementId',$settlementId)->join('__SHOPS__ s','s.shopId=st.shopId','left')->field('s.shopName,st.*')->find();
        if(!empty($object)){
        	$object['list'] = Db::name('orders')->where(['settlementId'=>$settlementId])
        	          ->field('orderId,orderNo,payType,goodsMoney,deliverMoney,realTotalMoney,totalMoney,commissionFee,scoreMoney,createTime')
        	          ->order('payType desc,orderId desc')->select();
        }
        return $object;
	}
	/**
	 * 处理订单
	 */
	public function handle(){
		$id = (int)input('settlementId');
		$remarks = input('remarks');
		Db::startTrans();
        try{
			$object = $this->get($id);
			$object->settlementStatus = 1;
			$object->settlementTime = date('Y-m-d H:i:s');
			if($remarks!='')$object->remarks = $remarks;
			$rs = $object->save();
			if(false !== $rs){
				$shop = model('Shops')->get($object->shopId);
				WSTSendMsg($shop['userId'],"您的结算申请【".$object->settlementNo."】已处理，请留意到账户息哦~",['from'=>4,'dataId'=>$id]);
				$shop->shopMoney = $shop->shopMoney+$object->backMoney;
				$shop->paymentMoney = $shop->paymentMoney + $object->commissionFee;
				$shop->save();
                $lmarr = [];
				//增加资金变动信息
                if($object->settlementMoney>0){
                    $lm = [];
                    $lm['targetType'] = 1;
                    $lm['targetId'] = $object->shopId;
                    $lm['dataId'] = $id;
                    $lm['dataSrc'] = 2;
                    $lm['remark'] = '结算订单申请【'.$object->settlementNo.'】收入订单金额¥'.$object->settlementMoney;
                    $lm['moneyType'] = 1;
                    $lm['money'] = $object->settlementMoney;
                    $lm['payType'] = 0;
                    $lm['createTime'] = date('Y-m-d H:i:s');
                    $lmarr[] = $lm;
                }
                if($object->commissionFee>0){
                    //要对有积分支付的佣金记录进行处理
                    $commissionFee = $object->commissionFee;
                    //如果backMoney小于0则说明平台收到的钱不足以支付佣金，这个backMoney已经减去了积分支付，所以直接显示backMoney为应付的佣金就好
                    if($object->backMoney<0){
                        $commissionFee = $object->backMoney;
                    }
                    $lm = [];
                    $lm['targetType'] = 1;
                    $lm['targetId'] = $object->shopId;
                    $lm['dataId'] = $id;
                    $lm['dataSrc'] = 2;
                    $lm['remark'] = '结算订单申请【'.$object->settlementNo.'】支出订单佣金¥'.$commissionFee."。".(($object->remarks!='')?"【操作备注】：".$object->remarks:'');
                    $lm['moneyType'] = 0;
                    $lm['money'] = $commissionFee;
                    $lm['payType'] = 0;
                    $lm['createTime'] = date('Y-m-d H:i:s');
                    $lmarr[] = $lm;
                }
				if(count($lmarr)>0)model('LogMoneys')->saveAll($lmarr);
				Db::commit();
				return WSTReturn('操作成功!',1);
			}
		}catch (\Exception $e) {
            Db::rollback();
        }
		return WSTReturn('操作失败!',-1);
	}

	/**
	 * 获取订单商品
	 */
	public function pageGoodsQuery(){
        $id = (int)input('id');
        return Db::name('orders')->alias('o')->join('__ORDER_GOODS__ og','o.orderId=og.orderId')->where('o.settlementId',$id)
        ->field('orderNo,og.goodsPrice,og.goodsName,og.goodsSpecNames,og.goodsNum,og.commissionRate')->order('o.payType desc,o.orderId desc')->paginate(input('pagesize/d'))->toArray();
    }

    /**
     * 获取待结算商家
     */
    public function pageShopQuery(){
    	$areaIdPath = input('areaIdPath');
    	$shopName = input('shopName');
    	$where = [];
    	if($shopName!='')$where['s.shopName|s.shopSn'] = ['like','%'.$shopName.'%'];
    	if($areaIdPath !='')$where['s.areaIdPath'] = ['like',$areaIdPath."%"];
    	$where['s.dataFlag'] = 1;
    	$where['s.noSettledOrderNum'] = ['>',0];
		return Db::table('__SHOPS__')->alias('s')->join('__AREAS__ a2','s.areaId=a2.areaId')
		       ->where($where)
		       ->field('shopId,shopSn,shopName,a2.areaName,shopkeeper,telephone,abs(noSettledOrderFee) noSettledOrderFee,noSettledOrderNum')
		       ->order('noSettledOrderFee desc')->paginate(input('pagesize/d'));
	}

   /**
    * 获取商家未结算的订单
    */
   public function pageShopOrderQuery(){
   	     $orderNo = input('orderNo');
   	     $payType = (int)input('payType',-1);
         $where = [];
         $where['settlementId'] = 0;
         $where['orderStatus'] = 2;
         $where['shopId'] = (int)input('id');
         $where['dataFlag'] = 1;
         if($orderNo!='')$where['orderNo'] = ['like','%'.$orderNo.'%'];
         if(in_array($payType,[0,1]))$where['payType'] = $payType;
   	     $page = Db::name('orders')->where($where)
        	          ->field('orderId,orderNo,payType,goodsMoney,deliverMoney,realTotalMoney,totalMoney,commissionFee,createTime')
        	          ->order('payType desc,orderId desc')->paginate(input('pagesize/d'))->toArray();
        if(count($page['Rows'])>0){
        	foreach ($page['Rows'] as $key => $v) {
        		$page['Rows'][$key]['payTypeName'] = WSTLangPayType($v['payType']);
        	}
        }
        return $page;
   }

   /**
    * 生成结算单
    */
	public function generateSettleByShop(){
		$shopId = (int)input('id');
		$where = [];
		$where['shopId'] = $shopId;
		$where['dataFlag'] = 1;
		$where['orderStatus'] = 2;
		$where['settlementId'] = 0;
		$orders = Db::name('orders')->where($where)->field('orderId,payType,realTotalMoney,scoreMoney,commissionFee')->select();
    	if(empty($orders))return WSTReturn('没有需要结算的订单，请刷新后再核对!');
    	$settlementMoney = 0;
        $commissionFee = 0;    //平台要收的佣金
        $ids = [];
    	foreach ($orders as $key => $v) {
            $ids[] = $v['orderId'];
    		if($v['payType']==1){
                $settlementMoney += $v['realTotalMoney']+$v['scoreMoney'];
            }else{
                $settlementMoney += $v['scoreMoney'];
            }
            $commissionFee += abs($v['commissionFee']);
    	}
    	$backMoney = $settlementMoney-$commissionFee;
    	$shops = model('shops')->get($shopId);
    	if(empty($shops))WSTReturn('无效的店铺结算账号!');
    	Db::startTrans();
		try{
            $data = [];
            $data['settlementType'] = 0;
            $data['shopId'] = $shopId;
            $data['settlementMoney'] = $settlementMoney;
            $data['commissionFee'] = $commissionFee;
            $data['backMoney'] = $settlementMoney-$commissionFee;
            $data['settlementStatus'] = 1;
            $data['settlementTime'] = date('Y-m-d H:i:s');
            $data['createTime'] = date('Y-m-d H:i:s');
            $data['settlementNo'] = '';
            $result = $this->save($data);
            if(false !==  $result){
            	$this->settlementNo = $this->settlementId.(fmod($this->settlementId,7));
            	$this->save();
            	//修改商家订单情况
                Db::name('orders')->where(['orderId'=>['in',$ids]])->update(['settlementId'=>$this->settlementId]);
                $shops->shopMoney = $shops->shopMoney + $backMoney;
                $shops->noSettledOrderNum = 0;
                $shops->noSettledOrderFee = 0;
                $shops->paymentMoney = 0;
                $shops->save();
                //发消息
				WSTSendMsg($shops['userId'],"您有新的结算单【".$this->settlementNo."】生成，请留意结算信息~",['from'=>4,'dataId'=>$this->settlementId]);
				//增加资金变动信息
                $lmarr = [];
                if($settlementMoney>0){
                    $lm = [];
                    $lm['targetType'] = 1;
                    $lm['targetId'] = $shopId;
                    $lm['dataId'] = $this->settlementId;
                    $lm['dataSrc'] = 2;
                    $lm['remark'] = '结算订单申请【'.$this->settlementNo.'】收入订单金额¥'.$settlementMoney."。";
                    $lm['moneyType'] = 1;
                    $lm['money'] = $settlementMoney;
                    $lm['payType'] = 0;
                    $lm['createTime'] = date('Y-m-d H:i:s');
                    $lmarr[] = $lm;
                }
                if($commissionFee>0){
    				$lm = [];
    				$lm['targetType'] = 1;
    				$lm['targetId'] = $shopId;
    				$lm['dataId'] = $this->settlementId;
    				$lm['dataSrc'] = 2;
    				$lm['remark'] = '结算订单申请【'.$this->settlementNo.'】收取订单佣金¥'.$commissionFee."。";
    				$lm['moneyType'] = 0;
    				$lm['money'] = $commissionFee;
    				$lm['payType'] = 0;
    				$lm['createTime'] = date('Y-m-d H:i:s');
                    $lmarr[] = $lm;
                }
				if(count($lmarr)>0)model('LogMoneys')->saveAll($lmarr);
				Db::commit();
            	return WSTReturn('生成结算单成功',1);
            }
		}catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn('生成结算单失败',-1);
    }
}