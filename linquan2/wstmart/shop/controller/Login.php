<?php
namespace wstmart\shop\controller;
use wstmart\shop\model\Banks as M;
/**

 * 卖家端注册和登录app控制器
 */
use think\Session;
use think\Db;
class Login extends Base{
	
	/**
     * 卖家服务端发送短信  xzx
     */
    public function send(){
		$tel = $_GET['tel'];
		if(empty($tel)){
			$data['result'] = false;
			$data['resultString'] = "手机号码为空";
			echo json_encode($data);die;
		}
        $code = 123456;
		Session::set('shop_code',$code);
		$data['result'] = true;
		$data['resultString'] = "发送短信成功";
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($data);
    }

    /**
     * 卖家服务端行业  xzx
     */
    public function class_select(){
    	$where['show'] = 1;
        $list = db("shop_class")->where($where)->select();
        $list = is_null($list)?$list = array():$list; 
        $data['data'] = $list;
		$data['result'] = true;
		$data['resultString'] = "行业分类数据";
		echo json_encode($data);
    }
	
    /**
     * 卖家服务端注册   xzx
     */
    public function register(){
        $codes = $_GET['code'];
		$pwd = $_GET['pwd'];
		$shop_class = $_GET['shop_class'];
		$loginName = $_GET['loginName'];
		//$s_code = Session::get("shop_code");   暂时没有短信接口
		if($codes != '123456'){    
			$datas['result'] = false;
			$datas['resultString'] = "验证码不对";
			echo header('Content-type: application/json;charset=utf-8');
			echo json_encode($datas);die;
		}
		
		$des = Db::name('users')->where('loginName',$loginName)->find();
		$shops = db('shops')->where('userId',$des['userId'])->find();
		if($shops){    //已经注册过店铺
			$datas['result'] = false;
			$datas['resultString'] = "店铺已注册过";
			echo header('Content-type: application/json;charset=utf-8');
			echo json_encode($datas);die;
		}
		
		
	    if($des){   //买家手机已注册
			$res = $des['userId'];
		}else{
			//先插入用户表
			$data['loginName'] = $loginName;
			$data["loginSecret"] = rand(1000,9999);
			$data['loginPwd'] = md5($pwd.$data['loginSecret']);
			$data['userPhone'] = $loginName;
			$data['userType'] = 1; 
			$data['userStatus'] = 1;
			$data['dataFlag'] = 1;
			$data['createTime'] = date("Y-m-d H:i:s",time());
			$res = Db::name('users')->insertGetId($data);
		}
			
		//在插入店铺表
		$dat['shopSn'] = '';
		$dat['userId'] = $res;
		$dat['areaIdPath'] = '';
		$dat['areaId'] = 0;
		$dat['isSelf'] = 0;
		$dat['shopName'] = '';
		$dat['shopkeeper'] = '';
		$dat['telephone'] = $loginName;
		$dat['shopCompany'] = '';
		$dat['shopImg'] = '';
		$dat['shopTel'] = '';
		$dat['shopAddress'] = '';
		$dat['bankId'] = '';
		$dat['bankNo'] = '';
		$dat['bankUserName'] = '';
		$dat['isInvoice'] = '';
		$dat['serviceStartTime'] = '';
		$dat['serviceEndTime'] = '';
		$dat['shopAtive'] = 1;
		$dat['shopStatus'] = 0;
		$dat['dataFlag'] = 1;
		$dat['createTime'] = date("y-m-d H:i:s",time());
		$dat['shop_class'] = $shop_class;
		$ress = db("shops")->insertGetId($dat);
		
		if($res && $ress){
			//行业的经营范围
			$cons['class_id'] = $shop_class;
			$shop_info = db('shop_class')->where($cons)->find();
			
			$arr = explode(',',$shop_info['cats_id']);
			$arr = array_filter($arr);
			if($arr){
				foreach($arr as $value){
					$map['catId'] = $value;
					$shop_infos[] = db('goods_cats')->where($map)->find();
				}
			}else{
				$shop_infos = db('goods_cats')->where(array('parentId'=>0,'isShow'=>1,'dataFlag'=>1))->select();
			}
			
			$new_arr['class'] = is_null($shop_infos)?$shop_infos = array():$shop_infos;   //判断空数组
			$new_arr['shop_info'] = $shop_info;  //行业信息
			$new_arr['shop_id'] = $ress;
			$datas['data'] = $new_arr;
			
			$datas['result'] = true;
			$datas['resultString'] = "注册成功";
			
			
		}else{
			$datas['result'] = false;
			$datas['resultString'] = "注册失败";
		}
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
		
    }
	
	
	
	/**
     * 卖家服务端信息录入   xzx
     */
	public function shopInfo(){
		$shopName = $_POST['shopName'];   //店铺名称
		$shopAddress = $_POST['shopAddress'];
		$shopkeeper = $_POST['shopkeeper'];   //店主
		$telephone = $_POST['telephone'];
		$shopCard = $_POST['shopCard'];  //身份证
		$shop_id = $_POST['shop_id'];
		$bus_id = $_POST['bus_id'];   //行业id
		$manage = $_POST['manage'];  //字符串以逗号隔开 经营范围
		
		//上传图片
		$file = request()->file('img');   //img是name名
	    foreach ($file as $key => $value) {
			$info = $value->move('./upload/shop');       
			$arr[$key] =  $info->getSaveName();    //获取图像保存路径
			$arr[$key] = explode('\\', $arr[$key]);
	    }
		$data['shopImg'] = empty($arr[0][0])?'':'upload/shop/'.$arr[0][0].'/'.$arr[0][1];
		$data['card_img'] = empty($arr[1][0])?'':'upload/shop/'.$arr[1][0].'/'.$arr[1][1];
		$data['manage_img'] = empty($arr[2][0])?'':'upload/shop/'.$arr[2][0].'/'.$arr[2][1];
		$data['health_img'] = empty($arr[3][0])?'':'upload/shop/'.$arr[3][0].'/'.$arr[3][1];
		$data['shopName'] = $shopName;
		$data['shopAddress'] = $shopAddress;
		$data['shopkeeper'] = $shopkeeper;
		$data['telephone'] = $telephone;
		$data['shopCard'] = $shopCard;
		$con['shopId'] = $shop_id;
		$con['is_information'] = 1;
		$result_id = db("shops")->where($con)->save($data);
		
		
		//经营范围（插入行业表）
		$where['class_id'] = $bus_id;
		$data1['cats_id'] = $manage;
		$res = db('shop_class')->where($where)->save($data1);
		
		//店铺表经营类目表
		$ma_arr = explode(',',$manage);
		foreach($ma_arr as $value){
			if(!empty($value)){
				$map['shopId'] = $shop_id;
				$map['catId'] = $value;
				db('cat_shops')->insert($map);
			}
		}
		
		
		if($result_id && $res){
			$datas['result'] = true;
			$datas['resultString'] = "店铺申请成功";
			
		}else{
			$datas['result'] = false;
			$datas['resultString'] = "店铺申请失败";
		}
		
		echo json_encode($datas);die;
		
	}
	
	
	//店铺登录
	public function login(){
		$tel = $_GET['tel'];
		$pwd = $_GET['pwd'];
		
		$where['loginName'] = $tel;
		$user = db("users")->alias("u")->join("shops s","u.userId=s.userId")->where($where)->find();
		if($user){
			if($user['is_information'] != 1){
				$datas['result']= false;
                $datas['resultString'] = '请补充资料';
				$arr['shop_class'] = $user['shop_class'];
				$arr['shopId'] = $user['shopId'];
				$arr['is_information'] = $user['is_information'];
				
				//行业的经营范围
				$cons['class_id'] = $user['shop_class'];
				$shop_info = db('shop_class')->where($cons)->find();
				
				$arrs = explode(',',$shop_info['cats_id']);
				$arrs = array_filter($arrs);
				if($arrs){
					foreach($arrs as $value){
						$map['catId'] = $value;
						$shop_infos[] = db('goods_cats')->where($map)->find();
					}
				}else{
					$shop_infos = db('goods_cats')->where(array('parentId'=>0,'isShow'=>1,'dataFlag'=>1))->select();
				}
				
				$arr['class'] = is_null($shop_infos)?$shop_infos = array():$shop_infos;   //判断空数组
				$arr['shop_info'] = $shop_info['class_name'];  //行业信息
				$datas['data'] = $arr;
				$datas['token'] = '';
				echo header('Content-type: application/json;charset=utf-8');
				echo json_encode($datas);die;
			}else{
				$loginPwd = md5($pwd.$user['loginSecret']);
				if($loginPwd == $user['loginPwd']){
					$datas['result'] = true;
					//$datas['token'] = $this->authcode($user['shopId'],'ENCODE',LINQUAN_KEY,0);
					
					$datas['token']= base64_encode($user['shopId']);
					$datas['resultString'] = '登录成功';
				}else{
					$datas['result'] = false;
					$datas['resultString'] = '密码错误';
				}
			}			
		}else{
			$datas['result'] = false;
            $datas['resultString'] = '该账号不存在，请注册';
		}
		echo header('Content-type: application/json;charset=utf-8');
		echo json_encode($datas);die;
		
	}
	

    
}
