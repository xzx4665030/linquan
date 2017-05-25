<?php
namespace wstmart\shop\controller;
use wstmart\shop\model\Banks as M;
/**
 * 卖家端内容app控制器
 */
use think\Session;
use think\Db;
class Index extends Base{
	public $shop_id;   //店铺id
	public function __construct()
    {
        if($_GET['token']){
			$token = $_GET['token']; 
		}else{
			$token = $_POST['token']; 
		} 
		if(!$token){
            $datas['result'] = false;
            $datas['resultString'] = "请先登录";
			echo header('Content-type: application/json;charset=utf-8');
            echo json_encode($datas);die;
        }
		//$this->shop_id = $this->authcode($token,'DECODE',LINQUAN_KEY,0);
		$this->shop_id = base64_decode($token);
		//判断店铺是否正常经营
		$is_open = $this->is_open($this->shop_id);
		if(!$is_open['result']){
			echo header('Content-type: application/json;charset=utf-8');
			echo json_encode($is_open);die;
		}

		return $this->shop_id;
    }
	
	//店铺工作台  统计订单数据
	public function index(){		
		$shop_id = $this->shop_id;
		$time = date("Y-m-d",time());
		$s = strtotime(date("Y-m-d"));
		$e = strtotime(date("Y-m-d",strtotime("+1 day")));
		
		//今日订单数
		$today_order_num = db('orders')->where('createTime','>= time',$s)->where('createTime','<= time',$e)->where('orderStatus','>',0)->where('dataFlag',1)->where('shopId',$shop_id)->count();
		
		//今日成交金额
		$today_order_sum = db('orders')->where('createTime','>= time',$s)->where('createTime','<= time',$e)->where('orderStatus','>',0)->where('dataFlag',1)->where('shopId',$shop_id)->sum('realTotalMoney');
		
		//历史订单数
		$history_order_num = db('orders')->where('orderStatus','>',0)->where('dataFlag',1)->where('shopId',$shop_id)->count();
		
		//出售中商品
		$sale_goods_num = db('goods')->where('isSale',1)->where('shopId',$shop_id)->count();
		
		//代付款
		$hold_order_num = db('orders')->where('orderStatus','=',-2)->where('dataFlag',1)->where('shopId',$shop_id)->count();
		
		//退货中
		$return_order_num = db('orders')->where('isRefund','=',1)->where('dataFlag',1)->where('shopId',$shop_id)->count();
		
		$arr['today_order_num'] = (is_null($today_order_num))?0:$today_order_num;
		$arr['today_order_sum'] = (is_null($today_order_sum))?0:$today_order_sum;
		$arr['history_order_num'] = (is_null($history_order_num))?0:$history_order_num;
		$arr['sale_goods_num'] = (is_null($sale_goods_num))?0:$sale_goods_num;
		$arr['hold_order_num'] = (is_null($hold_order_num))?0:$hold_order_num;
		$arr['return_order_num'] = (is_null($return_order_num))?0:$return_order_num;
		$datas['data'] = $arr;
		$datas['result'] = true;
		$datas['resultString'] = "统计数据";
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
	}
	
	
	
	/*
	各种订单数详情
	token :  获取店铺id
	page:分页
	type: 1.今日订单数详情   2.历史订单数详情  3.代付款订单详情
	*/   
	public function today_order_list(){
		$shop_id = $this->shop_id;
		$time = date("Y-m-d",time());
		
		if($_GET['page'] > 0){
			 $page = (int)$_GET['page']; 
			 $start = $page == 1 ? 0 : ($page-1)*5;
			 $end = 5;
		}
		
		$type = $_GET['type'];
		if($type == 1){
			$where['createTime'] = array('egt',$time);
			$where['orderStatus'] = array('egt',0);
			$where['dataFlag'] = 1;
			$where['shopId'] = $shop_id;
		}else if($type == 2){
			$where['orderStatus'] = 2;
			$where['isAppraise'] = 1;
			$where['shopId'] = $shop_id;
			$where['dataFlag'] = 1;
		}else if($type == 3){
			$where['orderStatus'] = -2;
			$where['shopId'] = $shop_id;
			$where['dataFlag'] = 1;
		}
		$today_orders = db('orders')->where($where)->limit($start.','.$end)->select();
		//$today_orders = db('orders')->where('createTime','>= time',$time)->where('orderStatus','>=',0)->where('dataFlag',1)->where('shopId',$shop_id)->limit($start.','.$end)->select();
		//var_dump($today_orders);
		$new_list = array();
		foreach($today_orders as $k => $v){
			//查询用户信息
			$where1['userId'] = $v['userId'];
			$user_info = db("users")->where($where1)->find();
			$new_list[$k]['userName'] = $user_info['loginName'];
			
			//查询商品信息
			$where2['orderId'] = $v['orderId'];	
			$good_info = db("order_goods")->alias("o")->join("goods g","o.goodsId=g.goodsId")->where($where2)->field('o.goodsName,o.goodsNum,o.goodsPrice,g.goodsTips,o.goodsImg')->select();
			//var_dump($good_info);
			foreach($good_info as $key=>$val){
				$good_info[$key]['goodsImg'] = LINQUAN_IMG.$val['goodsImg'];
			}
			$new_list[$k]['orderInfo'] = $good_info;
			
			//其他信息
			$new_list[$k]['createTime'] = $v['createTime'];
			$new_list[$k]['sum'] = $v['realTotalMoney'];
			$new_list[$k]['orderNo'] = $v['orderNo'];
			$new_list[$k]['deliverMoney'] = (is_null($v['deliverMoney']))?0:$v['deliverMoney']; //运费			
			$new_list[$k]['orderStatus'] = $this->orderStatus($v['orderStatus'],$v['isAppraise'],$v['isRefund']);  //订单状态
			$new_list[$k]['orderId'] = $v['orderId'];
		}
		
		$new_list = is_null($today_orders)?$new_list = array():$new_list;   //判断空数组
		$datas['data'] = $new_list;
		$datas['result'] = true;
		$datas['resultString'] = "订单数详情";
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
	}
	
	
	
	/*
	某个（未支付/历史/发货）具体订单详情接口
	type: 1.今日订单具体详情 2.历史订单具体详情 3.未付款具体订单详情
	*/
	public function order_info(){
		$shop_id = $this->shop_id;
		$orderId = $_GET['orderId'];
		$type = $_GET['type'];
		
		$orders = db('orders')->where('orderId',$orderId)->where('shopId',$shop_id)->find();
		$new_list = array();
		
		//查询用户信息
		$where1['userId'] = $orders['userId'];
		$user_info = db("users")->where($where1)->find();  
		$new_list['userName'] = $user_info['loginName'];
		
		//查询商品信息
		$where2['orderId'] = $orders['orderId'];			
		$good_info = db("order_goods")->alias("o")->join("goods g","o.goodsId=g.goodsId")->where($where2)->field('o.goodsName,o.goodsNum,o.goodsPrice,g.goodsTips,o.goodsImg')->select();
		foreach($good_info as $key=>$val){
			$good_info[$key]['goodsImg'] = LINQUAN_IMG.$val['goodsImg'];
		}
		$new_list['orderInfo'] = $good_info;
		
		
		//其他信息
		$new_list['createTime'] = $orders['createTime'];
		$new_list['sum'] = $orders['realTotalMoney'];
		$new_list['orderNo'] = $orders['orderNo'];
		$new_list['deliverMoney'] = (is_null($orders['deliverMoney']))?0:$orders['deliverMoney']; //运费			
		$new_list['orderStatus'] = $this->orderStatus($orders['orderStatus'],$orders['isAppraise'],$orders['isRefund']);  //订单状态
		$new_list['orderId'] = $orders['orderId'];
		$new_list['userAddress'] = $orders['userAddress'];
		$new_list['userPhone'] = $orders['userPhone'];
		
		
		$new_list = is_null($orders)?$new_list = array():$new_list;   //判断空数组
		$datas['data'] = $new_list;
		$datas['result'] = true;
		$datas['resultString'] = "某个订单具体信息";
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
	}
	
	//订单发货
	public function send(){
		$shop_id = $this->shop_id;
		$orderId = $_GET['orderId'];
		
		$order_info = db("orders")->where('orderId',$orderId)->field('orderNo,userName,userAddress,userPhone,orderId,createTime')->find();
		
		//物流信息
		$express = db('express')->where('dataFlag',1)->field('expressId,expressName')->select();
		
		$arr['orderInfo'] = is_null($order_info)?$order_info = array():$order_info;   //判断空数组
		$arr['express'] = is_null($express)?$express = array():$express;   //判断空数组
		$datas['data'] = $arr;
		$datas['result'] = true;
		$datas['resultString'] = "订单发货";
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
	}
	
	
	//处理订单发货
	public function do_send(){
		$shop_id = $this->shop_id;
		$orderId = $_GET['orderId'];
		$expressId = $_GET['expressId'];
		$expressNo = $_GET['expressNo'];
		
		$data['expressId'] = $expressId;
		$data['expressNo'] = $expressNo;
		$data['orderStatus'] = 1;
		$data['deliveryTime'] = date('Y-m-d H:i:s',time());
		$result = db('orders')->where('orderId',$orderId)->update($data);
		if($result !== false){
			$datas['result'] = true;
			$datas['resultString'] = "发货成功";
		}else{
			$datas['result'] = false;
			$datas['resultString'] = "发货失败";
		}
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
	}
	
	
	/*
	出售中列表
	is_warn: 0 没有超出警示值；1：超出警示值
	*/
	public function sale_list(){
		$shop_id = $this->shop_id;
		$where['shopId'] = $shop_id;
		$where['dataFlag'] = 1;
		$where['goodsStatus'] = 1;
		$where['isSale'] = 1;
		
		if($_GET['page'] > 0){
			 $page = (int)$_GET['page']; 
			 $start = $page == 1 ? 0 : ($page-1)*5;
			 $end = 5;
		}
		
		//计算出售的商品总数
		$sum = db('goods')->where($where)->count();
		
		//根据最后商品的最后一个分类id进行相同归组，键值为分类的类名
		$goods_list = db('goods')->where($where)->limit($start.','.$end)->select();
		$result= array();
		foreach ($goods_list as $key => $info) {
			$cats_name = db('goods_cats')->where('catId',$info['goodsCatId'])->field('catName,catId')->find();
			//判断商品的库存是否已经是需要补货状态。isSpec是否为0,0：没有设置规格（只要判断商品总库存是否大于警示库存）；1：设置有规格（判断商品规格的库存是否大于警示库存）
			if($info['isSpec'] == 1){
				$goods_spec = db('goods_specs')->where('dataFlag',1)->where('goodsId',$info['goodsId'])->field('specStock,warnStock')->find();
				if($goods_spec['specStock'] > $goods_spec['warnStock']){
					$info['is_warn'] = 0;
				}else{
					$info['is_warn'] = 1;
				}
			}else if($info['isSpec'] == 0){
				if($info['goodsStock'] > $info['warnStock']){
					$info['is_warn'] = 0;
				}else{
					$info['is_warn'] = 1;
				}
			}
			$new_arr['is_warn'] = $info['is_warn'];
			$new_arr['goodsName'] = $info['goodsName'];
			$new_arr['goodsTips'] = $info['goodsTips'];
			$new_arr['shopPrice'] = $info['shopPrice'];
			$new_arr['goodsStock'] = $info['goodsStock'];
			$new_arr['goodsImg'] = LINQUAN_IMG.$info['goodsImg'];
			$new_arr['catName'] = $cats_name['catName'];
			$new_arr['catId'] = $cats_name['catId'];
			$result[] = $new_arr;
		}
		
		
		//去重获取不相同的分类名作为新数组
		foreach($result as $k=>$v){
            if(!isset($item[$v['catId']])){
				$arrs[$v['catId']][] = $v['catName'];
				$item[$v['catId']][] = $v;
            }else{
				$item[$v['catId']][] = $v;
            }
        }
		
		
		foreach($arrs as $k1=>$v1){
			foreach($item as $k2=>$v2){
				if($k1 == $k2){
					$news[$k1]['name'] = $v1;
					$news[$k1]['list'] = $v2;

				}
			}
		}
		//var_dump($news);die;
		$news = array_values($news);

		
		$dat['list'] = is_null($news)?$news = array():$news;   //判断空数组
		$dat['num'] = is_null($sum)?0:$sum;
		
		$datas['result'] = true;
		$datas['resultString'] = '出售中商品列表';
		$datas['data'] = $dat;
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;		
		
	}
	
	
	
	
	/*
	今日成交额（今日收入）
	page:页数
	*/
	public function today_income(){
		$shop_id = $this->shop_id;
		$s = date("Y-m-d");
		$e = date("Y-m-d",strtotime("+1 day"));
		
		if($_GET['page'] > 0){
			 $page = (int)$_GET['page']; 
			 $start = $page == 1 ? 0 : ($page-1)*5;
			 $end = 5;
		}
		
		$where['dataFlag'] = 1;
		$where['createTime'] = array('between',array($s,$e));
		$where['shopId'] = $shop_id;
		$where['orderStatus'] = array('egt',0);
		$today_list = db('orders')->alias('o')->join('order_goods g','o.orderId=g.orderId')->where($where)->limit($start.','.$end)->select();
		$new_list = array();
		foreach($today_list as $k => $v){
			//买家信息
			$buy_info = db('users')->where('userId',$v['userId'])->find();
			$new_list[$k]['loginName'] = $buy_info['loginName'];
			
			$new_list[$k]['goodsName'] = $v['goodsName'];
			$new_list[$k]['goodsNum'] = $v['goodsNum'];
			$new_list[$k]['realTotalMoney'] = $v['realTotalMoney'];
			$new_list[$k]['createTime'] = $v['createTime'];
					
		}
		
		//今日总收益和总收益
		$where1['dataFlag'] = 1;
		$where1['createTime'] = array('between',array($s,$e));
		$where1['shopId'] = $shop_id;
		$where1['orderStatus'] = array('egt',0);
		$today_income = db('orders')->alias('o')->join('order_goods g','o.orderId=g.orderId')->where($where1)->sum('realTotalMoney');
		
		$where2['dataFlag'] = 1;
		$where2['shopId'] = $shop_id;
		$where2['orderStatus'] = array('egt',0);
		$sum_income = db('orders')->alias('o')->join('order_goods g','o.orderId=g.orderId')->where($where2)->sum('realTotalMoney');
		
		$dat['list'] = is_null($new_list)?$new_list = array():$new_list;   //判断空数组
		$dat['today_income'] = is_null($today_income)?0:$today_income;
		$dat['sum_income'] = is_null($sum_income)?0:$sum_income;
		
		$datas['result'] = true;
		$datas['resultString'] = "今日收入数据";
		$datas['data'] = $dat;
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
		
	}
	
	
	/*
	今日成交额（历史收入）
	page:页数
	*/
	public function history_income(){
		$shop_id = $this->shop_id;
		if($_GET['time']){
			$s = $_GET['time'];
			$e = date("Y-m-d",strtotime($_GET['time']."+1 day"));
			$where['createTime'] = array('between',array($s,$e));
		}
		
		
		if($_GET['page'] > 0){
			 $page = (int)$_GET['page']; 
			 $start = $page == 1 ? 0 : ($page-1)*5;
			 $end = 5;
		}
		
		$where['dataFlag'] = 1;		
		$where['shopId'] = $shop_id;
		$where['orderStatus'] = 2;
		$today_list = db('orders')->alias('o')->join('order_goods g','o.orderId=g.orderId')->where($where)->limit($start.','.$end)->select();
		$new_list = array();
		foreach($today_list as $k => $v){
			//买家信息
			$buy_info = db('users')->where('userId',$v['userId'])->find();
			$new_list[$k]['loginName'] = $buy_info['loginName'];
			
			$new_list[$k]['goodsName'] = $v['goodsName'];
			$new_list[$k]['goodsNum'] = $v['goodsNum'];
			$new_list[$k]['realTotalMoney'] = $v['realTotalMoney'];
			$new_list[$k]['createTime'] = $v['createTime'];
					
		}
		
		//今日总收益和总收益
		$where1['dataFlag'] = 1;
		$where1['createTime'] = array('between',array($s,$e));
		$where1['shopId'] = $shop_id;
		$where1['orderStatus'] = array('egt',0);
		$today_income = db('orders')->alias('o')->join('order_goods g','o.orderId=g.orderId')->where($where1)->sum('realTotalMoney');
		
		$where2['dataFlag'] = 1;
		$where2['shopId'] = $shop_id;
		$where2['orderStatus'] = array('egt',0);
		$sum_income = db('orders')->alias('o')->join('order_goods g','o.orderId=g.orderId')->where($where2)->sum('realTotalMoney');
		
		$dat['list'] = is_null($new_list)?$new_list = array():$new_list;   //判断空数组
		$dat['today_income'] = is_null($today_income)?0:$today_income;
		$dat['sum_income'] = is_null($sum_income)?0:$sum_income;
		
		$datas['result'] = true;
		$datas['resultString'] = "历史收入数据";
		$datas['data'] = $dat;
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
		
	}
	
	
	
	
	//评论管理列表
	public function order_value_list(){
		$shop_id = $this->shop_id;
		$where['o.shopId'] = $shop_id;
		$where['o.dataFlag'] = 1;
		$where['o.isAppraise'] = 1;
		
		
		if($_GET['page'] > 0){
			 $page = (int)$_GET['page']; 
			 $start = $page == 1 ? 0 : ($page-1)*5;
			 $end = 5;
		}
		
		//计算评论管理的数目
		$sum_num = db('orders')->alias('o')->where($where)->count();
		$list = db('orders')->alias('o')->join('order_goods og','o.orderId=og.orderId')->join('goods_appraises ga','ga.orderId=o.orderId')->where($where)->select();
		$list = $this->array_multi_unique($list, array('goodsId'));
		
		$arr = array();
		foreach($list as $k=>$v){
			$arr[$k]['createTime'] = $v['createTime']; 
			$arr[$k]['orderNo'] = $v['orderNo'];
			$arr[$k]['goodsImg'] = LINQUAN_IMG.$v['goodsImg'];
			$arr[$k]['goodsName'] = $v['goodsName'];
			$arr[$k]['goodsNum'] = $v['goodsNum'];
			$arr[$k]['goodsPrice'] = $v['goodsPrice'];
			$arr[$k]['goodsScore'] = $v['goodsScore'];
			$arr[$k]['content'] = $v['content'];
			$arr[$k]['orderId'] = $v['orderId'];
			$arr[$k]['goodsId'] = $v['goodsId'];
			
			$user_info = db('users')->where('userId',$v['userId'])->field('loginName')->find();
			$arr[$k]['loginName'] = $user_info['loginName'];
		}     
        $item = array_slice($arr,$start,$end);   //处理分页
        
		$new_arr['list'] = is_null($item)?$arr = array():$item;   //判断空数组
		$new_arr['num'] = is_null($sum_num)?0:$sum_num;
		$datas['result'] = true;
		$datas['resultString'] = "评论管理列表";
		$datas['data'] = $new_arr;
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
	}
	
	//去重
	public function array_multi_unique($ar, $filter=array()) { 
		if(!empty($filter)) {
			$_v = array_fill_keys($filter, ' ');
			$_ar = array();
			foreach($ar as $k => $v) {
				$_ar[$k] = array_intersect_key($v, $_v);
			}
		} else {
			$_ar = $ar;
		}
	 
		$_ar = array_map('serialize', $_ar);
		$_ar = array_unique($_ar);
		$_ar = array_map('unserialize', $_ar);
	 
		if(!empty($filter)) {       
			return array_intersect_key($ar, $_ar);
		} else {
			return $_ar;
		}
	}
		
	
	//点击某个商品的更多评价
	public function more_list(){
		$shop_id = $this->shop_id;
		$goodsId = $_GET['goodsId'];
		$where['o.shopId'] = $shop_id;
		$where['o.dataFlag'] = 1;
		$where['o.isAppraise'] = 1;
		$where['og.goodsId'] = $goodsId;
		
		if($_GET['page'] > 0){
			 $page = (int)$_GET['page']; 
			 $start = $page == 1 ? 0 : ($page-1)*5;
			 $end = 5;
		}
		$list = db('orders')->alias('o')->join('order_goods og','o.orderId=og.orderId')->join('goods_appraises ga','ga.orderId=o.orderId')->where($where)->limit($start.','.$end)->select();
		$arr = array();
		foreach($list as $k=>$v){
			$arr[$k]['createTime'] = $v['createTime']; 
			$arr[$k]['orderNo'] = $v['orderNo'];
			$arr[$k]['goodsImg'] = LINQUAN_IMG.$v['goodsImg'];
			$arr[$k]['goodsName'] = $v['goodsName'];
			$arr[$k]['goodsNum'] = $v['goodsNum'];
			$arr[$k]['goodsPrice'] = $v['goodsPrice'];
			$arr[$k]['goodsScore'] = $v['goodsScore'];
			$arr[$k]['content'] = $v['content'];
			$arr[$k]['orderId'] = $v['orderId'];
			$arr[$k]['goodsId'] = $v['goodsId'];
			
			$user_info = db('users')->where('userId',$v['userId'])->field('loginName')->find();
			$arr[$k]['loginName'] = $user_info['loginName'];
		} 
		$new_arr['list'] = is_null($arr)?$arr = array():$arr;   //判断空数组
		$datas['result'] = true;
		$datas['resultString'] = "评论管理更多评价";
		$datas['data'] = $new_arr;
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
		
	}
	
	
	//回复某个已评价订单的页面
	public function replay_value(){
		$shop_id = $this->shop_id;
		$orderId = $_GET['orderId'];
		$where['o.shopId'] = $shop_id;
		$where['o.orderId'] = $orderId;
		$where['o.dataFlag'] = 1;
		$where['o.isAppraise'] = 1;
		
		//计算评论管理的数目
		$sum_num = db('orders')->alias('o')->where($where)->count();
		$list = db('orders')->alias('o')->join('order_goods og','o.orderId=og.orderId')->join('goods_appraises ga','ga.orderId=o.orderId')->where($where)->find();
		$arr = array();
		
		$arr['createTime'] = $list['createTime']; 
		$arr['orderNo'] = $list['orderNo'];
		$arr['goodsImg'] = LINQUAN_IMG.$list['goodsImg'];
		$arr['goodsName'] = $list['goodsName'];
		$arr['goodsNum'] = $list['goodsNum'];
		$arr['goodsPrice'] = $list['goodsPrice'];
		$arr['goodsScore'] = $list['goodsScore'];
		$arr['content'] = $list['content'];
		$arr['orderId'] = $list['orderId'];
		
		$user_info = db('users')->where('userId',$list['userId'])->field('loginName')->find();
		$arr['loginName'] = $user_info['loginName'];
		$new_arr['list'] = is_null($arr)?$arr = array():$arr;   //判断空数组
		$new_arr['num'] = is_null($sum_num)?0:$sum_num;
		$datas['result'] = true;
		$datas['resultString'] = "商家回复评论";
		$datas['data'] = $new_arr;
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
		
	}
	
	
	//处理卖家回复评论
	public function do_replay_value(){
		$shop_id = $this->shop_id;
		$orderId = $_GET['orderId'];
		$content = $_GET['content'];
		
		$where['shopId'] = $shop_id;
		$where['orderId'] = $orderId;
		$data['replyTime'] = date('Y-m-d H:i:s',$time());
		$data['shopReply'] = $content;
		$res = db('goods_appraises')->where($where)->update($data);
		if($res){
			$datas['result'] = true;
			$datas['resultString'] = "回复成功";
		}else{
			$datas['result'] = false;
			$datas['resultString'] = "回复失败";
		}
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
	}
	
	
	
	
	
}
