<?php
namespace wstmart\shop\controller;
use wstmart\shop\model\Banks as M;
/**
 * 卖家端内容app控制器
 */
use think\Session;
use think\Db;
class Manage extends Base{
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
	
	//商品管理（商品列表）
	public function goods_list(){
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
			$new_arr['goodsName'] = $info['goodsName'];
			$new_arr['goodsTips'] = $info['goodsTips'];
			$new_arr['shopPrice'] = $info['shopPrice'];
			$new_arr['goodsStock'] = $info['goodsStock'];
			$new_arr['goodsImg'] = LINQUAN_IMG.$info['goodsImg'];
			$new_arr['goodsId'] = $info['goodsId'];
			$new_arr['catName'] = $cats_name['catName'];
			$new_arr['catId'] = $cats_name['catId'];
			$new_arr['isSale'] = $info['isSale'];
			
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
			
			$result[] = $new_arr;
			//$result[$cats_name['catName']][] = $new_arr;
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

		$news = array_values($news);	

		
		$dat['list'] = is_null($news)?$news = array():$news;   //判断空数组
		$dat['num'] = is_null($sum)?0:$sum;
		
		$datas['result'] = true;
		$datas['resultString'] = '商品管理的商品列表';
		$datas['data'] = $dat;
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
	}
	
	
	/*
	商品管理（商品下架）
	click:点击下架操作  传0
	goodsId：商品id
	*/
	public function goods_out(){
		$shop_id = $this->shop_id;
		$click = $_GET['click'];
		$goodsId = $_GET['goodsId'];
		
		$data['isSale'] = $click;
		$res = db('goods')->where('goodsId',$goodsId)->update($data);
		if($res){
			$datas['result'] = true;
			$datas['resultString'] = "下架成功";
		}else{
			$datas['result'] = false;
			$datas['resultString'] = "下架失败";
		}
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
		
	}
	
	
	/*
	商品管理（修改商品库存）
	num:上货数量
	goodsId：商品id
	*/
	public function edit_goods_num(){
		$shop_id = $this->shop_id;
		$num = $_GET['num'];
		$goodsId = $_GET['goodsId'];
		
		if(!preg_match("/^[1-9][0-9]*$/",$num)){
			$datas['result'] = false;
			$datas['resultString'] = "添加库存数必须是大于0的整数";
			echo header('Content-type: application/json;charset=utf-8');
			echo json_encode($datas);die;
		}
		$goods_info = db('goods')->where('goodsId',$goodsId)->find();
		$data['goodsStock'] = $goods_info['goodsStock'] + $num;
		$res = db('goods')->where('goodsId',$goodsId)->update($data);
		if($res){
			$datas['result'] = true;
			$datas['resultString'] = "添加库存成功";
		}else{
			$datas['result'] = false;
			$datas['resultString'] = "添加库存失败";
		}
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
		
	}
	
	
	//店铺管理(店铺信息显示)
	public function shop_manage(){
		$shop_id = $this->shop_id;
		
		$where['shopId'] = $shop_id;
		$where['shopStatus'] = 1;
		$where['dataFlag'] = 1;
		$shop_info = db('shops')->where($where)->field('shopImg,shopName,telephone,shopAddress,shop_class,shopkeeper')->find();
		//查询该店铺的经营范围
		$jing = db('shop_class')->where('class_id',$shop_info['shop_class'])->find();
		$class = explode(',',$jing['cats_id']);
		$class = array_filter($class);
		$class_name = "";
		foreach($class as $k=>$v){
			$class_info = db('goods_cats')->where('catId',$v)->field('catName')->find();
			if($k == 0){
				$class_name = $class_info['catName'];
			}else{
				$class_name = $class_name.'、'.$class_info['catName'];
			}
			
		}
		
		$arr = array();
		$arr['shopImg'] = LINQUAN_IMG.$shop_info['shopImg'];
		$arr['shopName'] = $shop_info['shopName'];
		$arr['telephone'] = $shop_info['telephone'];
		$arr['shopAddress'] = $shop_info['shopAddress'];
		$arr['shopkeeper'] = $shop_info['shopkeeper'];
		$arr['class_name'] = $class_name;
		
		$datas['result'] = true;
		$datas['resultString'] = '店铺信息';
		$datas['data'] = $arr;
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
		
	}
	
	//店铺管理（修改店铺信息）
	public function edit_shop_info(){
		$shop_id = $this->shop_id;
		
		$shopName = $_POST['shopName'];
		$telephone = $_POST['telephone'];
		$shopAddress = $_POST['shopAddress'];
		$shopkeeper = $_POST['shopkeeper'];
		
		//上传图片
		$file = request()->file('img');   //img是name名
		$info = $file->move('./upload/shop');       
        $arr =  $info->getSaveName();    //获取图像保存路径
	    /* foreach ($file as $key => $value) {
			$info = $value->move('./uploads/shop');       
			$arr[] =  $info->getSaveName();    //获取图像保存路径
	    } */
		$arr=explode('\\', $arr);
		$data['shopImg'] = empty($arr[0])?'':'upload/shop/'.$arr[0].'/'.$arr[1];
		$data['shopName'] = $shopName;
		$data['telephone'] = $telephone;
		$data['shopAddress'] = $shopAddress;
		$data['shopkeeper'] = $shopkeeper;
		$result_id = db("shops")->where('shopId',$shop_id)->save($data);
		if($result_id !== false){
			$datas['result'] = true;
			$datas['resultString'] = "修改成功";
		}else{
			$datas['result'] = false;
			$datas['resultString'] = "修改失败";
		}
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
		
	}
	
}
