<?php
namespace wstmart\user\controller;
use think\Session;
use think\Db;
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
    * 检测账号是否可用  lxt
    */
    public function is_available($token){
        if(!empty($token)){
          //$user=$this->authcode($token,'DECODE',LINQUAN_KEY,0);
          $user=base64_decode($token);
          
          $userinfo=db('users')->where('loginName',$user)->find();
          if($userinfo['userStatus']!=1 || $userinfo['dataFlag']!=1){
             $datas['result'] = false;
             $datas['resultString'] = '该账号不能使用，请联系客服';
             echo json_encode($datas);die; 
          }
        }
    }

    /**
    * 检测是否登录  lxt
    */
    public function is_login($token){
        if(!$token){
           $datas['result'] = false;
           $datas['resultString'] = "请先登录";
           echo json_encode($datas);die; 
        }
    }
    
    /**
    * 订单状态  lxt
    */
    public function order_status($orderStatus=0,$isRefund=0,$isAppraise=0){
       if($orderStatus=='-3' && $isRefund==1 ){
          return 1;
       }elseif($orderStatus=='-3' && $isRefund==0){
          return 2;
       }elseif($orderStatus=='-2'){
          return 3;
       }elseif($orderStatus=='-1'){
          return 4;
       }elseif($orderStatus=='0'){
          return 5;
       }elseif($orderStatus=='1'){
          return 6;
       }elseif($orderStatus=='2' && $isAppraise=0){
          return 7;
       }elseif($orderStatus=='2' && $isAppraise=1 ){
          return 8;
       }
       

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



  //快递100
   public function getOrderExpress($orderId){
      $conf = $this->getConf("Kuaidi");
      $express = Db::name('orders')->where(["orderId"=>$orderId])->field(['expressId','expressNo'])->find();
      
      if($express["expressId"]>0){
        $expressId = $express["expressId"];
        $row = Db::name('express')->where(["expressId"=>$expressId])->find();
        $typeCom =  strtolower($row["expressCode"]); //快递公司
        $typeNu = $express["expressNo"]; //快递单号
        
        $appKey= $conf["kuaidiKey"];
        
        $expressLogs = null;
        $companys = array('ems','shentong','yuantong','shunfeng','yunda','tiantian','zhongtong','zengyisudi');
        if(in_array($typeCom,$companys)){
          $url = 'http://www.kuaidi100.com/query?type=' . $typeCom . '&postid=' . $typeNu;
        }else{
          $url ='http://api.kuaidi100.com/api?id='.$appKey.'&com='.$typeCom.'&nu='.$typeNu.'&show=0&muti=1&order=asc';
        }
        $expressLogs = $this -> curl($url);
        return $expressLogs;
      }
      
    }
  
    public function getOrderInfo(){
      $data = array();
      $orderId = input("orderId");
      $data["express"] = Db::name('orders o')->join('__EXPRESS__ e', 'o.expressId=e.expressId')->where(["orderId"=>$orderId])->field(['e.expressId','expressNo','expressName'])->find();
      $data["goodlist"] = Db::name('orders o')->join('__ORDER_GOODS__ og','o.orderId=og.orderId')->field(["goodsId","goodsImg"])->select();
      return $data;
    }
  
    public function curl($url) {
      $curl = curl_init();
      curl_setopt ($curl, CURLOPT_URL, $url);
      curl_setopt ($curl, CURLOPT_HEADER,0);
      curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
      curl_setopt ($curl, CURLOPT_TIMEOUT,5);
      $content = curl_exec($curl);
      curl_close ($curl);
      return $content;
    }
  

    public  function getOrderDeliver($orderId){
      $rs = Db::name('orders o')->where(["orderId"=>$orderId])->field("deliverType,orderStatus")->find();
      return $rs;
    }

    public function getConf($addonsName){
      $data = cache('ADDONS_'.$addonsName);
      if(!$data){
        $rs = Db::name('addons')->where('name',$addonsName)->field('config')->find();
          $data =  json_decode($rs['config'],true);
          cache('ADDONS_'.$addonsName,$data,31622400);
      }
      return $data;
    }
    


    public function getExpressState($state){
        $stateTxt = "";
        switch ($state) {
          case '0':$stateTxt="运输中";break;
          case '1':$stateTxt="揽件";break;
          case '2':$stateTxt="疑难";break;
          case '3':$stateTxt="收件人已签收";break;
          case '4':$stateTxt="已退签";break;
          case '5':$stateTxt="派件中";break;
          case '6':$stateTxt="退回";break;
          default:$stateTxt="暂未获取到信息";break;
        }
        return $stateTxt;
    }

     /**
    * 计算距离  lxt
    */
    function getDistance($lat1, $lng1, $lat2, $lng2) { 
    $earthRadius = 6367000; //approximate radius of earth in meters 
     
    /* 
    Convert these degrees to radians 
    to work with the formula 
    */
     
    $lat1 = ($lat1 * pi() ) / 180; 
    $lng1 = ($lng1 * pi() ) / 180; 
     
    $lat2 = ($lat2 * pi() ) / 180; 
    $lng2 = ($lng2 * pi() ) / 180; 
     
    /* 
    Using the 
    Haversine formula 
     
    http://en.wikipedia.org/wiki/Haversine_formula 
     
    calculate the distance 
    */
     
    $calcLongitude = $lng2 - $lng1; 
    $calcLatitude = $lat2 - $lat1; 
    $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2); 
    $stepTwo = 2 * asin(min(1, sqrt($stepOne))); 
    $calculatedDistance = $earthRadius * $stepTwo; 
     
     //算出来的是米
    return round($calculatedDistance); 
  } 





}