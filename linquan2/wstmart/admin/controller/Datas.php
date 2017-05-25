<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\LogMoneys as M;
/**
 * 进销存-数据控制器  xzx
 */
use think\Db;
class Datas extends Base{
	
    public function index(){
    	return $this->fetch("list");
    }
    
    //查询库存信息
	public function get_stock(){
		if($_POST){
			$stock_id = (empty($_POST['stock_id']))?'':$_POST['stock_id'];
			$supper_id = (empty($_POST['supper_id']))?'':$_POST['supper_id'];
			$number = (empty($_POST['number']))?'':$_POST['number'];
			$start_date = (empty($_POST['start_date']))?'':strtotime($_POST['start_date']);
			$end_date = (empty($_POST['end_date']))?'':strtotime($_POST['end_date']);
			$classId = (empty($_POST['classId']))?'':$_POST['classId'];   //分类id

			if($stock_id) $where['store_id'] = $stock_id;
			if($supper_id) $where['supplier_id'] = $supper_id;
			if($number) $where['p_number'] = $number;
			if($classId){   //根据分类id查询供应商商品id
				$new_arr = array();
				$spec_arr = Db::name('supplier_goods')->where('goodsCatIdPath','like','%'.$classId.'%')->select();
				foreach($spec_arr as $k=>$v){
					$new_arr[] = $v['id'];
				}
				$where['p_good_id'] = array('in',$new_arr);
			}		
			
		}
		$where['dataFlag'] = 1;
		if(empty($start_date) && empty($end_date)){

			$list = Db::name('purchase')->alias('p')->join('purchase_good g','p.pur_number=g.p_number')->where($where)->paginate(input('pagesize/d'))->toArray();
		}else{
			$list = Db::name('purchase')->alias('p')->join('purchase_good g','p.pur_number=g.p_number')->where($where)->where('times','between time',array($start_date,$end_date))->paginate(input('pagesize/d'))->toArray();
		
		}
		//var_dump($list);
		foreach($list['Rows'] as $k=>$v){			
			$list['Rows'][$k]['stock_name'] = Db::name('roles')->where('roleId',$v['store_id'])->value('roleName');	
			$list['Rows'][$k]['goodsName'] = Db::name('supplier_goods')->where('id',$v['p_good_id'])->value('goodsName');			
			$list['Rows'][$k]['spec_name'] = Db::name('supplier_goods_spec')->where('s_huohao',$v['p_huohao'])->value('spec_value');
			
		}

		echo json_encode($list);
	}
	
	//库存查询中的仓库下拉
	public function get_stock_list(){
		$stock_list = db('roles')->where('dataFlag',1)->where("roleName","like","%仓库%")->select();
        echo json_encode($stock_list);
	}
	
	//库存查询中的供应商下拉
	public function get_supper_list(){
		$supper_list = db('supplier')->where('dataFlag',1)->select();
        echo json_encode($supper_list);
	}
	
	
	//数据查询——库存变动
	public function change_stock(){
		if($_POST){

			$stock_id = (empty($_POST['stock_id']))?'':$_POST['stock_id'];			
			$number = (empty($_POST['number']))?'':$_POST['number'];
			$start_date = (empty($_POST['start_date']))?'':strtotime($_POST['start_date']);
			$end_date = (empty($_POST['end_date']))?'':strtotime($_POST['end_date']);
			$classId = (empty($_POST['classId']))?'':$_POST['classId'];   //分类id
			
			//字符串条件查询
			$query = (empty($stock_id))?'':"c.call_stock_id=".$stock_id." OR c.call_stock_ids=".$stock_id;

			if($number){
				$shopId = Db::name('shops')->where('shopName','like','%'.$number.'%')->value('shopId');
				//var_dump($shopId);
				if($shopId){   //查询到有店铺
					$query1 = (empty($number))?'':"c.call_shop_ids=".$shopId." OR c.call_shop_id=".$shopId;
				}else{
					$query1 = (empty($number))?'':"c.call_num='".$number."'";
				}
			}else{
				$query1 = "";
			}
			
			if($classId){   //根据分类id查询供应商商品id和商品表id的集合数组
				$new_arr = array();
				$spec_arr = Db::name('supplier_goods')->where('goodsCatIdPath','like','%'.$classId.'%')->select();
				foreach($spec_arr as $k=>$v){
					$new_arr[] = $v['id'];
				}
				
				//根据分类id查询商品表id数组
				$new_arrs = array();
				$goods_arr = Db::name('goods')->where('goodsCatIdPath','like','%'.$classId.'%')->select();
				foreach($goods_arr as $k1=>$v1){
					$new_arrs[] = $v1['goodsId'];
				}
				
				//将两个二维数组合并
				$new_arrs = array_merge_recursive($new_arrs,$new_arr);
				$where['call_goods_id'] = array('in',$new_arrs);
			}
			
		}
		$where['call_dataFlag'] = 1;

		if((empty($start_date) && empty($end_date))){

			$list = Db::name('call')->alias('c')->join('call_goods g','c.call_num=g.call_number')->where($where)->where($query)->where($query1)->paginate(input('pagesize/d'))->toArray();
		}else{
			$list = Db::name('call')->alias('c')->join('call_goods g','c.call_num=g.call_number')->where($where)->where('call_add_time','between time',array($start_date,$end_date))->paginate(input('pagesize/d'))->toArray();
		}

		foreach($list['Rows'] as $k=>$v){
			
			$list['Rows'][$k]['status'] = ($v['call_flag'] == 1)?'调拨':'调入';
			if($v['call_flags'] == 1){
				$list['Rows'][$k]['stock_name'] = Db::name('roles')->where('roleId',$v['call_stock_id'])->value('roleName');
				$list['Rows'][$k]['shop_name'] = Db::name('shops')->where('shopId',$v['call_shop_ids'])->value('shopName');
				$list['Rows'][$k]['end_stock_name'] = Db::name('roles')->where('roleId',$v['call_stock_ids'])->value('roleName');
				$list['Rows'][$k]['end_shop_name'] = Db::name('shops')->where('shopId',$v['call_shop_id'])->value('shopName');
				$list['Rows'][$k]['goodsName'] = Db::name('supplier_goods')->where('id',$v['call_goods_id'])->value('goodsName');
			}else{
				$list['Rows'][$k]['stock_name'] = Db::name('roles')->where('roleId',$v['call_goods_id'])->value('roleName');
				$list['Rows'][$k]['shop_name'] = Db::name('shops')->where('shopId',$v['call_shop_id'])->value('shopName');
				$list['Rows'][$k]['end_stock_name'] = Db::name('roles')->where('roleId',$v['call_stock_id'])->value('roleName');
				$list['Rows'][$k]['end_shop_name'] = Db::name('shops')->where('shopId',$v['call_shop_ids'])->value('shopName');
				$list['Rows'][$k]['goodsName'] = Db::name('goods')->where('goodsId',$v['call_goods_id'])->value('goodsName');
			}
			$list['Rows'][$k]['spec_name'] = Db::name('supplier_goods_spec')->where('s_huohao',$v['call_goods_huohao'])->value('spec_value');
			
		}

		echo json_encode($list);
		
	}

	//商品分类
	public function goods_class(){		
		$list = Db::name('goods_cats')->where(['dataFlag'=>1,'parentId'=>input('catId/d',0)])->order('catSort asc,catId desc')->select();
		echo json_encode($list);
	}
	
	//获取商品分类的子分类
	public function goods_class_son(){
		$class_id = $_POST['id'];
		$where['parentId'] = $class_id;
		$where['dataFlag'] = 1;
		$list = Db::name('goods_cats')->where($where)->order('catSort asc,catId desc')->select();
		echo json_encode($list);
	}
	
	
}
