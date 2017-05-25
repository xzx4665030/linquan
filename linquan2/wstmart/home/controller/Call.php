<?php
namespace wstmart\home\controller;
use wstmart\common\model\Orders as M;
/**
 * 调拨管理控制器
 */
use think\Db;
class Call extends Base{
	/**
    * 提交虚拟订单
    */
	public function quickSubmit(){
		$m = new M();
		$rs = $m->quickSubmit();
		return $rs;
	}
    /**
    * 提交订单
    */
	public function submit(){
		$m = new M();
		$rs = $m->submit();
		return $rs;
	}
	/**
	 * 订单提交成功
	 */
	public function succeed(){
		$m = new M();
		$rs = $m->getByUnique();
		$this->assign('object',$rs);
		if(!empty($rs['list'])){
			if($rs['payType']==1 && $rs['totalMoney']>0){
				$this->assign('orderNo',input("get.orderNo"));
				$this->assign('isBatch',(int)input("get.isBatch/d",1));
				$this->assign('rs',$rs);
				return $this->fetch('order_pay_step1');
			}else{
			    return $this->fetch('order_success');
			}
		}else{
			$this->assign('message','Sorry~您要找的页面丢失了。。。');
			return $this->fetch('error_msg');
		}
	}
	
	
	
	/**
	 * 用户-待付款订单
	 */
	public function waitPay(){
		return $this->fetch('users/orders/list_wait_pay');
	}
    /**
	 * 用户-获取待付款列表
	 */
    public function waitPayByPage(){
		$m = new M();
		$rs = $m->userOrdersByPage(-2);
		return WSTReturn("", 1,$rs);
	}
    /**
	 * 等待收货
	 */
	public function waitReceive(){
		return $this->fetch('users/orders/list_wait_receive');
	}
    /**
	 * 获取收货款列表
	 */
    public function waitReceiveByPage(){
		$m = new M();
		$rs = $m->userOrdersByPage([0,1]);
		return WSTReturn("", 1,$rs);
	}
	/**
	 * 用户-待评价
	 */
    public function waitAppraise(){
		return $this->fetch('users/orders/list_appraise');
	}
	/**
	 * 用户-待评价
	 */
	public function waitAppraiseByPage(){
		$m = new M();
		$rs = $m->userOrdersByPage(2,0);
		return WSTReturn("", 1,$rs);
	}
	/**
	 * 用户-已完成订单
	 */
    public function finish(){
		return $this->fetch('users/orders/list_finish');
	}
	/**
	 * 用户-已完成订单
	 */
	public function finishByPage(){
		$m = new M();
		$rs = $m->userOrdersByPage(2,-1);
		return WSTReturn("", 1,$rs);
	}
   /**
	 * 用户-加载取消订单页面
	 */
	public function toCancel(){
		return $this->fetch('users/orders/box_cancel');
	}

	/**
	 * 用户取消订单
	 */
	public function cancellation(){
		$m = new M();
		$rs = $m->cancel();
		return $rs;
	}
    /**
	 * 用户-取消订单列表
	 */
	public function cancel(){
		return $this->fetch('users/orders/list_cancel');
	}
	/**
	 * 用户-获取已取消订单
	 */
    public function cancelByPage(){
		$m = new M();
		$rs = $m->userOrdersByPage(-1);
		return WSTReturn("", 1,$rs);
	}
    /**
	 * 用户-拒收订单
	 */
	public function toReject(){
		return $this->fetch('users/orders/box_reject');
	}
	/**
	 * 用户拒收订单
	 */
	public function reject(){
		$m = new M();
		$rs = $m->reject();
		return $rs;
	}
	/**
	 * 用户-申请退款
	 */
	public function toRefund(){
		$m = new M();
		$rs = $m->getMoneyByOrder((int)input('id'));
		$this->assign('object',$rs);
		return $this->fetch('users/orders/box_refund');
	}

	/**
	 * 商家-操作退款
	 */
	public function toShopRefund(){
		$rs = model('OrderRefunds')->getRefundMoneyByOrder((int)input('id'));
		$this->assign('object',$rs);
		return $this->fetch('shops/orders/box_refund');
	}
	
	/**
	 * 用户-拒收/退款列表
	 */
	public function abnormal(){
		return $this->fetch('users/orders/list_abnormal');
	}
	/**
	 * 获取用户拒收/退款列表
	 */
    public function abnormalByPage(){
		$m = new M();
		$rs = $m->userOrdersByPage([-3,-4,-5]);
		return WSTReturn("", 1,$rs);
	}
	
	
	
    /**
	 * 等待处理订单
	 */
	public function waitDelivery(){
		$express = model('Express')->listQuery();
		$this->assign('express',$express);
		return $this->fetch('shops/call/list_wait_delivery');
	}
	/**
	 * 待发货调拨订单 xzx
	 */
	public function waitDeliveryByPage(){
		$shopId = (int)session('WST_USER.shopId');
		
		$where['g.call_shop_id'] = $shopId;
		$where['call_dataFlag'] = 1;
		$where['call_status'] = 1;
		$where['call_flags'] = 1;
		$order_call_list = db('call_goods')->alias('g')->join('call c','c.call_num=g.call_number')->where($where)->paginate(input('pagesize/d'))->toArray();
		$arr=array();
		//var_dump($order_call_list);
		foreach($order_call_list['Rows'] as $k=>$v){
			//判断调拨还是调入
			if($v['call_flags'] == 1){
				$call_start_info = db('roles')->where('roleId',$v['call_stock_id'])->field('roleName')->find();
				$arr['Rows'][$k]['start_name'] = $call_start_info['roleName'];   //发货仓
				if($v['call_stock_ids']){
					$call_end_info = db('roles')->where('roleId',$v['call_stock_ids'])->field('roleName')->find();
					$arr['Rows'][$k]['end_name'] = $call_end_info['roleName'];   //收货人
				}else{
					$call_end_info = db('shops')->where('shopId',$v['call_shop_id'])->field('shopName')->find();
					$arr['Rows'][$k]['end_name'] = $call_end_info['shopName'];   //收货人
				}
			}else if($v['call_flags'] == 2){
				
			}
			
			if($v['call_status'] == 1){
				$arr['Rows'][$k]['call_stats'] = '已调拨待发货';
			}else if($v['call_status'] == 2){
				$arr['Rows'][$k]['call_stats'] = '已调拨已发货';
			}else if($v['call_status'] == 3){
				$arr['Rows'][$k]['call_stats'] = '已调拨已收货';
			}
			$arr['Rows'][$k]['call_status'] = $v['call_status'];   //状态码
			$arr['Rows'][$k]['call_number'] = $v['call_number'];
			$arr['Rows'][$k]['call_select_time'] = $v['call_select_time'];
			$arr['Rows'][$k]['call_id'] = $v['call_goods_ids'];   //调拨商品表id
			
			//获取商品的规格
			$goods_info = db('supplier_goods_spec')->alias('s')->join('supplier_goods g','s.good_id=g.id','right')->where('s_huohao',$v['call_goods_huohao'])->where('id',$v['call_goods_id'])->select();
			if(count($goods_info)== 0){
				$goods_info = db('supplier_goods')->where('id',$v['call_goods_id'])->select();
			}
			$goods = array();
			
			foreach($goods_info as $k1=>$v1){
				if(empty($v1['spec_value'])){
					$goods[$k1]['spec'] = '无';
					$goods[$k1]['marketPrice'] = $v1['marketPrice'];   //进价
					$goods[$k1]['shopPrice'] = $v1['shopPrice'];   //门店价
				}else{
					$goods[$k1]['spec'] = $v1['spec_value'];
					$goods[$k1]['marketPrice'] = $v1['marketPrice'];   //进价
					$goods[$k1]['shopPrice'] = $v1['specPrice'];   //门店价
				}
				$goods[$k1]['goodsName'] = $v1['goodsName'];
				$goods[$k1]['goodsNum'] = $order_call_list['Rows'][$k]['call_goods_number'];
			}
			
			$arr['Rows'][$k]['list'] = $goods;
		}
		
		//var_dump($arr);die;
		return WSTReturn("", 1,$arr);
		//$m = new M();
		//$rs = $m->shopOrdersByPage([0]);
		//return WSTReturn("", 1,$rs);
	}

	/**
	* 商家-已发货订单
	*/
	public function delivered(){
		$express = model('Express')->listQuery();
		$this->assign('express',$express);
		return $this->fetch('shops/call/list_delivered');
	}
	/**
	 * 待处理订单
	 */
	public function deliveredByPage(){
		$shopId = (int)session('WST_USER.shopId');
		
		$where['g.call_shop_id'] = $shopId;
		$where['call_dataFlag'] = 1;
		$where['call_status'] = 2;
		$where['call_flags'] = 1;
		$order_call_list = db('call_goods')->alias('g')->join('call c','c.call_num=g.call_number')->where($where)->paginate(input('pagesize/d'))->toArray();
		$arr=array();
		foreach($order_call_list['Rows'] as $k=>$v){
			//判断调拨还是调入
			if($v['call_flags'] == 1){
				$call_start_info = db('roles')->where('roleId',$v['call_stock_id'])->field('roleName')->find();
				$arr['Rows'][$k]['start_name'] = $call_start_info['roleName'];   //发货仓
				if($v['call_stock_ids']){
					$call_end_info = db('roles')->where('roleId',$v['call_stock_ids'])->field('roleName')->find();
					$arr['Rows'][$k]['end_name'] = $call_end_info['roleName'];   //收货人
				}else{
					$call_end_info = db('shops')->where('shopId',$v['call_shop_id'])->field('shopName')->find();
					$arr['Rows'][$k]['end_name'] = $call_end_info['shopName'];   //收货人
				}
			}else if($v['call_flags'] == 2){
				
			}
			
			if($v['call_status'] == 1){
				$arr['Rows'][$k]['call_stats'] = '已调拨待发货';
			}else if($v['call_status'] == 2){
				$arr['Rows'][$k]['call_stats'] = '已调拨已发货';
			}else if($v['call_status'] == 3){
				$arr['Rows'][$k]['call_stats'] = '已调拨已收货';
			}
			$arr['Rows'][$k]['call_status'] = $v['call_status'];   //状态码
			$arr['Rows'][$k]['call_number'] = $v['call_number'];
			$arr['Rows'][$k]['call_select_time'] = $v['call_select_time'];
			$arr['Rows'][$k]['call_id'] = $v['call_goods_ids'];   //调拨商品表id
			
			//获取商品的规格
			$goods_info = db('supplier_goods_spec')->alias('s')->join('supplier_goods g','s.good_id=g.id','right')->where('s_huohao',$v['call_goods_huohao'])->where('id',$v['call_goods_id'])->select();
			//var_dump($goods_info);die;
			if(count($goods_info) == 0){
				$goods_info = db('supplier_goods')->where('id',$v['call_goods_id'])->select();
			}
			$goods = array();
			foreach($goods_info as $k1=>$v1){
				if(empty($v1['spec_value'])){
					$goods[$k1]['spec'] = '无';
					$goods[$k1]['marketPrice'] = $v1['marketPrice'];   //进价
					$goods[$k1]['shopPrice'] = $v1['shopPrice'];   //门店价
				}else{
					$goods[$k1]['spec'] = $v1['spec_value'];
					$goods[$k1]['marketPrice'] = $v1['marketPrice'];   //进价
					$goods[$k1]['shopPrice'] = $v1['specPrice'];   //门店价
				}
				$goods[$k1]['goodsName'] = $v1['goodsName'];
				$goods[$k1]['goodsNum'] = $order_call_list['Rows'][$k]['call_goods_number'];
			}
			
			$arr['Rows'][$k]['list'] = $goods;
		}
		
		//var_dump($arr);die;
		return WSTReturn("", 1,$arr);
		//$m = new M();
		//$rs = $m->shopOrdersByPage(1);
		//return WSTReturn("", 1,$rs);
	}

    /**
	 * 商家发货
	 */
	public function deliver(){
		$m = new M();
		$rs = $m->deliver();
		return $rs;
	}
	/**
	 * 用户收货
	 */
	public function receive(){
		$m = new M();
		$rs = $m->receive();
		return $rs;
	}
	/**
	 * 商家-已完成订单
	 */
    public function finished(){
		$express = model('Express')->listQuery();
		return $this->fetch('shops/call/list_finished');
	}
	/**
	 * 商家-已完成订单
	 */
	public function finishedByPage(){
		$shopId = (int)session('WST_USER.shopId');
		
		$where['g.call_shop_id'] = $shopId;
		$where['call_dataFlag'] = 1;
		$where['call_status'] = 3;
		$where['call_flags'] = 1;
		$order_call_list = db('call_goods')->alias('g')->join('call c','c.call_num=g.call_number')->where($where)->paginate(input('pagesize/d'))->toArray();
		$arr=array();
		foreach($order_call_list['Rows'] as $k=>$v){
			//判断调拨还是调入
			if($v['call_flags'] == 1){
				$call_start_info = db('roles')->where('roleId',$v['call_stock_id'])->field('roleName')->find();
				$arr['Rows'][$k]['start_name'] = $call_start_info['roleName'];   //发货仓
				if($v['call_stock_ids']){
					$call_end_info = db('roles')->where('roleId',$v['call_stock_ids'])->field('roleName')->find();
					$arr['Rows'][$k]['end_name'] = $call_end_info['roleName'];   //收货人
				}else{
					$call_end_info = db('shops')->where('shopId',$v['call_shop_id'])->field('shopName')->find();
					$arr['Rows'][$k]['end_name'] = $call_end_info['shopName'];   //收货人
				}
			}else if($v['call_flags'] == 2){
				
			}
			
			if($v['call_status'] == 1){
				$arr['Rows'][$k]['call_stats'] = '已调拨待发货';
			}else if($v['call_status'] == 2){
				$arr['Rows'][$k]['call_stats'] = '已调拨已发货';
			}else if($v['call_status'] == 3){
				$arr['Rows'][$k]['call_stats'] = '已调拨已收货';
			}
			$arr['Rows'][$k]['call_status'] = $v['call_status'];   //状态码
			$arr['Rows'][$k]['call_number'] = $v['call_number'];
			$arr['Rows'][$k]['call_select_time'] = $v['call_select_time'];
			$arr['Rows'][$k]['call_id'] = $v['call_goods_ids'];   //调拨商品表id
			
			//获取商品的规格
			$goods_info = db('supplier_goods_spec')->alias('s')->join('supplier_goods g','s.good_id=g.id','right')->where('s_huohao',$v['call_goods_huohao'])->where('id',$v['call_goods_id'])->select();
			if(count($goods_info) == 0){
				$goods_info = db('supplier_goods')->where('id',$v['call_goods_id'])->select();
			}
			$goods = array();
			foreach($goods_info as $k1=>$v1){
				if(empty($v1['spec_value'])){
					$goods[$k1]['spec'] = '无';
					$goods[$k1]['marketPrice'] = $v1['marketPrice'];   //进价
					$goods[$k1]['shopPrice'] = $v1['shopPrice'];   //门店价
				}else{
					$goods[$k1]['spec'] = $v1['spec_value'];
					$goods[$k1]['marketPrice'] = $v1['marketPrice'];   //进价
					$goods[$k1]['shopPrice'] = $v1['specPrice'];   //门店价
				}
				$goods[$k1]['goodsName'] = $v1['goodsName'];
				$goods[$k1]['goodsNum'] = $order_call_list['Rows'][$k]['call_goods_number'];
			}
			
			$arr['Rows'][$k]['list'] = $goods;
		}
		
		//var_dump($arr);die;
		return WSTReturn("", 1,$arr);
		//$m = new M();
		//$rs = $m->shopOrdersByPage(2);
		//return WSTReturn("", 1,$rs);
	}
    /**
	 * 商家-取消/拒收订单
	 */
    public function failure(){
		return $this->fetch('shops/orders/list_failure');
	}
	/**
	 * 商家-取消/拒收订单
	 */
	public function failureByPage(){
		$m = new M();
		$rs = $m->shopOrdersByPage([-1,-3,-4,-5]);
		return WSTReturn("", 1,$rs);
	}
	/**
	 * 获取订单信息方便修改价格
	 */
	public function getMoneyByOrder(){
		$m = new M();
		$rs = $m->getMoneyByOrder();
		return WSTReturn("", 1,$rs);
	}
	/**
	 * 商家修改订单价格
	 */
	public function editOrderMoney(){
		$m = new M();
		$rs = $m->editOrderMoney();
		return $rs;
	}
	/**
	 * 商家-调拨订单详情
	 */
	public function view(){
		$call_id = $_GET['id'];   //调拨商品表的id
		$shopId = (int)session('WST_USER.shopId');   //店铺id
		
		
		/* $m = new M();
		$rs = $m->getByView((int)input('id'));
		$this->assign('object',$rs); */
		return $this->fetch('shops/call/viewS');
	}
	/**
	 * 订单打印
	 */
	public function orderPrint(){
        $m = new M();
		$rs = $m->getByView((int)input('id'));
		$this->assign('object',$rs);
		return $this->fetch('shops/orders/print');
	}
	
	
	/*
	调拨管理的已发货的确认收货的功能  xzx
	
	*/
	public function receive_call(){
		$call_id = $_GET['id'];   //调拨商品表的id
		$shopId = (int)session('WST_USER.shopId');   //店铺id
		//查询调拨商品表的记录
		$where['call_goods_ids'] = $call_id;
		$where['call_shop_id'] = $shopId;
		$call_list = db('call_goods')->alias('c')->join('supplier_goods g','c.call_goods_id=g.id')->where($where)->find();
		
		//查询商品表该商品是否存在
		$where1['goodsName'] = $call_list['goodsName'];
		$where1['shopId'] = $shopId;
		$where1['goodsCatIdPath'] = $call_list['goodsCatIdPath'];
		$where1['dataFlag'] = 1;
		$goods_info = Db::name("goods")->where($where1)->find();
		//var_dump($goods_info);die;
		
		//查询调拨商品的规格
		$goods_spc = db('supplier_goods_spec')->where('good_id',$call_list['id'])->find();
		
		Db::startTrans();
        try{
            if(count($goods_info) > 0){    //商品已经存在,只是修改商品的库存
				$data['goodsStock'] = $call_list['call_goods_number'] +  $goods_info['goodsStock'];
				$goods_id = $goods_info['goodsId'];   //商品的id
				Db::name("goods")->where('goodsId',$goods_id)->update($data);
			}else{
				//插入商品表
				$data['goodsSn'] = $call_list['goodsSn'];
				$data['productNo'] = $call_list['productNo'];
				$data['goodsName'] = $call_list['goodsName'];
				$data['goodsImg'] = $call_list['goodsImg'];
				$data['shopId'] = $call_list['call_shop_id'];
				$data['marketPrice'] = $call_list['marketPrice'];
				$data['shopPrice'] = $call_list['shopPrice'];
				$data['warnStock'] = $call_list['warnStock'];
				$data['goodsStock'] = $call_list['call_goods_number'];
				$data['goodsUnit'] = $call_list['goodsUnit'];
				$data['goodsTips'] = $call_list['goodsDesc'];
				$data['isSale'] = 1;
				$data['isSpec'] = 1;
				$data['goodsCatIdPath'] = $call_list['goodsCatIdPath'];
				$data['goodsStatus'] = 1;
				$data['dataFlag'] = 1;
				$data['createTime'] = date('Y-m-d H:i:s',time());
				$data['is_transfer'] = 1;
				//$data['transfer_id'] = $call_id;
				$goods_id = db('goods')->insertGetId($data);   //新添商品的id
			}
			
			//var_dump($goods_id);
			
			$dat['call_status'] = 3;
			$dat['call_do_goodsid'] = $goods_id;
			$results = db('call_goods')->where('call_goods_ids',$call_id)->update($dat);
			
			$spc_id = $goods_spc['spec_id'];
			$spec_value = "";
			if(is_null($spc_id)){   //没有产品规格的只是修改商品表的库存
				
			}else{
				$spc_id_arr = explode(',',$spc_id);
				$spc_value_arr = explode(',',$goods_spc['spec_value']);
				$count = count($spc_value_arr)-1;
				for($i = 0;$i<$count;$i++){
					if($spc_value_arr[$i] != ''){
						$where2['catId'] = $spc_id_arr[$i];
						$where2['itemName'] = $spc_value_arr[$i];
						$spec_list = Db::name("spec_items")->where($where2)->find();
						if(count($spec_list) == 0){    //产品的规格不存在
							$cons['shopId'] = $call_list['call_shop_id'];
							$cons['catId'] = $spc_id_arr[$i];
							$cons['goodsId'] = $goods_id;
							$cons['itemName'] = $spc_value_arr[$i];
							$cons['dataFlag'] = 1;
							$cons['createTime'] = date('Y-m-d H:i:s',time());
							$spec_add_id = db('spec_items')->insertGetId($cons);
							if($i == ($count-1)){
								$spec_value = $spec_value.$spec_add_id;
							}else{
								$spec_value = $spec_value.$spec_add_id.':';
							}
						}else{   //产品的规格存在
							
							if($i == ($count-1)){
								$spec_value = $spec_value.$spec_list['itemId'];
							}else{
								$spec_value = $spec_value.$spec_list['itemId'].':';
							}
							
						}
											
					}
				}
				
				//先查询有没有产品规格，存在就是修改该产品规格的库存量
				$where3['specIds'] = $spec_value;
				$where3['shopId'] = $call_list['call_shop_id'];
				$where3['goodsId'] = $goods_id;
				$specs_arr = Db::name("goods_specs")->where($where3)->find();
				if(count($specs_arr) > 0){
					$map['specStock'] = $specs_arr['specStock'] + $call_list['call_goods_number'];
					Db::name('goods_specs')->where('id',$specs_arr['id'])->update($map);
				}else{
					$data1['shopId'] = $call_list['call_shop_id'];
					$data1['goodsId'] = $goods_id;
					$data1['productNo'] = $call_list['productNo'];
					$data1['specIds'] = $spec_value ;
					$data1['marketPrice'] = $call_list['marketPrice'];
					$data1['specPrice'] = $call_list['shopPrice'];
					$data1['specStock'] = $call_list['call_goods_number'];
					$data1['isDefault'] = 1;
					$data1['dataFlag'] = 1;
					$result = db('goods_specs')->insert($data1);
				}
						
			}
            // 提交事务
            echo 'success';
            Db::commit();                         

        } catch (\Exception $e) {
            // 回滚事务
            echo 'error';
            Db::rollback();

        }
		
	}
	
	
    /**
	 * 用户-订单详情
	 */
	public function detail(){
		$m = new M();
		$rs = $m->getByView((int)input('id'));
		$this->assign('object',$rs);
		return $this->fetch('users/orders/view');
	}
	
   /**
	* 用户-评价页
	*/
	public function orderAppraise(){
		$m = new M();
		//根据订单id获取 商品信息跟商品评价
		$data = $m->getOrderInfoAndAppr();
		$this->assign(['data'=>$data['Rows'],
					   'count'=>$data['count'],
					   'alreadys'=>$data['alreadys']
						]);
		return $this->fetch('users/orders/list_order_appraise');
	}
	/**
	* 设置完成评价
	*/
	public function complateAppraise($orderId){
		$m = new M();
		return $m->complateAppraise($orderId);
	}
	/**
	 * 商家-待付款订单
	 */
	public function waituserPay(){
		return $this->fetch('shops/orders/list_wait_pay');
	}
	/**
	 * 商家-获取待付款列表
	 */
	public function waituserPayByPage(){
		$m = new M();
		$rs = $m->shopOrdersByPage(-2);
		return WSTReturn("", 1,$rs);
	}
	/**
	 * 导出订单
	 */
	public function toExport(){
		$m = new M();
		$rs = $m->toExport();
		$this->assign('rs',$rs);
	}
}
