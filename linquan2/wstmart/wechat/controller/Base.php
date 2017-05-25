<?php
namespace wstmart\wechat\controller;
use think\Controller;
/**
 * 基础控制器
 */
class Base extends Controller {
	public function __construct(){
		parent::__construct();
		WSTConf('CONF',WSTConfig());
		$this->assign("v",WSTConf('CONF.wstVersion')."_".WSTConf('CONF.wstPcStyleId'));
		if(!(request()->module()=="wechat" && request()->controller()=="Weixinpays" && request()->action()=="notify")){
			WSTIsWeixin();//检测是否在微信浏览器上使用
		}
		$state = input('param.state');
		if($state==WSTConf('CONF.wxAppCode')){
			$type = input('param.type');
			if($type=='1'){
				WSTBindWeixin(1);
			}else{
				WSTBindWeixin(0);
			}
		}
	}
    // 权限验证方法
    protected function checkAuth(){
		$state = input('param.state');
		if($state==WSTConf('CONF.wxAppCode')){
			WSTBindWeixin(1);
		}
		$request = request();
       	$USER = session('WST_USER');
        if(empty($USER)){
        	if(request()->isAjax()){
        		die('{"status":-999,"msg":"还没关联帐号,正在关联帐号"}');
        	}else{
        		session('WST_WX_WlADDRESS',$request->url(true));
        		$url=urlencode($request->url(true));
        		$url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.WSTConf('CONF.wxAppId').'&redirect_uri='.$url.'&response_type=code&scope=snsapi_userinfo&state='.WSTConf('CONF.wxAppCode').'#wechat_redirect';

        		header("location:".$url);
        		exit;
        	}
        }
    }
	protected function fetch($template = '', $vars = [], $replace = [], $config = []){
		$style = WSTConf('CONF.wstwechatStyle')?WSTConf('CONF.wstwechatStyle'):'default';
		$replace['__WECHAT__'] = str_replace('/index.php','',\think\Request::instance()->root()).'/wstmart/wechat/view/'.$style;
		return $this->view->fetch($style."/".$template, $vars, $replace, $config);
		
	}
	/**
	 * 上传图片
	 */
	public function uploadPic(){
		return WSTUploadPic(0);
	}
	/**
	 * 获取验证码
	 */
	public function getVerify(){
		WSTVerify();
	}
}