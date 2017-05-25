<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\LogMoneys as M;
use think\Db;
/**
 * 进销存-补货控制器  xzx
 */
class Replenishment extends Base{
	
    public function index(){
    	return $this->fetch("list");
    }
	
	
	//退货
	public function tuihuo(){
    	return $this->fetch("tuihuo");
    }
    
   /*
	库存补货-根据选择补货仓库之后选择具体仓库还是网店的方法  xzx
	select_id：补货=》1:网店   2：仓库
	*/
	public function get_stockinfo(){
		$select_id = $_POST['select_id'];
		if($select_id == '2'){
			$stock_list = db('roles')->where('dataFlag',1)->where("roleName","like","%仓库%")->field('roleId,roleName')->select();			
			foreach($stock_list as $k=>$v){
				$arr[$k]['name'] = $v['roleName']; 
				$arr[$k]['id'] = $v['roleId']; 
			}
			
		}else if($select_id == '1'){
			$shop_list = db('shops')->where('dataFlag',1)->where('shopStatus',1)->where('shop_flag',1)->field('shopId,shopName')->select();
			foreach($shop_list as $k=>$v){
				$arr[$k]['name'] = $v['shopName']; 
				$arr[$k]['id'] = $v['shopId']; 
			}
		}
		echo json_encode($arr);die;
		
	}
	
	//获取补货的数据  xzx
	public function pageIndex(){
		$list = DB::name('shop_buhuo')->paginate(input('pagesize/d'))->toArray();
		$arr = array();
		foreach($list['Rows'] as $key => $value){
			$arr['Rows'][$key]['shopName'] = Db::name('shops')->where('shopId',$value['buhuo_shopId'])->value('shopName');
			$arr['Rows'][$key]['shopkeeper'] = Db::name('shops')->where('shopId',$value['buhuo_shopId'])->value('shopkeeper');
			$arr['Rows'][$key]['num'] = $value['buhuo_num'];
			$arr['Rows'][$key]['remark'] = $value['buhuo_remark'];
			$arr['Rows'][$key]['status'] = $value['buhuo_status'];
			$arr['Rows'][$key]['buhuo_id'] = $value['buhuo_id'];
			$arr['Rows'][$key]['time'] = date("Y-m-d H:i",$value['buhuo_time']);
			
			$where['g.goodsId'] = $value['buhuo_goodsId'];
			$where['g.shopId'] = $value['buhuo_shopId'];
			$where['g.dataFlag'] = 1;
			$shop_list = Db('goods')->alias('g')->join('goods_specs gs','gs.goodsId=g.goodsId')->where($where)->find();
			if(count($shop_list) > 0){
				$specIds = explode(':',$shop_list['specIds']);
				$spec = "";
				foreach($specIds as $v){
					$where1['itemId'] = $v;
					$specs = Db::name('spec_items')->alias('si')->join('spec_cats sc','si.catId=sc.catId')->where($where1)->field('itemName,catName')->find();
					$spec = $spec.($specs['catName'].":".$specs['itemName']).",";
				}
				$arr['Rows'][$key]['goodsName'] = $shop_list['goodsName'];
				$arr['Rows'][$key]['spec'] = $spec;
			}else{   //没有商品规格
				$arr['Rows'][$key]['goodsName'] = $value['buhuo_goodsName'];
				$arr['Rows'][$key]['spec'] = '无';
			}
			
		}
		return $arr;
	}
	
	
	//获取退货的数据  xzx
	public function pageIndexs(){
		$list = DB::name('shop_tuihuo')->paginate(input('pagesize/d'))->toArray();
		$arr = array();
		foreach($list['Rows'] as $key => $value){
			$arr['Rows'][$key]['shopName'] = Db::name('shops')->where('shopId',$value['tuihuo_shopId'])->value('shopName');
			$arr['Rows'][$key]['shopkeeper'] = Db::name('shops')->where('shopId',$value['tuihuo_shopId'])->value('shopkeeper');
			$arr['Rows'][$key]['num'] = $value['tuihuo_num'];
			$arr['Rows'][$key]['remark'] = $value['tuihuo_remark'];
			$arr['Rows'][$key]['status'] = $value['tuihuo_status'];
			$arr['Rows'][$key]['tuihuo_id'] = $value['tuihuo_id'];
			$arr['Rows'][$key]['time'] = date("Y-m-d H:i",$value['tuihuo_time']);
			
			$where['g.goodsId'] = $value['tuihuo_goodsId'];
			$where['g.shopId'] = $value['tuihuo_shopId'];
			$where['g.dataFlag'] = 1;
			$shop_list = Db('goods')->alias('g')->join('goods_specs gs','gs.goodsId=g.goodsId')->where($where)->find();
			if(count($shop_list) > 0){
				$specIds = explode(':',$shop_list['specIds']);
				$spec = "";
				foreach($specIds as $v){
					$where1['itemId'] = $v;
					$specs = Db::name('spec_items')->alias('si')->join('spec_cats sc','si.catId=sc.catId')->where($where1)->field('itemName,catName')->find();
					$spec = $spec.($specs['catName'].":".$specs['itemName']).",";
				}
				$arr['Rows'][$key]['goodsName'] = $shop_list['goodsName'];
				$arr['Rows'][$key]['spec'] = $spec;
			}else{   //没有商品规格
				$arr['Rows'][$key]['goodsName'] = $value['tuihuo_goodsName'];
				$arr['Rows'][$key]['spec'] = '无';
			}
			
		}
		return $arr;
	}
	
	/*
	补货时点击同意或是拒绝  xzx
	flag:1.同意；2.拒绝
	*/
	public function do_buhuo(){
		$flag = $_POST['flag'];
		$id = $_POST['id'];
		if($flag == 1){
			$res = Db::name('shop_buhuo')->where('buhuo_id',$id)->setField('buhuo_status',2);
		}else if($flag == 2){
			$res = Db::name('shop_buhuo')->where('buhuo_id',$id)->setField('buhuo_status',3);
		}
		
		if($res){
			$datas['flag'] = 1;
			$datas['msg'] = ($flag == 1)?"同意操作成功":"拒绝操作成功";
		}else{
			$datas['flag'] = -1;
			$datas['msg'] = ($flag == 1)?"同意操作失败":"拒绝操作失败";
		}
		echo json_encode($datas);die;
	}
	
	
	/*
	退货时点击同意或是拒绝  xzx
	flag:1.同意；2.拒绝
	*/
	public function do_tuihuo(){
		$flag = $_POST['flag'];
		$id = $_POST['id'];
		if($flag == 1){
			$res = Db::name('shop_tuihuo')->where('tuihuo_id',$id)->setField('tuihuo_status',2);
		}else if($flag == 2){
			$res = Db::name('shop_tuihuo')->where('tuihuo_id',$id)->setField('tuihuo_status',3);
		}
		
		if($res){
			$datas['flag'] = 1;
			$datas['msg'] = ($flag == 1)?"同意操作成功":"拒绝操作成功";
		}else{
			$datas['flag'] = -1;
			$datas['msg'] = ($flag == 1)?"同意操作失败":"拒绝操作失败";
		}
		echo json_encode($datas);die;
	}
	
	//获取某个商品的补货信息   xzx
	public function get_goods_info(){
		$buhuo_id = $_POST['id'];
		$list = Db::name('shop_buhuo')->where('buhuo_id',$buhuo_id)->find();
		
		$arr['shopName'] = Db::name('shops')->where('shopId',$list['buhuo_shopId'])->value('shopName');
		$arr['shopkeeper'] = Db::name('shops')->where('shopId',$list['buhuo_shopId'])->value('shopkeeper');
		$arr['num'] = $list['buhuo_num'];
		$arr['remark'] = $list['buhuo_remark'];
		$arr['status'] = $list['buhuo_status'];
		$arr['buhuo_id'] = $list['buhuo_id'];
		$arr['time'] = date("Y-m-d H:i",$list['buhuo_time']);
		
		$where['g.goodsId'] = $list['buhuo_goodsId'];
		$where['g.shopId'] = $list['buhuo_shopId'];
		$where['g.dataFlag'] = 1;
		$shop_list = Db('goods')->alias('g')->join('goods_specs gs','gs.goodsId=g.goodsId')->where($where)->find();
		if(count($shop_list) > 0){
			$specIds = explode(':',$shop_list['specIds']);
			$spec = "";
			$spec_str = "";
			foreach($specIds as $v){
				$where1['itemId'] = $v;
				$specs = Db::name('spec_items')->alias('si')->join('spec_cats sc','si.catId=sc.catId')->where($where1)->field('itemName,catName')->find();
				$spec = $spec.($specs['catName'].":".$specs['itemName']).",";
				$spec_str = $spec_str.$specs['itemName'].",";
			}
			$arr['goodsName'] = $shop_list['goodsName'];
			$arr['spec'] = $spec;
			$arr['spec_list'] = $spec_str;
		}else{
			$arr['goodsName'] = $list['buhuo_goodsName'];
			$arr['spec'] = '';
			$arr['spec_list'] = '';
		}
		$arr['buhuo_do_num'] = $list['buhuo_do_num'];
		
		echo json_encode($arr);die;
		
	}
	
	
	//获取某个商品的退货信息   xzx
	public function get_goods_infos(){
		$buhuo_id = $_POST['id'];
		$list = Db::name('shop_tuihuo')->where('tuihuo_id',$buhuo_id)->find();
		
		$arr['shopName'] = Db::name('shops')->where('shopId',$list['tuihuo_shopId'])->value('shopName');
		$arr['shopkeeper'] = Db::name('shops')->where('shopId',$list['tuihuo_shopId'])->value('shopkeeper');
		$arr['num'] = $list['tuihuo_num'];
		$arr['remark'] = $list['tuihuo_remark'];
		$arr['status'] = $list['tuihuo_status'];
		$arr['tuihuo_id'] = $list['tuihuo_id'];
		$arr['time'] = date("Y-m-d H:i",$list['tuihuo_time']);
		
		$where['g.goodsId'] = $list['tuihuo_goodsId'];
		$where['g.shopId'] = $list['tuihuo_shopId'];
		$where['g.dataFlag'] = 1;
		$shop_list = Db('goods')->alias('g')->join('goods_specs gs','gs.goodsId=g.goodsId')->where($where)->find();
		if(count($shop_list) > 0){
			$specIds = explode(':',$shop_list['specIds']);
			$spec = "";
			$spec_str = "";
			foreach($specIds as $v){
				$where1['itemId'] = $v;
				$specs = Db::name('spec_items')->alias('si')->join('spec_cats sc','si.catId=sc.catId')->where($where1)->field('itemName,catName')->find();
				$spec = $spec.($specs['catName'].":".$specs['itemName']).",";
				$spec_str = $spec_str.$specs['itemName'].",";
			}
			$arr['goodsName'] = $shop_list['goodsName'];
			$arr['spec'] = $spec;
			$arr['spec_list'] = $spec_str;
		}else{
			$arr['goodsName'] = $list['tuihuo_goodsName'];
			$arr['spec'] = '';
			$arr['spec_list'] = '';
		}
		$arr['tuihuo_do_num'] = $list['tuihuo_do_num'];
		
		echo json_encode($arr);die;
		
	}
	
	//获取补货的数据(也即是退货的店铺的退货订单)
	public function get_buhuo_list(){
		$data['tuihuo_shopId'] = $_POST['shopId'];
		$data['tuihuo_goodsName'] = $_POST['goodsName'];
		$data['tuihuo_spec'] = $_POST['spec_list'];
		$list = Db::name('shop_tuihuo')->where($data)->order('tuihuo_id desc')->select();
		foreach($list as $k=>$v){
			$list[$k]['tuihuo_time'] = date('Y-m-d H:i',$v['tuihuo_time']);
		}
		echo json_encode($list);
	}
	
	
	//获取退货的数据(也即是补货的店铺的补货订单)
	public function get_tuihuo_list(){
		$data['tuihuo_shopId'] = $_POST['shopId'];
		$data['tuihuo_goodsName'] = $_POST['goodsName'];
		$data['tuihuo_spec'] = $_POST['spec_list'];
		$list = Db::name('shop_tuihuo')->where($data)->order('tuihuo_id desc')->select();
		foreach($list as $k=>$v){
			$list[$k]['buhuo_time'] = date("Y-m-d H:i",$v['tuihuo_time']);
		}
		echo json_encode($list);
	}
	/*
	处理后台对于补货的具体操作 xzx
	wangdian: 1：为网店（判断其他店铺是否有此商品，如有的话更新商品表数量和规格表的相对应的数量；没有的话新增商品表和规格表中）
	          2：仓库（更新仓库的相对应规格表中的数量，并修改相对应的商品表和产品规格表的相对应的数据）
	*/
	public function done_buhuo(){	
		$spec_list = explode(',',$_POST['spec_list']);   //获取规格值字符串转换成数组
		$buhuo_id = $_POST['buhuo_id'];
		$wangdian = $_POST['wangdian'];  //1:网店；2：仓库
		$wangdian2 = $_POST['wangdian2'];   //具体仓库或是店铺id
		$beizhu = $_POST['beizhu'];   //备注
		$spec = $_POST['spec'];
		$expressName = $_POST['expressName'];  //经办人
		$num = $_POST['buhuo_do_num'];
		$goodsName = $_POST['goodsName'];
		$isflag = $_POST['isflag'];   //判断是否有规格 0：没有规格  1:有规格
		$yy = array_filter(explode(";",$_POST['yy']));  //填写补货的循环列表
		
		
		if(empty($wangdian)) return WSTReturn("补货第一个类别没有选择", -1);
		if(empty($wangdian2)) return WSTReturn("补货第二个类别没有选择", -1);
		if(empty($expressName)) return WSTReturn("经办人没有填写", -1);
		$buhuo_info = Db::name('shop_buhuo')->where('buhuo_id',$buhuo_id)->find();   //查询补货的信息
		
		$where['s.dataFlag'] = 1;
		$where['ss.dataFlag'] = 1;
		$where['s.goodsName'] = $goodsName;
		$supper = Db::name('supplier_goods')->alias('s')->join('supplier_goods_spec ss','s.id=ss.good_id')->where($where)->select();
		if(count($supper) > 0){
			$spec_arr = array();
			$res_id = '';
			foreach($supper as $k=>$v){
				$spec_arr = explode(',',$v['spec_value']);
				$res = array_diff($spec_arr,$spec_list);  //计算数组的差集
				
				if(empty($res)){
					$res_id = $v['s_id'];  //获取供应商的产品规格的id
				}
			}
		}
		
		
		//如果有规格查询出规格表的specIds   10:2:3:4
		$spec_val = "";
		$spec_list = array_filter($spec_list);
		if(count($spec_list) > 0){
			foreach($spec_list as $key=>$val){
				$spec_id = Db::name('spec_items')->where('itemName',$val)->value('itemId');
				if($key == (count($spec_list)-1)){
					$spec_val = $spec_val.$spec_id;
				}else{
					$spec_val = $spec_val.$spec_id.":";
				}
			}
		}
		$order_num = 'DR'.time().substr(strval(rand(10000,19999)),1,4);
		//var_dump($order_num);die;
		$sum_num = 0;
		//////
		
		///////////
		
		//业务流程
		if($wangdian == 1){
			if($isflag == 1){  //有规格
				Db::startTrans();
				try{
					foreach($yy as $k=>$v){
						$arr = explode(',',$v);
						//计算一共操作的总数
						$sum_num = $sum_num + $arr[1];
						
						//修改退货订单的实际操作数据
						$tuihuo_stock = Db::name('shop_tuihuo')->where('tuihuo_id',$arr[0])->find(); 
						$dat['tuihuo_do_num'] = $tuihuo_stock['tuihuo_do_num'] - $arr[1];
						Db::name('shop_tuihuo')->where('tuihuo_id',$arr[0])->update($dat);
						
						//插入调拨、调入表
						$data1['call_num'] = $order_num;
						$data1['call_shop_ids'] = $wangdian2;
						$data1['call_manager_id'] = $expressName;
						$data1['call_shop_id'] = $buhuo_info['buhuo_shopId'];
						$data1['call_select_time'] = date('Y-m-d H:i:s',time());
						$data1['call_note'] = $beizhu;
						$data1['call_add_time'] = date('Y-m-d H:i:s',time());
						$data1['call_dataFlag'] = 1;
						$data1['call_flag'] = 2;
						Db::name('call')->insert($data1);
						
						//插入调拨、调入商品表
						//$goods_info = Db::name('goods')->where('',)->find();
						$data2['call_number'] = $order_num;
						$data2['call_shop_ids'] = $wangdian2;
						$data2['call_goods_id'] = Db::name('shop_tuihuo')->where('tuihuo_id',$arr[0])->value('tuihuo_goodsId');
						$data2['call_goods_number'] = $arr[1];
						$data2['call_goods_huohao'] = Db::name('supplier_goods_spec')->where('s_id',$res_id)->value('s_huohao');
						$data2['call_goods_time'] = time();
						$data2['call_shop_id'] = $buhuo_info['buhuo_shopId'];
						$data2['call_flags'] = 2;
						$data2['call_status'] = 3;
						$data2['call_is_do'] = 2;
						$data2['call_do_id'] = $arr[0];
						Db::name('call_goods')->insert($data2);
						
						//插入操作日志表log_stocks_shops
						$data3['in_number'] = $order_num;
						$data3['states'] = 3;
						$data3['do_time'] = time();
						$data3['sum'] = $arr[1];
						$data3['huohao'] = Db::name('supplier_goods_spec')->where('s_id',$res_id)->value('s_huohao');
						$data3['call_start_id'] = $buhuo_info['buhuo_shopId'];
						$data3['call_end_id'] = $wangdian2;
						$data3['call_sto'] = 4;
						Db::name('log_stocks_shops')->insert($data3);
						//修改退货订单商品的规格表库存
						$spec_info = Db::name('goods_specs')->where('specIds',$spec_val)->where('goodsId',$tuihuo_stock['tuihuo_goodsId'])->find();
						$map1['specStock'] = $spec_info['specStock'] - $arr[1];
						Db::name('goods_specs')->where('id',$spec_info['id'])->update($map1);
						//修改退货订单商品表库存
						$goods_infos = Db::name('goods')->where('goodsId',$tuihuo_stock['tuihuo_goodsId'])->find();
						$map2['goodsStock'] = $goods_infos['goodsStock'] - $arr[1];
						Db::name('goods')->where("goodsId",$goods_infos['goodsId'])->update($map2);
					}
					
					//修改补货订单的实际操作数量
					$bu['buhuo_do_num'] = $buhuo_info['buhuo_do_num'] - $sum_num;
					Db::name('shop_buhuo')->where('buhuo_id',$buhuo_id)->update($bu);
					//修改补货商品表和规格表的库存
					$spec_infos = Db::name('goods_specs')->where('specIds',$spec_val)->where('goodsId',$buhuo_info['buhuo_goodsId'])->find();
					$map3['specStock'] = $spec_infos['specStock'] - $sum_num;
					Db::name('goods_specs')->where('id',$spec_infos['id'])->update($map3);
					
					$goods_infos = Db::name("goods")->where('goodsId',$buhuo_info['buhuo_goodsId'])->find();
					$map4['goodsStock'] = $goods_infos['goodsStock'] - $sum_num;
					Db::name('goods')->where('goodsId',$buhuo_info['buhuo_goodsId'])->update($map4);
					// 提交事务
					echo 'success';
					Db::commit();                         

				} catch (\Exception $e) {
					// 回滚事务
					echo 'error111';
					Db::rollback();

				}
			}else{  //无规格
				Db::startTrans();
				try{
					foreach($yy as $k=>$v){
						$arr = explode(',',$v);
						//计算一共操作的总数
						$sum_num = $sum_num + $arr[1];
						
						//修改退货订单的实际操作数据
						$tuihuo_stock = Db::name('shop_tuihuo')->where('tuihuo_id',$arr[0])->find(); 
						$dat['tuihuo_do_num'] = $tuihuo_stock['tuihuo_do_num'] - $arr[1];
						Db::name('shop_tuihuo')->where('tuihuo_id',$arr[0])->update($dat);
						
						//插入调拨、调入表
						$data1['call_num'] = $order_num;
						$data1['call_shop_ids'] = $wangdian2;
						$data1['call_manager_id'] = $expressName;
						$data1['call_shop_id'] = $buhuo_info['buhuo_shopId'];
						$data1['call_select_time'] = date('Y-m-d H:i:s',time());
						$data1['call_note'] = $beizhu;
						$data1['call_add_time'] = date('Y-m-d H:i:s',time());
						$data1['call_dataFlag'] = 1;
						$data1['call_flag'] = 2;
						Db::name('call')->insert($data1);
						
						//插入调拨、调入商品表
						//$goods_info = Db::name('goods')->where('',)->find();
						$data2['call_number'] = $order_num;
						$data2['call_shop_ids'] = $wangdian2;
						$data2['call_goods_id'] = Db::name('shop_tuihuo')->where('tuihuo_id',$arr[0])->value('tuihuo_goodsId');
						$data2['call_goods_number'] = $arr[1];
						$data2['call_goods_huohao'] = '';
						$data2['call_goods_time'] = time();
						$data2['call_shop_id'] = $buhuo_info['buhuo_shopId'];
						$data2['call_flags'] = 2;
						$data2['call_status'] = 3;
						$data2['call_is_do'] = 2;
						$data2['call_do_id'] = $arr[0];
						Db::name('call_goods')->insert($data2);
						
						//插入操作日志表log_stocks_shops
						$data3['in_number'] = $order_num;
						$data3['states'] = 3;
						$data3['do_time'] = time();
						$data3['sum'] = $arr[1];
						$data3['huohao'] = '';
						$data3['call_start_id'] = $buhuo_info['buhuo_shopId'];
						$data3['call_end_id'] = $wangdian2;
						$data3['call_sto'] = 4;
						Db::name('log_stocks_shops')->insert($data3);
						//修改退货订单商品的规格表库存
						/* $spec_info = Db::name('goods_specs')->where('goods_specs',$spec_val)->where('goodsId',$tuihuo_stock['tuihuo_goodsId'])->find();
						$map1['specStock'] = $map1['specStock'] - $arr[1];
						Db::name('goods_specs')->where('id',$spec_info['id'])->update($map1); */
						//修改退货订单商品表库存
						$goods_infos = Db::name('goods')->where('goodsId',$tuihuo_stock['tuihuo_goodsId'])->find();
						$map2['goodsStock'] = $goods_infos['goodsStock'] - $arr[1];
						Db::name('goods')->where("goodsId",$goods_infos['goodsId'])->update($map2);
					}
					
					//修改补货订单的实际操作数量
					$bu['buhuo_do_num'] = $buhuo_info['buhuo_do_num'] - $sum_num;
					Db::name('shop_buhuo')->where('buhuo_id',$buhuo_info['buhuo_id'])->update($bu);
					
					//修改补货商品表和规格表的库存
					/* $spec_infos = Db::name('goods_specs')->where('goods_specs',$spec_val)->where('goodsId',$buhuo_info['buhuo_goodsId'])->find();
					$map3['specStock'] = $spec_infos['specStock'] - $sum_num;
					Db::name('goods_specs')->where('id',$spec_infos['id'])->update($map3); */
					
					$goods_infos = Db::name("goods")->where('goodsId',$buhuo_info['buhuo_goodsId'])->find();
					$map4['goodsStock'] = $goods_infos['goodsStock'] - $sum_num;
					Db::name('goods')->where('goodsId',$buhuo_info['buhuo_goodsId'])->update($map4);
					// 提交事务
					echo 'success';
					Db::commit();                         

				} catch (\Exception $e) {
					// 回滚事务
					echo 'error';
					Db::rollback();

				}
			}
			
		}else if($wangdian == 2){
			/* $supper = Db::name('supplier_goods')->alias('s')->join('supplier_goods_spec ss','s.id=ss.good_id')->where($where)->select();
			$spec_arr = array();
			$res_id = '';
			foreach($supper as $k=>$v){
				$spec_arr = explode(',',$v['spec_value']);
				$res = array_diff($spec_arr,$spec_list);  //计算数组的差集
				
				if(empty($res)){
					$res_id = $v['s_id'];  //获取供应商的产品规格的id
				}
			} */
			if($isflag == 1){   //有产品规格
				Db::startTrans();
				try{
					
					//插入调拨、调入表
					$data1['call_num'] = $order_num;
					$data1['call_stock_id'] = $wangdian2;
					$data1['call_manager_id'] = $expressName;
					$data1['call_shop_id'] = $buhuo_info['buhuo_shopId'];
					$data1['call_select_time'] = date('Y-m-d H:i:s',time());
					$data1['call_note'] = $beizhu;
					$data1['call_add_time'] = date('Y-m-d H:i:s',time());
					$data1['call_dataFlag'] = 1;
					$data1['call_flag'] = 2;
					Db::name('call')->insert($data1);
					
					//插入调拨、调入商品表
					//$goods_info = Db::name('goods')->where('',)->find();
					$data2['call_number'] = $order_num;
					$data2['call_stock_id'] = $wangdian2;
					$data2['call_goods_id'] = $buhuo_info['buhuo_goodsId'];
					$data2['call_goods_number'] = $num;
					$data2['call_goods_huohao'] = Db::name('supplier_goods_spec')->where('s_id',$res_id)->value('s_huohao');
					$data2['call_goods_time'] = time();
					$data2['call_shop_id'] = $buhuo_info['buhuo_shopId'];
					$data2['call_flags'] = 2;
					$data2['call_status'] = 3;
					$data2['call_is_do'] = 2;
					$data2['call_do_id'] = $buhuo_info['buhuo_id'];
					Db::name('call_goods')->insert($data2);
					
					//插入操作日志表log_stocks_shops
					$data3['in_number'] = $order_num;
					$data3['states'] = 3;
					$data3['do_time'] = time();
					$data3['sum'] = $num;
					$data3['huohao'] = Db::name('supplier_goods_spec')->where('s_id',$res_id)->value('s_huohao');
					$data3['call_start_id'] = $buhuo_info['buhuo_shopId'];
					$data3['call_end_id'] = $wangdian2;
					$data3['call_sto'] = 3;
					Db::name('log_stocks_shops')->insert($data3);
					
					//修改补货订单的实际操作数量
					$bu['buhuo_do_num'] = $buhuo_info['buhuo_do_num'] - $num;
					Db::name('shop_buhuo')->where('buhuo_id',$buhuo_info['buhuo_id'])->update($bu);
					
					//修改仓库的产品规格的库存
					$supper = Db::name('supplier_goods_spec')->where('s_id',$res_id)->find();
					$map1['stock'] = $supper['stock'] + $num;
					Db::name('supplier_goods_spec')->where('s_id',$res)->update($map1);
					
					//修改补货商品表和规格表的库存
					$spec_infos = Db::name('goods_specs')->where('specIds',$spec_val)->where('goodsId',$buhuo_info['buhuo_goodsId'])->find();
					$map3['specStock'] = $spec_infos['specStock'] - $num;
					Db::name('goods_specs')->where('id',$spec_infos['id'])->update($map3);
					
					$goods_infos = Db::name("goods")->where('goodsId',$buhuo_info['buhuo_goodsId'])->find();
					$map4['goodsStock'] = $goods_infos['goodsStock'] - $num;
					Db::name('goods')->where('goodsId',$buhuo_info['buhuo_goodsId'])->update($map4);
					
					// 提交事务
					echo 'success';
					Db::commit();                         

				} catch (\Exception $e) {
					// 回滚事务
					echo 'error';
					Db::rollback();

				}
			}else{   //无产品规格
				Db::startTrans();
				try{
					
					//插入调拨、调入表
					$data1['call_num'] = $order_num;
					$data1['call_stock_id'] = $wangdian2;
					$data1['call_manager_id'] = $expressName;
					$data1['call_shop_id'] = $buhuo_info['buhuo_shopId'];
					$data1['call_select_time'] = date('Y-m-d H:i:s',time());
					$data1['call_note'] = $beizhu;
					$data1['call_add_time'] = date('Y-m-d H:i:s',time());
					$data1['call_dataFlag'] = 1;
					$data1['call_flag'] = 2;
					Db::name('call')->insert($data1);
					
					//插入调拨、调入商品表
					//$goods_info = Db::name('goods')->where('',)->find();
					$data2['call_number'] = $order_num;
					$data2['call_stock_id'] = $wangdian2;
					$data2['call_goods_id'] = $buhuo_info['buhuo_goodsId'];
					$data2['call_goods_number'] = $num;
					$data2['call_goods_huohao'] = '';
					$data2['call_goods_time'] = time();
					$data2['call_shop_id'] = $buhuo_info['buhuo_shopId'];
					$data2['call_flags'] = 2;
					$data2['call_status'] = 3;
					$data2['call_is_do'] = 2;
					$data2['call_do_id'] = $buhuo_info['buhuo_id'];
					Db::name('call_goods')->insert($data2);
					
					//插入操作日志表log_stocks_shops
					$data3['in_number'] = $order_num;
					$data3['states'] = 3;
					$data3['do_time'] = time();
					$data3['sum'] = $num;
					$data3['huohao'] = '';
					$data3['call_start_id'] = $buhuo_info['buhuo_shopId'];
					$data3['call_end_id'] = $wangdian2;
					$data3['call_sto'] = 3;
					Db::name('log_stocks_shops')->insert($data3);
					
					//修改补货订单的实际操作数量
					$bu['buhuo_do_num'] = $buhuo_info['buhuo_do_num'] - $num;
					Db::name('shop_buhuo')->where('buhuo_id',$buhuo_info['buhuo_id'])->update($bu);
					
					//修改仓库的产品库存
					$supper = Db::name('supplier_goods')->where('goodsName',$goodsName)->find();
					$map1['goodsStock'] = $supper['goodsStock'] + $num;
					Db::name('supplier_goods')->where('id',$supper['id'])->update($map1);
					
					//修改补货商品表库存
					/* $spec_infos = Db::name('goods_specs')->where('goods_specs',$spec_val)->where('goodsId',$buhuo_info['buhuo_goodsId'])->find();
					$map3['specStock'] = $spec_infos['specStock'] - $num;
					Db::name('goods_specs')->where('id',$spec_infos['id'])->update($map3); */
					
					$goods_infos = Db::name("goods")->where('goodsId',$buhuo_info['buhuo_goodsId'])->find();
					$map4['goodsStock'] = $goods_infos['goodsStock'] - $num;
					Db::name('goods')->where('goodsId',$buhuo_info['buhuo_goodsId'])->update($map4);
					
					// 提交事务
					echo 'success';
					Db::commit();                         

				} catch (\Exception $e) {
					// 回滚事务
					echo 'error';
					Db::rollback();

				}
			}
		}		
		
	}
	
	
	/*
	处理后台对于退货的具体操作 xzx
	wangdian: 1：为网店（判断其他店铺是否有此商品，如有的话更新商品表数量和规格表的相对应的数量；没有的话新增商品表和规格表中）
	          2：仓库（更新仓库的相对应规格表中的数量，并修改相对应的商品表和产品规格表的相对应的数据）
	*/
	public function done_tuihuo(){	
		$spec_list = explode(',',$_POST['spec_list']);   //获取规格值字符串转换成数组
		$buhuo_id = $_POST['tuihuo_id'];   //退货id
		$wangdian = $_POST['wangdian'];  //1:网店；2：仓库
		$wangdian2 = $_POST['wangdian2'];   //具体仓库或是店铺id
		$beizhu = $_POST['beizhu'];   //备注
		$spec = $_POST['spec'];
		$expressName = $_POST['expressName'];  //经办人
		$num = $_POST['buhuo_do_num'];
		$goodsName = $_POST['goodsName'];
		$isflag = $_POST['isflag'];   //判断是否有规格 0：没有规格  1:有规格
		$yy = array_filter(explode(";",$_POST['yy']));  //填写补货的循环列表
		
		
		if(empty($wangdian)) return WSTReturn("补货第一个类别没有选择", -1);
		if(empty($wangdian2)) return WSTReturn("补货第二个类别没有选择", -1);
		if(empty($expressName)) return WSTReturn("经办人没有填写", -1);
		$buhuo_info = Db::name('shop_tuihuo')->where('tuihuo_id',$buhuo_id)->find();   //查询退货的信息
		
		$where['s.dataFlag'] = 1;
		$where['ss.dataFlag'] = 1;
		$where['s.goodsName'] = $goodsName;
		$supper = Db::name('supplier_goods')->alias('s')->join('supplier_goods_spec ss','s.id=ss.good_id')->where($where)->select();
		if(count($supper) > 0){
			$spec_arr = array();
			$res_id = '';
			foreach($supper as $k=>$v){
				$spec_arr = explode(',',$v['spec_value']);
				$res = array_diff($spec_arr,$spec_list);  //计算数组的差集
				
				if(empty($res)){
					$res_id = $v['s_id'];  //获取供应商的产品规格的id
				}
			}
		}
		
		
		//如果有规格查询出规格表的specIds   10:2:3:4
		$spec_val = "";
		$spec_list = array_filter($spec_list);
		if(count($spec_list) > 0){
			foreach($spec_list as $key=>$val){
				$spec_id = Db::name('spec_items')->where('itemName',$val)->value('itemId');
				if($key == (count($spec_list)-1)){
					$spec_val = $spec_val.$spec_id;
				}else{
					$spec_val = $spec_val.$spec_id.":";
				}
			}
		}
		$order_num = 'DR'.time().substr(strval(rand(10000,19999)),1,4);
		//var_dump($order_num);die;
		$sum_num = 0;
		//////
		
		///////////
		
		//业务流程
		if($wangdian == 1){
			if($isflag == 1){  //有规格
				Db::startTrans();
				try{
					foreach($yy as $k=>$v){
						$arr = explode(',',$v);
						//计算一共操作的总数
						$sum_num = $sum_num + $arr[1];
						
						//修改补货订单的实际操作数据
						$tuihuo_stock = Db::name('shop_buhuo')->where('buhuo_id',$arr[0])->find(); 
						$dat['buhuo_do_num'] = $tuihuo_stock['buhuo_do_num'] - $arr[1];
						Db::name('shop_buhuo')->where('buhuo_id',$arr[0])->update($dat);
						
						//插入调拨、调入表
						$data1['call_num'] = $order_num;
						$data1['call_shop_ids'] = $wangdian2;
						$data1['call_manager_id'] = $expressName;
						$data1['call_shop_id'] = $buhuo_info['tuihuo_shopId'];
						$data1['call_select_time'] = date('Y-m-d H:i:s',time());
						$data1['call_note'] = $beizhu;
						$data1['call_add_time'] = date('Y-m-d H:i:s',time());
						$data1['call_dataFlag'] = 1;
						$data1['call_flag'] = 2;
						Db::name('call')->insert($data1);
						
						//插入调拨、调入商品表
						//$goods_info = Db::name('goods')->where('',)->find();
						$data2['call_number'] = $order_num;
						$data2['call_shop_ids'] = $wangdian2;
						$data2['call_goods_id'] = Db::name('shop_buhuo')->where('buhuo_id',$arr[0])->value('buhuo_goodsId');
						$data2['call_goods_number'] = $arr[1];
						$data2['call_goods_huohao'] = Db::name('supplier_goods_spec')->where('s_id',$res_id)->value('s_huohao');
						$data2['call_goods_time'] = time();
						$data2['call_shop_id'] = $buhuo_info['tuihuo_shopId'];
						$data2['call_flags'] = 2;
						$data2['call_status'] = 3;
						$data2['call_is_do'] = 1;
						$data2['call_do_id'] = $arr[0];
						Db::name('call_goods')->insert($data2);
						
						//插入操作日志表log_stocks_shops
						$data3['in_number'] = $order_num;
						$data3['states'] = 3;
						$data3['do_time'] = time();
						$data3['sum'] = $arr[1];
						$data3['huohao'] = Db::name('supplier_goods_spec')->where('s_id',$res_id)->value('s_huohao');
						$data3['call_start_id'] = $buhuo_info['tuihuo_shopId'];
						$data3['call_end_id'] = $wangdian2;
						$data3['call_sto'] = 4;
						Db::name('log_stocks_shops')->insert($data3);
						//修改补货订单商品的规格表库存
						$spec_info = Db::name('goods_specs')->where('specIds',$spec_val)->where('goodsId',$tuihuo_stock['buhuo_goodsId'])->find();
						$map1['specStock'] = $spec_info['specStock'] - $arr[1];
						Db::name('goods_specs')->where('id',$spec_info['id'])->update($map1);
						//修改补货订单商品表库存
						$goods_infos = Db::name('goods')->where('goodsId',$tuihuo_stock['buhuo_goodsId'])->find();
						$map2['goodsStock'] = $goods_infos['goodsStock'] - $arr[1];
						Db::name('goods')->where("goodsId",$goods_infos['goodsId'])->update($map2);
					}
					
					//修改退货订单的实际操作数量
					$bu['tuihuo_do_num'] = $buhuo_info['tuihuo_do_num'] - $sum_num;
					Db::name('shop_tuihuo')->where('tuihuo_id',$buhuo_id)->update($bu);
					//修改退货商品表和规格表的库存
					$spec_infos = Db::name('goods_specs')->where('specIds',$spec_val)->where('goodsId',$buhuo_info['tuihuo_goodsId'])->find();
					$map3['specStock'] = $spec_infos['specStock'] - $sum_num;
					Db::name('goods_specs')->where('id',$spec_infos['id'])->update($map3);
					
					$goods_infos = Db::name("goods")->where('goodsId',$buhuo_info['tuihuo_goodsId'])->find();
					$map4['goodsStock'] = $goods_infos['goodsStock'] - $sum_num;
					Db::name('goods')->where('goodsId',$buhuo_info['tuihuo_goodsId'])->update($map4);
					// 提交事务
					echo 'success';
					Db::commit();                         

				} catch (\Exception $e) {
					// 回滚事务
					echo 'error111';
					Db::rollback();

				}
			}else{  //无规格
				Db::startTrans();
				try{
					foreach($yy as $k=>$v){
						$arr = explode(',',$v);
						//计算一共操作的总数
						$sum_num = $sum_num + $arr[1];
						
						//修改补货订单的实际操作数据
						$tuihuo_stock = Db::name('shop_buhuo')->where('buhuo_id',$arr[0])->find(); 
						$dat['buhuo_do_num'] = $tuihuo_stock['buhuo_do_num'] - $arr[1];
						Db::name('shop_buhuo')->where('buhuo_id',$arr[0])->update($dat);
						
						//插入调拨、调入表
						$data1['call_num'] = $order_num;
						$data1['call_shop_ids'] = $wangdian2;
						$data1['call_manager_id'] = $expressName;
						$data1['call_shop_id'] = $buhuo_info['tuihuo_shopId'];
						$data1['call_select_time'] = date('Y-m-d H:i:s',time());
						$data1['call_note'] = $beizhu;
						$data1['call_add_time'] = date('Y-m-d H:i:s',time());
						$data1['call_dataFlag'] = 1;
						$data1['call_flag'] = 2;
						Db::name('call')->insert($data1);
						
						//插入调拨、调入商品表
						//$goods_info = Db::name('goods')->where('',)->find();
						$data2['call_number'] = $order_num;
						$data2['call_shop_ids'] = $wangdian2;
						$data2['call_goods_id'] = Db::name('shop_buhuo')->where('buhuo_id',$arr[0])->value('buhuo_goodsId');
						$data2['call_goods_number'] = $arr[1];
						$data2['call_goods_huohao'] = '';
						$data2['call_goods_time'] = time();
						$data2['call_shop_id'] = $buhuo_info['tuihuo_shopId'];
						$data2['call_flags'] = 2;
						$data2['call_status'] = 3;
						$data2['call_is_do'] = 1;
						$data2['call_do_id'] = $arr[0];
						Db::name('call_goods')->insert($data2);
						
						//插入操作日志表log_stocks_shops
						$data3['in_number'] = $order_num;
						$data3['states'] = 3;
						$data3['do_time'] = time();
						$data3['sum'] = $arr[1];
						$data3['huohao'] = '';
						$data3['call_start_id'] = $buhuo_info['tuihuo_shopId'];
						$data3['call_end_id'] = $wangdian2;
						$data3['call_sto'] = 4;
						Db::name('log_stocks_shops')->insert($data3);
						//修改退货订单商品的规格表库存
						/* $spec_info = Db::name('goods_specs')->where('goods_specs',$spec_val)->where('goodsId',$tuihuo_stock['tuihuo_goodsId'])->find();
						$map1['specStock'] = $map1['specStock'] - $arr[1];
						Db::name('goods_specs')->where('id',$spec_info['id'])->update($map1); */
						//修改补货订单商品表库存
						$goods_infos = Db::name('goods')->where('goodsId',$tuihuo_stock['buhuo_goodsId'])->find();
						$map2['goodsStock'] = $goods_infos['goodsStock'] - $arr[1];
						Db::name('goods')->where("goodsId",$goods_infos['goodsId'])->update($map2);
					}
					
					//修改退货订单的实际操作数量
					$bu['tuihuo_do_num'] = $buhuo_info['tuihuo_do_num'] - $sum_num;
					Db::name('shop_tuihuo')->where('tuihuo_id',$buhuo_info['tuihuo_id'])->update($bu);
					
					//修改退货商品表和规格表的库存
					/* $spec_infos = Db::name('goods_specs')->where('goods_specs',$spec_val)->where('goodsId',$buhuo_info['buhuo_goodsId'])->find();
					$map3['specStock'] = $spec_infos['specStock'] - $sum_num;
					Db::name('goods_specs')->where('id',$spec_infos['id'])->update($map3); */
					
					$goods_infos = Db::name("goods")->where('goodsId',$buhuo_info['tuihuo_goodsId'])->find();
					$map4['goodsStock'] = $goods_infos['goodsStock'] - $sum_num;
					Db::name('goods')->where('goodsId',$buhuo_info['tuihuo_goodsId'])->update($map4);
					// 提交事务
					echo 'success';
					Db::commit();                         

				} catch (\Exception $e) {
					// 回滚事务
					echo 'error';
					Db::rollback();

				}
			}
			
		}else if($wangdian == 2){
			/* $supper = Db::name('supplier_goods')->alias('s')->join('supplier_goods_spec ss','s.id=ss.good_id')->where($where)->select();
			$spec_arr = array();
			$res_id = '';
			foreach($supper as $k=>$v){
				$spec_arr = explode(',',$v['spec_value']);
				$res = array_diff($spec_arr,$spec_list);  //计算数组的差集
				
				if(empty($res)){
					$res_id = $v['s_id'];  //获取供应商的产品规格的id
				}
			} */
			if($isflag == 1){   //有产品规格
				Db::startTrans();
				try{
					
					//插入调拨、调入表
					$data1['call_num'] = $order_num;
					$data1['call_stock_id'] = $wangdian2;
					$data1['call_manager_id'] = $expressName;
					$data1['call_shop_id'] = $buhuo_info['tuihuo_shopId'];
					$data1['call_select_time'] = date('Y-m-d H:i:s',time());
					$data1['call_note'] = $beizhu;
					$data1['call_add_time'] = date('Y-m-d H:i:s',time());
					$data1['call_dataFlag'] = 1;
					$data1['call_flag'] = 2;
					Db::name('call')->insert($data1);
					
					//插入调拨、调入商品表
					//$goods_info = Db::name('goods')->where('',)->find();
					$data2['call_number'] = $order_num;
					$data2['call_stock_id'] = $wangdian2;
					$data2['call_goods_id'] = $buhuo_info['tuihuo_goodsId'];
					$data2['call_goods_number'] = $num;
					$data2['call_goods_huohao'] = Db::name('supplier_goods_spec')->where('s_id',$res_id)->value('s_huohao');
					$data2['call_goods_time'] = time();
					$data2['call_shop_id'] = $buhuo_info['tuihuo_shopId'];
					$data2['call_flags'] = 2;
					$data2['call_status'] = 3;
					$data2['call_is_do'] = 2;
					$data2['call_do_id'] = $buhuo_info['tuihuo_id'];
					Db::name('call_goods')->insert($data2);
					
					//插入操作日志表log_stocks_shops
					$data3['in_number'] = $order_num;
					$data3['states'] = 3;
					$data3['do_time'] = time();
					$data3['sum'] = $num;
					$data3['huohao'] = Db::name('supplier_goods_spec')->where('s_id',$res_id)->value('s_huohao');
					$data3['call_start_id'] = $buhuo_info['tuihuo_shopId'];
					$data3['call_end_id'] = $wangdian2;
					$data3['call_sto'] = 3;
					Db::name('log_stocks_shops')->insert($data3);
					
					//修改退货订单的实际操作数量
					$bu['tuihuo_do_num'] = $buhuo_info['tuihuo_do_num'] - $num;
					Db::name('shop_tuihuo')->where('tuihuo_id',$buhuo_info['tuihuo_id'])->update($bu);
					
					//修改仓库的产品规格的库存
					$supper = Db::name('supplier_goods_spec')->where('s_id',$res_id)->find();
					$map1['stock'] = $supper['stock'] + $num;
					Db::name('supplier_goods_spec')->where('s_id',$res)->update($map1);
					
					//修改退货商品表和规格表的库存
					$spec_infos = Db::name('goods_specs')->where('specIds',$spec_val)->where('goodsId',$buhuo_info['tuihuo_goodsId'])->find();
					$map3['specStock'] = $spec_infos['specStock'] - $num;
					Db::name('goods_specs')->where('id',$spec_infos['id'])->update($map3);
					
					$goods_infos = Db::name("goods")->where('goodsId',$buhuo_info['tuihuo_goodsId'])->find();
					$map4['goodsStock'] = $goods_infos['goodsStock'] - $num;
					Db::name('goods')->where('goodsId',$buhuo_info['tuihuo_goodsId'])->update($map4);
					
					// 提交事务
					echo 'success';
					Db::commit();                         

				} catch (\Exception $e) {
					// 回滚事务
					echo 'error';
					Db::rollback();

				}
			}else{   //无产品规格
				Db::startTrans();
				try{
					
					//插入调拨、调入表
					$data1['call_num'] = $order_num;
					$data1['call_stock_id'] = $wangdian2;
					$data1['call_manager_id'] = $expressName;
					$data1['call_shop_id'] = $buhuo_info['tuihuo_shopId'];
					$data1['call_select_time'] = date('Y-m-d H:i:s',time());
					$data1['call_note'] = $beizhu;
					$data1['call_add_time'] = date('Y-m-d H:i:s',time());
					$data1['call_dataFlag'] = 1;
					$data1['call_flag'] = 2;
					Db::name('call')->insert($data1);
					
					//插入调拨、调入商品表
					//$goods_info = Db::name('goods')->where('',)->find();
					$data2['call_number'] = $order_num;
					$data2['call_stock_id'] = $wangdian2;
					$data2['call_goods_id'] = $buhuo_info['tuihuo_goodsId'];
					$data2['call_goods_number'] = $num;
					$data2['call_goods_huohao'] = '';
					$data2['call_goods_time'] = time();
					$data2['call_shop_id'] = $buhuo_info['tuihuo_shopId'];
					$data2['call_flags'] = 2;
					$data2['call_status'] = 3;
					$data2['call_is_do'] = 2;
					$data2['call_do_id'] = $buhuo_info['tuihuo_id'];
					Db::name('call_goods')->insert($data2);
					
					//插入操作日志表log_stocks_shops
					$data3['in_number'] = $order_num;
					$data3['states'] = 3;
					$data3['do_time'] = time();
					$data3['sum'] = $num;
					$data3['huohao'] = '';
					$data3['call_start_id'] = $buhuo_info['tuihuo_shopId'];
					$data3['call_end_id'] = $wangdian2;
					$data3['call_sto'] = 3;
					Db::name('log_stocks_shops')->insert($data3);
					
					//修改退货订单的实际操作数量
					$bu['tuihuo_do_num'] = $buhuo_info['tuihuo_do_num'] - $num;
					Db::name('shop_tuihuo')->where('tuihuo_id',$buhuo_info['tuihuo_id'])->update($bu);
					
					//修改仓库的产品库存
					$supper = Db::name('supplier_goods')->where('goodsName',$goodsName)->find();
					$map1['goodsStock'] = $supper['goodsStock'] + $num;
					Db::name('supplier_goods')->where('id',$supper['id'])->update($map1);
					
					//修改补货商品表库存
					/* $spec_infos = Db::name('goods_specs')->where('goods_specs',$spec_val)->where('goodsId',$buhuo_info['buhuo_goodsId'])->find();
					$map3['specStock'] = $spec_infos['specStock'] - $num;
					Db::name('goods_specs')->where('id',$spec_infos['id'])->update($map3); */
					
					$goods_infos = Db::name("goods")->where('goodsId',$buhuo_info['tuihuo_goodsId'])->find();
					$map4['goodsStock'] = $goods_infos['goodsStock'] - $num;
					Db::name('goods')->where('goodsId',$buhuo_info['tuihuo_goodsId'])->update($map4);
					
					// 提交事务
					echo 'success';
					Db::commit();                         

				} catch (\Exception $e) {
					// 回滚事务
					echo 'error';
					Db::rollback();

				}
			}
		}		
		
	}

	
	
}
