<?php
namespace wstmart\admin\controller;
/**
 * 基础控制器
 */
use think\Controller;
class Base extends Controller {
	public function __construct(){
		parent::__construct();
		$this->assign("v",WSTConf('CONF.wstVersion'));
	}
    protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
    	$replace['__ADMIN__'] = str_replace('/index.php','',\think\Request::instance()->root()).'/wstmart/admin/view';
        return $this->view->fetch($template, $vars, $replace, $config);
    }

	public function getVerify(){
		WSTVerify();
	}
	
	public function uploadPic(){
		return WSTUploadPic(1);
	}

	/**
    * 编辑器上传文件
    */
    public function editorUpload(){
        return WSTEditUpload(1);
    }
	
	
	//获取ip
	function getIP(){
		global $ip;
		if (getenv("HTTP_CLIENT_IP"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
			$ip = getenv("REMOTE_ADDR");
		else $ip = "Unknow";
		return $ip;
	}
	
	
	//curl  提交
	public function https_request($url){
		  $curl = curl_init();
		  curl_setopt($curl, CURLOPT_URL, $url);
		  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		  
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		  $output = curl_exec($curl);
		  curl_close($curl);
		  return $output;
	}
}