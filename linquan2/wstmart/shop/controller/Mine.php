<?php
namespace wstmart\shop\controller;
use wstmart\common\model\CashDraws as M;
/**
 * 卖家端内容app控制器
 */
use think\Session;
use think\Db;
use think\Cookie;
class Mine extends Base{
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
	
	//店铺（设置的页面）
	public function shop_seting(){
		$shop_id = $this->shop_id;
		
		//今日订单数
		$s = date("Y-m-d");
		$e = date("Y-m-d",strtotime("+1 day"));
		$where['dataFlag'] = 1;
		$where['shopId'] = $shop_id;
		$where['createTime'] = array('between',array($s,$e));
		$order_num = db('orders')->where($where)->count();
		
		//今日成交额(实际支付金额)
		$order_income = db('orders')->where($where)->sum('realTotalMoney');
		
		//待发货订单数(所有)
		$map['dataFlag'] = 1;
		$map['orderStatus'] = 0;
		$map['shopId'] = $shop_id;
		$wait_num = db('orders')->where($map)->count();
		
		//店铺信息
		$cons['shopId'] = $shop_id;
		$shop_info = db('shops')->where($cons)->field('shopName,shopImg')->find();
		$shop_info['shopImg'] = LINQUAN_IMG.$shop_info['shopImg'];
		
		$dat['shop_info'] = is_null($shop_info)?$shop_info = array():$shop_info;   //判断空数组
		$dat['order_num'] = is_null($order_num)?0:$order_num;
		$dat['order_income'] = is_null($order_income)?0:$order_income;
		$dat['wait_num'] = is_null($wait_num)?0:$wait_num;
		$datas['result'] = true;
		$datas['resultString'] = "数据";
		$datas['data'] = $dat;
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
		
	}
	
	
	/*
	添加优惠券/满减送/红包   post
	type: 1:优惠券；2：满减送；3：红包
	
	*/
	public function add_promotion(){
		$shop_id = $this->shop_id;
		
		$type = $_POST['type'];
		if($type != 3){
			$consume = $_POST['consume'];
			$data['discount_consume'] = $consume;
		}		
		$start_time = $_POST['start_time'];
		$end_time = $_POST['end_time'];
		$name = $_POST['name'];
		$num = $_POST['num'];		
		$value = $_POST['value'];
		
		
		//上传图片
		$file = request()->file('img');   //img是name名
	    
		$info = $file->move('./upload/promotion');       
        $arr =  $info->getSaveName();    //获取图像保存路径
		$arr=explode('\\', $arr);
		
		$data['discount_shopId'] = $shop_id;
		$data['discount_img'] = empty($arr[0])?'':'upload/promotion/'.$arr[0].'/'.$arr[1]; 
        $data['discount_startDate'] = strtotime($start_time);
		$data['discount_endDate'] = strtotime($end_time);
		$data['discount_name'] = $name;
		$data['discount_num'] = $num;
		$data['discount_value'] = $value;
		$data['discount_flag'] = $type;
		$data['discount_add_time'] = time();
		$data['discount_delete'] = 1;
		$res = db('discount')->insert($data);
		if($res){
			$datas['result'] = true;
			$datas['resultString'] = "添加成功";
		}else{
			$datas['result'] = false;
			$datas['resultString'] = "添加失败";
		}
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
	
	}
	
	
	
	/*
	优惠券/满减送/红包  列表
	*/
	public function promotion_list(){
		$shop_id = $this->shop_id;
		$where['discount_shopId'] = $shop_id;
		$where['discount_delete'] = 1;
		if($_GET['page'] > 0){
			 $page = (int)$_GET['page']; 
			 $start = $page == 1 ? 0 : ($page-1)*5;
			 $end = 5;
		}
				
		$list = db('discount')->where($where)->order('discount_id desc')->limit($start.','.$end)->select();
		$arr = array();
		foreach($list as $k => $v){
			$arr[$k]['discount_id'] = $v['discount_id'];
			$arr[$k]['discount_endDate'] = date("Y-m-d",$v['discount_endDate']);
			$arr[$k]['discount_name'] = $v['discount_name'];
			$arr[$k]['discount_num'] = $v['discount_num'];
			$arr[$k]['discount_consume'] = empty($v['discount_consume'])?0:$v['discount_consume'];
			$arr[$k]['discount_value'] = $v['discount_value'];
			if($v['discount_flag'] == 1){
				$arr[$k]['type'] = "优惠券";
			}else if($v['discount_flag'] == 2){
				$arr[$k]['type'] = "满减送";
			}else if($v['discount_flag'] == 3){
				$arr[$k]['type'] = "红包";
			}
		}
		
		$type_num = db('discount')->where($where)->count();;//种类个数
		$dat['num'] = is_null($type_num)?0:$type_num;
		$dat['list'] = is_null($arr)?$arr = array():$arr;   //判断空数组
		$datas['data'] = $dat;
		$datas['result'] = true;
		$datas['resultString'] = '优惠券列表';
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
		
	}
	
	
	/*
	删除优惠券
	discount_id：优惠券id
	*/
	public function del_promotion(){
		$shop_id = $this->shop_id;
		$discount_id = $_GET['discount_id'];
		
		$where['discount_id'] = $discount_id;
		$data['discount_delete'] = 2;
		$res = db('discount')->where($where)->update($data);
		if($res){
			$datas['result'] = true;
			$datas['resultString'] = '删除成功';
		}else{
			$datas['result'] = false;
			$datas['resultString'] = '删除失败';
		}
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
	}
	
	/*
	添加商家端提现的支付宝和微信接口
	type:0.支付宝；1：微信
	*/
	public function add_bind_other(){
		$shop_id = $this->shop_id;
		$type = $_GET['type'];
		
		$name = $_GET['name'];
		$tel = $_GET['tel'];
		$card = $_GET['card'];
		$number = $_GET['number'];
		if($type == 0){
			$data['o_alipay_num'] = $number;
		}else if($type == 1){
			$data['o_wx_num'] = $number;
		}
		$data['o_shopId'] = $shop_id;
		$data['o_name'] = $name;
		$data['o_mobile'] = $tel;
		$data['o_card'] = $card;
		$data['o_addtime'] = time();
		$data['o_delete'] = 0;
		
		$rs = db('bind_other')->insert($data);
		if($rs){
			$datas['result'] = true;
			$datas['resultString'] = '添加账号成功';
		}else{
			$datas['result'] = false;
			$datas['resultString'] = '添加账号失败';
		}
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
	}
	
	//获取银行卡信息接口
	public function bank_list(){
		$shop_id = $this->shop_id;
		
		$list = db('banks')->where('dataFlag',1)->field('bankId,bankName')->select();
		$datas['result'] = true;
		$datas['resultString'] = "银行卡列表信息";
		$datas['data'] = is_null($list)?$list = array():$list;   //判断空数组
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
	}
	
	/*
	添加商家端提现的银行卡账号接口
	*/
	public function add_bind_card(){
		$shop_id = $this->shop_id;
		
		$name = $_GET['name'];
		$tel = $_GET['tel'];
		$card = $_GET['card'];
		$bank_id = $_GET['bank_id'];
		$hold_name = $_GET['hold_name'];
		$card_num = $_GET['card_num'];
		
		$data['c_shopId'] = $shop_id;
		$data['c_name'] = $name;
		$data['c_mobile'] = $tel;
		$data['c_card'] = $card;
		$data['c_bank_id'] = $bank_id;
		$data['c_hold_name'] = $hold_name;		
		$data['c_card_num'] = $card_num;
		$data['c_addtime'] = time();
		$data['c_delete'] = 0;
		
		$rs = db('bind_card')->insert($data);
		if($rs){
			$datas['result'] = true;
			$datas['resultString'] = '添加账号成功';
		}else{
			$datas['result'] = false;
			$datas['resultString'] = '添加账号失败';
		}
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
	}
	
	//获取商家端相关联的所有提现账号
	public function tx_info(){
		$shop_id = $this->shop_id;
		
		$other_list = db('bind_other')->where('o_shopId',$shop_id)->where('o_delete',0)->find();
		$bank_list = db('bind_card')->alias('bc')->join('banks b','b.bankId=bc.c_bank_id')->where('c_shopId',$shop_id)->where('c_delete',0)->select();
		
		$new_arrs = array();
		$new_arr = array();
		if($other_list){
			if($other_list['o_wx_num'] && $other_list['o_alipay_num']){
				$new_arrs[0]['id'] = $other_list['o_id'];
				$new_arrs[0]['num'] = $other_list['o_alipay_num'];
				$new_arrs[0]['name'] = '支付宝';
				$new_arrs[1]['id'] = $other_list['o_id'];
				$new_arrs[1]['num'] = $other_list['o_wx_num'];
				$new_arrs[1]['name'] = '微信';
			}else if($other_list['o_wx_num'] || $other_list['o_alipay_num']){
				$new_arrs[0]['id'] = $other_list['o_id'];
				$new_arrs[0]['num'] = empty($other_list['o_alipay_num'])?$other_list['o_wx_num']:$other_list['o_alipay_num'];
				$new_arrs[0]['name'] = empty($other_list['o_alipay_num'])?'微信':'支付宝';
			}
		}else{
			$new_arrs = array();
		}
		if($bank_list){
			foreach($bank_list as $k1=>$v1){
				$new_arr[$k1]['id'] = $v1['c_id'];
				$new_arr[$k1]['num'] = $v1['c_card_num'];
				$new_arr[$k1]['name'] = $v1['bankName'];
				
			}
		}else{
			$new_arr = array();
		}

		$arr = array_merge_recursive($new_arrs,$new_arr);   //合并
		$datas['result'] = true;
		$datas['resultString'] = "提现相关账号列表";
		$datas['data'] = $arr;
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;		
	}
	
	/*
	商家端提现接口
	type:  1:支付宝；2：微信；3：银行卡
	id:    提现账号id
	money: 提现金额
	*/
	public function tx(){
		$shop_id = $this->shop_id;
		
		$type = $_GET['type'];
		$id = $_GET['id'];
		$money = (float)$_GET['money'];
		$arr['shop_id'] = $shop_id;
		$arr['type'] = $type;
		$arr['money'] = $money;
		$arr['id'] = $id;
		$m = new M();
        $result = $m->tx_shop($arr);

		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($result);die;
		
	}
	
	//商家端提现列表接口
	public function tx_list(){
		$shop_id = $this->shop_id;
		
		if($_GET['page'] > 0){
			 $page = (int)$_GET['page']; 
			 $start = $page == 1 ? 0 : ($page-1)*5;
			 $end = 5;
		}
		$where['targetType'] = 1;
		$where['targetId'] = $shop_id;
		$list = db('cash_draws')->where($where)->order('cashId desc')->limit($start.','.$end)->select();
		foreach($list as $k=>$v){
			$arr['time'] = $v['createTime'];
			$arr['money'] = $v['money'];
			if($v['cashSatus'] == 1){
				$arr['satus'] = '提现成功';
			}else{
				$arr['satus'] = '提现中';
			}
			
			if($v['accType'] == 3){
				$arr['type'] = '银行卡';
			}else{
				$arr['type'] = ($v['accType'] == 1)?"支付宝":"微信";
			}
		}
		$datas['result'] = true;
		$datas['resultString'] = "提现列表";
		$datas['data'] = is_null($arr)?$arr = array():$arr;   //判断空数组
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
		
	}
	
	
}
