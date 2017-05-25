<?php
namespace wstmart\admin\model;
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
 * 短信日志类
 */
class LogSms extends Base{

	/**
	 * 写入并发送短讯记录
	 */
	public function sendSMS($smsSrc,$userId,$phoneNumber,$params,$smsFunc){
		if((int)WSTConf('CONF.smsOpen')==0)return WSTReturn('未开启短信接口');
		$data = [];
		$data['smsSrc'] = $smsSrc;
		$data['smsUserId'] = $userId;
		$data['smsPhoneNumber'] = $phoneNumber;
		$data['smsContent'] = 'N/A';
		$data['smsReturnCode'] = '';
		$data['smsFunc'] = $smsFunc;
		$data['smsIP'] = request()->ip();
		$data['createTime'] = date('Y-m-d H:i:s');
		$this->data($data)->save();
		$rdata = ['msg'=>'短信发送失败!','status'=>-1];
		hook('sendSMS',['phoneNumber'=>$phoneNumber,"params"=>$params,'smsId'=>$this->smsId,'status'=>&$rdata]);
		return $rdata;
	}
}