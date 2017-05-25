<?php
namespace wstmart\shop\controller;
use wstmart\shop\model\Banks as M;
/**
 * 卖家端聊天app控制器（阿里百川）
 */
use think\Session;
use think\Db;
class Chat extends Base{
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
	
	
	/*
	获取聊天列表信息
	*/
	public function chat_list(){
		$shop_id = $this->shop_id;
		
		//获取店铺的聊天账号
		$chat = Db::name('shops')->where('shopId',$shop_id)->find();
		$shop_chat = $chat['telephone'];
		include_once('./extend/IMchat/TopSdk.php');
		date_default_timezone_set('Asia/Shanghai'); 
		$c = new \TopClient();
		$c->appkey = LINQUAN_CHAT_appkey;   //23719018
		$c->secretKey = LINQUAN_CHAT_secretKey;   //e0aea0fa6f26e7d8b95f47b95a3d4568
		
		$req = new \OpenimUsersAddRequest();   //添加用户
		$userinfos = new \Userinfos();
		$userinfos->nick="king";
		$userinfos->icon_url="http://xxx.com/xxx";
		$userinfos->email="uid@taobao.com";
		$userinfos->mobile=$shop_chat;
		$userinfos->taobaoid=$shop_chat;
		$userinfos->userid=$shop_chat;
		$userinfos->password="123456";
		$userinfos->remark="demo";
		$userinfos->extra="{}";
		$userinfos->career="demo";
		$userinfos->vip="{}";
		$userinfos->address="demo";
		$userinfos->name="demo";
		$userinfos->age="123";
		$userinfos->gender="M";
		$userinfos->wechat="demo";
		$userinfos->qq="demo";
		$userinfos->weibo="demo";
		$req->setUserinfos(json_encode($userinfos));
		$resp = $c->execute($req);
		
		$req = new \OpenimUsersGetRequest();         //批量查询
		$arr = $shop_chat;
		$req->setUserids($arr);
		$resp = $c->execute($req);

		echo json_encode($resp);die;
		
	}
	
	
}
