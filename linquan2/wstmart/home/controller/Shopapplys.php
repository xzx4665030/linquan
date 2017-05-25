<?php
namespace wstmart\home\controller;
use wstmart\common\model\ShopApplys as M;
use wstmart\common\model\LogSms;
/**
 * 门店申请控制器
 */
class Shopapplys extends Base{	
	/**
	 * 判断手机否存在
	 */
	public function checkShopPhone(){
		$m = new M();
		$rs = $m->checkShopPhone(input('userPhone'));
		if($rs["status"]==1){
			return array("ok"=>"");
		}else{
			return array("error"=>$rs["msg"]);
		}
	
	}
	
	/**
	 * 获取验证码
	 */
	public function getPhoneVerifyCode(){
		$userPhone = input("post.userPhone2");
		$rs = array();
		if(!WSTIsPhone($userPhone)){
			return WSTReturn("手机号格式不正确!");
			exit();
		}
		$m = new M();
		$rs = $m->checkShopPhone($userPhone,(int)session('WST_USER.userId'));
		if($rs["status"]!=1){
			return WSTReturn("对不起，该手机号已提交过开店申请，如有疑问请与商城管理员联系!");
			exit();
		}
		
		$phoneVerify = rand(100000,999999);
		$rv = ['status'=>-1,'msg'=>'短信发送失败'];
        $tpl = WSTMsgTemplates('PHONE_SHOP_REGISTER_VERFIY');
        if($tpl['tplContent']!=''){
            $params = ['tpl'=>$tpl,'params'=>['MALL_NAME'=>WSTConf("CONF.mallName"),'VERFIY_CODE'=>$phoneVerify,'VERFIY_TIME'=>10]];
            $m = new LogSms();
            $rv = $m->sendSMS(0,$userPhone,$params,'getPhoneVerifyCode',$phoneVerify);
        }
		if($rv['status']==1){
			session('VerifyCode_shopPhone',$phoneVerify);
			session('VerifyCode_shopPhone_Time',time());
		}
		return $rv;
	}
	
	
	/**
	 * 提交申请
	 */
	public function apply(){
	
		$m = new M();
		$rs = $m->addApply();
		return $rs;
	
	}
	
	/**
	 * 跳到用户注册协议
	 */
	public function protocol(){
		return $this->fetch("shop_protocol");
	}
}
