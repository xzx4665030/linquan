<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\LogMoneys as M;
/**
 * 进销存-库存控制器  xzx
 */
 use think\Db;
class Stock extends Base{
	
	//渲染库存首页的数据
    public function index(){
        // $pur_number='CS'.time().rand(10,99);
        // $this->assign('pur_number',$pur_number);
        $stock_list = db('roles')->where('dataFlag',1)->where("roleName","like","%仓库%")->select();
        $this->assign('stock_list',$stock_list);

        $supplier = db('supplier')->where('dataFlag',1)->select();
        $this->assign('supplier',$supplier);

    	return $this->fetch("list");
    }
    
    //仓库调拨——获取相对应仓库的工作人员数据 还有该仓库下的商品 xzx
	public function get_staff(){
		$stock_id = $_POST['stock_id'];
		$staff_list = db('staffs')->where('staffRoleId',$stock_id)->field('staffId,loginName')->select();
		$new_arr['staff_list'] = $staff_list;
		
		//该仓库下的所有商品  包含没有规格
		$purchase = db('purchase')->alias('p')->join('purchase_good g','p.pur_number=g.p_number')->join('supplier_goods sg','sg.id=g.p_good_id')->join('supplier_goods_spec ss','ss.s_huohao=g.p_huohao','left')->where('p.store_id',$stock_id)->select();
		$item=array();
        foreach($purchase as $k=>$v){
            if(!isset($item[$v['p_huohao']])){
                $item[$v['p_huohao']]=$v;
            }else{
                $item[$v['p_huohao']]['pnumber']+=$v['pnumber'];
            }
        }
        $keys = array();
		for($i=0;$i<count($item);$i++){
			$keys[$i] = $i;
		}
		$item = array_combine($keys, $item);
		
		//$goods_list = db('purchase_good')->alias('p')->join('supplier_goods_spec s','p.p_huohao=s.s_huohao')->join('supplier_goods g','g.id=s.good_id')->where('p_number','between',$arr)->select();
		//$goods_list = db('purchase_good')->where('p_number','between',$arr)->select();
		//var_dump($item);die;
		$new_arr['goods_list'] = $item;
		echo json_encode($new_arr);die;
	}
	
	/*
	库存调拨-根据选择调拨仓库之后选择调拨目的地仓库还是网店的方法  xzx
	stock_id：已选择的初始仓库id
	select_id：调拨目的地=》1：去除初始仓库的剩余仓库；2：网店
	*/
	public function get_stockinfo(){
		$stock_id = $_POST['stock_id'];
		$select_id = $_POST['select_id'];
		if($select_id == '1'){
			$stock_list = db('roles')->where('roleId','not in',$stock_id)->where('dataFlag',1)->where("roleName","like","%仓库%")->field('roleId,roleName')->select();			
			foreach($stock_list as $k=>$v){
				$arr[$k]['name'] = $v['roleName']; 
				$arr[$k]['id'] = $v['roleId']; 
			}
			
		}else if($select_id == '2'){
			$shop_list = db('shops')->where('dataFlag',1)->where('shopStatus',1)->where('shop_flag',1)->field('shopId,shopName')->select();
			foreach($shop_list as $k=>$v){
				$arr[$k]['name'] = $v['shopName']; 
				$arr[$k]['id'] = $v['shopId']; 
			}
		}
		echo json_encode($arr);die;
		
	}
	
	
	//添加调拨数据  xzx
	public function add_call_out(){
		$stock_number = $_POST['stock_number'];  //调拨号
		$stock_id = $_POST['a'];   //调拨仓库的id
		$jsr_id = $_POST['jsr'];  //经手人
		$call_obj = $_POST['b'];  //调拨对象  1:仓库  2：网店
		$call_obj_id = $_POST['c'];  //调拨对象的id
		$timeB = $_POST['timeB'];  //调拨时间
		$expressName = $_POST['expressName'];  //调拨备注
		$selects = $_POST['selects'];   //调拨商品

		if(empty($stock_id)) return WSTReturn("调拨仓库没有选择", -1);
		if(empty($jsr_id)) return WSTReturn("经手人没有选择", -1);
		if(empty($call_obj_id)) return WSTReturn("调拨对象没有选择", -1);
		if(empty($timeB)) return WSTReturn("日期没有填写", -1);
		if(empty($expressName)) return WSTReturn("备注没有填写", -1);
		if(empty($selects)) return WSTReturn("调拨商品没有选择", -1);
		
		//插入调拨表
		$data['call_num'] = $stock_number;
		$data['call_stock_id'] = $stock_id;
		$data['call_manager_id'] = $jsr_id;
		if($call_obj == 1){
			$data['call_stock_ids'] = $call_obj_id;
			$call_sto = 1;  //调拨记录表的参数
		}else if($call_obj == 2){
			$data['call_shop_id'] = $call_obj_id;
			$call_sto = 2;  //调拨记录表的参数
		}
		$data['call_select_time'] = $timeB;
		$data['call_note'] = $expressName;
		$data['call_flag'] = 1;
		$data['call_dataFlag'] = 1;
		$data['call_add_time'] = date("Y-m-d H:i:s",time());
		//var_dump($data);die;
		$call_res = db('call')->insert($data);
		
		//处理选中的调拨商品
		$goods = explode(';',$selects);
		$goods = array_filter($goods);  //清空空数组，否则下面循环会报错
		foreach($goods as $k => $v){
			$goods_list = explode(',',$v);
			//插入调拨记录表
			$map['huohao'] = $goods_list[1];  //货号
			$map['sum'] = $goods_list[2];  //调拨数量
			$map['do_time'] = time();  //仓库id
			$map['out_number'] = $stock_number;  //
			$map['states'] = 2;  //
			$map['call_start_id'] = $stock_id;  //
			$map['call_end_id'] = $call_obj_id;  //
			$map['call_sto'] = $call_sto;
			//db('log_stocks_shops')->insert($map);
			
			//插入调拨的商品表
			$cons['call_goods_id'] = $goods_list[0];  //商品id
			$cons['call_goods_huohao'] = $goods_list[1];  //货号
			$cons['call_goods_number'] = $goods_list[2];  //调拨数量
			$cons['call_number'] = $stock_number;  
			$cons['call_stock_id'] = $stock_id;  
			$cons['call_goods_time'] = time();  
			$cons['call_flags'] = 1;
			$cons['call_status'] = 1;
			if($call_obj == 1){
				$cons['call_stock_ids'] = $call_obj_id;  
			}else if($call_obj == 2){
				$cons['call_shop_id'] = $call_obj_id;  
			}
			db('call_goods')->insert($cons);
			
			//修改采购表的商品数量（根据调拨数量依次从不同采购号中的采购数量减,如一个采购号数量减完为0，再从第二个采购号减直至减完）
			$where['p_huohao'] = $goods_list[1];
			$where['stock_id'] = $stock_id;
			$purchase_list = db('purchase_good')->where($where)->select();
			$nums = $goods_list[2];
			foreach($purchase_list as $k=>$v){
				if(($nums-$v['pnumber']) > 0 && $nums > 0){
					$nums = $nums - $v['pnumber'];
					$maps['pnumber'] = 0;
					db('purchase_good')->where('p_id',$v['p_id'])->update($maps);
				}else if(($nums-$v['pnumber']) <= 0 && $nums > 0){
					$maps['pnumber'] = $v['pnumber'] - $nums;
					$nums = 0;
					db('purchase_good')->where('p_id',$v['p_id'])->update($maps);
				}				
				
			}
			
		}
		if($call_res){
			return WSTReturn("调拨成功", 1);
		}else{
			return WSTReturn("调拨失败", -1);
		}
		
	}
	
	
	/*
	渲染调拨记录的方法 xzx
	*/
	public function pageQueryByCallOut(){
		$where['call_flags'] = 1;
		$where['call_dataFlag'] = 1;
		$call_out = db('call_goods')->alias('g')->join('call c','c.call_num=g.call_number')->where($where)->paginate(input('pagesize/d'))->toArray();
		$arr=array();
		//var_dump($call_out);
		foreach($call_out['Rows'] as $k=>$v){
			$jsr = db('staffs')->where('staffId',$v['call_manager_id'])->find();
			$arr['Rows'][$k]['jsr'] = $jsr['loginName'];
			
			if($v['call_status'] == 1){
				$arr['Rows'][$k]['call_status1'] = '已调拨待发货';
			}else if($v['call_status'] == 2){
				$arr['Rows'][$k]['call_status1'] = '已调拨已发货';
			}else if($v['call_status'] == 3){
				$arr['Rows'][$k]['call_status1'] = '已调拨已收货';
			}
			$arr['Rows'][$k]['call_number'] = $v['call_number'];
			$arr['Rows'][$k]['call_style'] = '调拨';
			$arr['Rows'][$k]['call_note'] = $v['call_note'];
			$arr['Rows'][$k]['call_select_time'] = $v['call_select_time'];
			$arr['Rows'][$k]['call_id'] = $v['call_id'];
			$arr['Rows'][$k]['call_status'] = $v['call_status'];
			
		}
		
		return $arr;
	}
	
	//删除调拨的订单
	public function del_call_out(){
		$call_id = $_POST['id'];
		$map['call_dataFlag'] = -1;
		$call_out_res = db('call')->where('call_id',$call_id)->update($map);
		if($call_out_res){
			$msg['status'] = 1;
			$msg['msg'] = "删除成功";
		}else{
			$msg['status'] = 2;
			$msg['msg'] = "删除失败";
		}
		
		echo json_encode($msg);
	}
	
	//删除全部调拨订单
	public function del_call_out_all(){
		$id = $_POST['ids'];
		$result = db('call')->where('call_id','in',$id)->chunk(20, function($list) {
            foreach ($list as $k=>$v) {                
                $maps['call_dataFlag'] = -1;
                db("call")->where(array('call_id'=>$v['call_id']))->update($maps);
            }
        });
		if($result){
			$msg['status'] = 1;
			$msg['msg'] = "删除成功";
		}else{
			$msg['status'] = 2;
			$msg['msg'] = "删除失败";
		}
		echo json_encode($msg);
	}
	
	
	//订单发货
	public function pageQueryByOrderDelivery(){
		$where['call_flags'] = 1;
		$where['call_dataFlag'] = 1;
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
			$goods_info = db('supplier_goods_spec')->alias('s')->join('supplier_goods g','s.good_id=g.id','right')->where('s_huohao',$v['call_goods_huohao'])->whereOr('id',$v['call_goods_id'])->field('spec_value,goodsName')->find();
			if($goods_info){
				$arr['Rows'][$k]['spec'] = '无';
			}else{
				$arr['Rows'][$k]['spec'] = $goods_info['spec_value'];
			}
			$arr['Rows'][$k]['goodsName'] = $goods_info['goodsName'];
			
		}
		
		return $arr;
		
	}
	
	
	/*
	订单发货的操作方法 xzx
	statas: 1：发货；2：确认发货
	id:调拨订单id
	*/
	public function do_order(){
		$call_goods_id = $_POST['id'];
		$status = $_POST['statas'];
		$data['call_status'] = $status + 1;
		$res = db('call_goods')->where('call_goods_ids',$call_goods_id)->update($data);
		if($res){
			$msg['status'] = 1;
			$msg['msg'] = "操作成功";
		}else{
			$msg['status'] = 2;
			$msg['msg'] = "操作失败";
		}
		echo json_encode($msg);die;
	}
	
}
