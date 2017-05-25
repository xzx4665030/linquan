<?php
namespace wstmart\shop\controller;
/**
 * 卖家端app基础控制器
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
	
	
	
	function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {   
		// 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙   
		$ckey_length = 4;   
		   
		// 密匙   
		$key = md5($key ? $key : $GLOBALS['discuz_auth_key']);   
		   
		// 密匙a会参与加解密   
		$keya = md5(substr($key, 0, 16));   
		// 密匙b会用来做数据完整性验证   
		$keyb = md5(substr($key, 16, 16));   
		// 密匙c用于变化生成的密文   
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';   
		// 参与运算的密匙   
		$cryptkey = $keya.md5($keya.$keyc);   
		$key_length = strlen($cryptkey);   
		// 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)， 
		//解密时会通过这个密匙验证数据完整性   
		// 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确   
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :  sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;   
		$string_length = strlen($string);   
		$result = '';   
		$box = range(0, 255);   
		$rndkey = array();   
		// 产生密匙簿   
		for($i = 0; $i <= 255; $i++) {   
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);   
		}   
		// 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度   
		for($j = $i = 0; $i < 256; $i++) {   
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;   
			$tmp = $box[$i];   
			$box[$i] = $box[$j];   
			$box[$j] = $tmp;   
		}   
		// 核心加解密部分   
		for($a = $j = $i = 0; $i < $string_length; $i++) {   
			$a = ($a + 1) % 256;   
			$j = ($j + $box[$a]) % 256;   
			$tmp = $box[$a];   
			$box[$a] = $box[$j];   
			$box[$j] = $tmp;   
			// 从密匙簿得出密匙进行异或，再转成字符   
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));   
		}   
		if($operation == 'DECODE') {  
			// 验证数据有效性，请看未加密明文的格式   
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&  substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {   
				return substr($result, 26);   
			} else {   
				return '';   
			}   
		} else {   
			// 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因   
			// 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码   
			return $keyc.str_replace('=', '', base64_encode($result));   
		}   
	}
	
	
		/**
	 * 计算两点地理坐标之间的距离
	 * @param  Decimal $Longitude1 起点经度
	 * @param  Decimal $Latitude1  起点纬度
	 * @param  Decimal $Longitude2 终点经度 
	 * @param  Decimal $Latitude2  终点纬度
	 * @param  Int     $unit       单位 1:米 2:公里
	 * @param  Int     $decimal    精度 保留小数位数
	 * @return Decimal
	 */
	public function getDistance2($Longitude1, $Latitude1, $Longitude2, $Latitude2, $unit=1, $decimal=2){
		$uid = cookie('uid');
		$EARTH_RADIUS = 6370.996; // 地球半径系数
		$PI = 3.1415926;
		$radLat1 = $Latitude1 * $PI / 180.0;
		$radLat2 = $Latitude2 * $PI / 180.0;
		$radLng1 = $Longitude1 * $PI / 180.0;
		$radLng2 = $Longitude2 * $PI /180.0;
		$a = $radLat1 - $radLat2;
		$b = $radLng1 - $radLng2;
		$distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
		$distance = $distance * $EARTH_RADIUS * 1000;
		if($unit==2){
			$distance = $distance / 1000;
		}
		return round($distance, $decimal);
	}
	
	
	//上传图片(自己定义)
	public function uploads($base_path){
		$imgs = array();  //定义一个数组存放上传图片的路径
		$isSave = false;
		if (!file_exists($base_path)) {
		    mkdir($base_path);
		}
		//file_put_contents('2.txt',$base_path);
		foreach ($_FILES["pics"]["error"] as $key => $error) {
		    if ($error == 0) {
		        $tmp_name = $_FILES["pics"]["tmp_name"][$key];
		        $name = $_FILES["pics"]["name"][$key];
		        $uploadfile = $base_path . rand(00000000,99999999).time().'.jpg';
		        $isSave = move_uploaded_file($tmp_name, $uploadfile);
		        if ($isSave){
		            $imgs[]=$uploadfile;
		        }
		    }else{
		    	return false;
		    }
		}
		return $imgs;
	}
	
	
	/*
	判断店铺账号是否被关闭和删除  xzx
	shop_id:店铺id
	*/
	public function is_open($shop_id){
		$shop_info = db("shops")->where('shopId',$shop_id)->find();
		if($shop_info['shopStatus'] != 1 || $shop_info['dataFlag'] != 1){   //店铺关闭或删除
			$datas['result'] = false;
			$datas['resultString'] = "店铺不能正常使用，请联系客服";
			
		}else{
			$datas['result'] = true;
		}
		
		return $datas;
	}
	
	/*
	订单状态  xzx   1 退款成功；2 退货中；3 未支付；4 已取消；5 未发货；6 查看物流；7 未评价；8 已完成
	status:订单状态
	isAppraise：是否点评
	isRefund：是否退款
	*/
	public function orderStatus($status,$isAppraise = 0,$isRefund = 0){
		if($status == -3){
			if($isRefund == 0){
				$data = 2;
			}else if($isRefund == 1){
				$data = 1;
			}
		}else if($status == -2){
			$data = 3;
		}else if($status == -1){
			$data = 4;
		}else if($status == 0){
			$data = 5;
		}else if($status == 1){
			$data = 6;
		}else if($status == 2){
			if($isAppraise == 0){
				$data = 7;
			}else if($isAppraise == 1){
				$data = 8;
			}
		}
		return $data;
	}
	
}