<?php
namespace addons\thirdlogin\model;
use think\addons\BaseModel as Base;
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
 * 第三方登录业务处理
 */
class Thirdlogin extends Base {
	
	/**
	 * 安装
	 */
	public function install(){
		Db::startTrans();
		try{
			$hooks = array("homeDocumentLogin","afterUserRegist","afterUserLogin","mobileDocumentLogin");
			$this->bindHoods("Thirdlogin", $hooks);
			installSql("thirdlogin");//传入插件名
			Db::commit();
			return true;
		}catch (\Exception $e) {
			Db::rollback();
			return false;
		}
	}
	
	/**
	 * 卸载
	 */
	public function uninstall(){
		Db::startTrans();
		try{
			$hooks = array("homeDocumentLogin","afterUserRegist","afterUserLogin","mobileDocumentLogin");
			$this->unbindHoods("Thirdlogin", $hooks);
			uninstallSql("thirdlogin");//传入插件名
			Db::commit();
			return true;
		}catch (\Exception $e) {
			Db::rollback();
			return false;
		}
	}
	
	
	/**
	 * 获取第三方登录方式
	 */
	public function getThirdLogins(){
	
		$addon = Db::name('addons')->where("name","Thirdlogin")->field("config")->find();
		$config = json_decode($addon["config"],true);
		return $config;
	}
	
	
	/**
	 * 检测第三方帐号是否已注册
	 */
	public function checkThirdIsReg($thirdCode,$openId){
		$rs = Db::name('third_users')->where(["thirdCode"=>$thirdCode,"thirdOpenId"=>$openId])->field(["userId","thirdCode","thirdOpenId"])->find();
		if($rs["userId"]>0){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * 绑定帐号
	 */
	public function bindAcc($userId){
		$obj = session('binding_login');
		if(!empty($obj)){
			$where = array();
			$where["thirdOpenId"] = $obj["thirdOpenId"];
			$where["thirdCode"] = $obj["thirdCode"];
			$rs = Db::name('third_users')->where($where)->field(["userId","thirdCode","thirdOpenId"])->find();
			if(empty($rs)){
				$data = array();
				$data["userId"] = $userId;
				$data["thirdOpenId"] = $obj["thirdOpenId"];
				$data["thirdCode"] = $obj["thirdCode"];
				$data["createTime"] = date("Y-m-d H:i:s");
				Db::name('third_users')->insert($data);
				Db::name('users')->where(["userId"=>$userId])->update(["userName"=>$obj["userName"],"userPhoto"=>$obj["userPhoto"]]);
				session('binding_login', null);
			}
		}
	}
	
	public function thirdLogin($obj){
		$rs = Db::name('third_users')->where($obj)->field(["userId","thirdCode","thirdOpenId"])->find();
		if(!empty($rs)){
			$userId = $rs["userId"];
			$user = Db::name('users')->where(["userId"=>$rs["userId"],"dataFlag"=>1, "userStatus"=>1])->find();
			$update = [];
			$ip = request()->ip();
			$update = ["lastTime"=>date('Y-m-d H:i:s'),"lastIP"=>$ip];
			Db::name('users')->where(["userId"=>$userId])->update($update);
			
			//如果是店铺则加载店铺信息
			if($user['userType']>=1){
				$shop = model('shops')->where(["userId"=>$userId,"dataFlag" =>1])->find();
				if(!empty($shop))$user = array_merge($shop->toArray(),$user->toArray());
			}
			//记录登录日志
			$data = array();
			$data["userId"] = $userId;
			$data["loginTime"] = date('Y-m-d H:i:s');
			$data["loginIp"] = $ip;
			$data['loginSrc'] = 0;
			Db::name('log_user_logins')->insert($data);
			
			session('WST_USER',$user);
			return WSTReturn("登录成功","1");
		}else{
			return WSTReturn("登录失败","-1");
		}
	}
}
