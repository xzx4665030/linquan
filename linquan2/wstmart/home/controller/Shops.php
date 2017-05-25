<?php
namespace wstmart\home\controller;
use wstmart\home\model\Goods;
use wstmart\common\model\GoodsCats;
/**
 * 门店控制器
 */
use think\Db;
class Shops extends Base{
	/**
	 * 商家登录
	 */
	public function login(){
		$USER = session('WST_USER');
		if(!empty($USER) && isset($USER['shopId'])){
			$this->redirect("shops/index");
		}
		$loginName = cookie("loginName");
		if(!empty($loginName)){
			$this->assign('loginName',cookie("loginName"));
		}else{
			$this->assign('loginName','');
		}
		return $this->fetch('shop_login');
	}
	/**
	 * 商家中心
	 */
	public function index(){
		session('WST_MENID1',null);
		session('WST_MENUID31',null);
		$s = model('shops');
		$data = $s->getShopSummary((int)session('WST_USER.shopId'));
		$this->assign('data',$data);
		return $this->fetch('shops/index');
	}
    /**
     * 店铺街
     */
    public function shopStreet(){
    	$g = new GoodsCats();
    	$goodsCats = $g->listQuery(0);
    	$this->assign('goodscats',$goodsCats);
    	//店铺街列表
    	$s = model('shops');
    	$pagesize = 10;
    	$selectedId = input("get.id/d");
    	$this->assign('selectedId',$selectedId);
    	$list = $s->pageQuery($pagesize);
    	$this->assign('list',$list);
    	$this->assign('keyword',input('keyword'));
    	$this->assign('keytype',1);
    	return $this->fetch('shop_street');
    }
    /**
     * 店铺详情
     */
    public function home(){
    	hook("homeBeforeGoShopHome");
    	$s = model('shops');
    	$shopId = (int)input("param.shopId/d");
    	$data['shop'] = $s->getShopInfo($shopId);
        $ct1 = input("param.ct1/d",0);
        $ct2 = input("param.ct2/d",0);
        $goodsName = input("param.goodsName");
        if(($data['shop']['shopId']==1 || $shopId==0) && $ct1==0 && !isset($goodsName)){
        	$params = input();
        	unset($params["shopId"]);
            $this->redirect(Url('home/shops/selfShop'),$params);
        }
    	if(empty($data['shop']))return $this->fetch('error_lost');
    	$data['shopcats'] = $f = model('ShopCats','model')->getShopCats($shopId);
    	$g = model('goods');
    	$data['list'] = $g->shopGoods($shopId);
    	$this->assign('msort',input("param.msort/d",0));//筛选条件
    	$this->assign('mdesc',input("param.mdesc/d",1));//升降序
    	$this->assign('sprice',input("param.sprice"));//价格范围
    	$this->assign('eprice',input("param.eprice"));
    	$this->assign('ct1',$ct1);//一级分类
    	$this->assign('ct2',$ct2);//二级分类
    	$this->assign('goodsName',urldecode($goodsName));//搜索
    	$this->assign('data',$data);
    	
    	return $this->fetch('shop_home');
    }
    
    /**
     * 店铺分类
     */
    public function cat(){
    	$s = model('shops');
    	$shopId = (int)input("param.shopId/d");
    	$data['shop'] = $s->getShopInfo($shopId);
    
    	$ct1 = input("param.ct1/d",0);
    	$ct2 = input("param.ct2/d",0);
    	$goodsName = input("param.goodsName");
    	if(($data['shop']['shopId']==1 || $shopId==0) && $ct1==0 && !isset($goodsName)){
	    	 $params = input();
	    	 unset($params["shopId"]);
	    	 $this->redirect('shops/selfShop',$params);
    	}
    	if(empty($data['shop']))return $this->fetch('error_lost');
    	$data['shopcats'] = $f = model('ShopCats','model')->getShopCats($shopId);
    	$g = model('goods');
    	$data['list'] = $g->shopGoods($shopId);
    	$this->assign('msort',input("param.msort/d",0));//筛选条件
    	$this->assign('mdesc',input("param.mdesc/d",1));//升降序
    	$this->assign('sprice',input("param.sprice"));//价格范围
    	$this->assign('eprice',input("param.eprice"));
    	$this->assign('ct1',$ct1);//一级分类
    	$this->assign('ct2',$ct2);//二级分类
    	$this->assign('goodsName',urldecode($goodsName));//搜索
    	$this->assign('data',$data);
    	return $this->fetch('shop_home');
    }
    
    /**
     * 查看店铺设置
     */
    public function info(){
    	$s = model('shops');
    	$object = $s->getByView((int)session('WST_USER.shopId'));
    	$this->assign('object',$object);
    	return $this->fetch('shops/shops/view');
    }
    /**
    * 自营店铺
    */
    public function selfShop(){
    	hook("homeBeforeGoSelfShop");
        $s = model('shops');
        $data['shop'] = $s->getShopInfo(1);
        if(empty($data['shop']))return $this->fetch('error_lost');
        $this->assign('selfShop',1);
	    $data['shopcats'] = model('ShopCats')->getShopCats(1);
	    $this->assign('goodsName',urldecode(input("param.goodsName")));//搜索
	    // 店长推荐
	    $data['rec'] = $s->getRecGoods('rec',6);
	    // 热销商品
	    $data['hot'] = $s->getRecGoods('hot',6);
	    $this->assign('data',$data);
	    return $this->fetch('self_shop');
    }

    /**
     * 编辑店铺资料
     */
    public function editInfo(){
        $rs = model('shops')->editInfo();
        return $rs;
    }

    /**
     * 获取店铺金额
     */
    public function getShopMoney(){
        $rs = model('shops')->getFieldsById((int)session('WST_USER.shopId'),'shopMoney,lockMoney');
        $urs = model('users')->getFieldsById((int)session('WST_USER.userId'),'payPwd');
        $rs['isSetPayPwd'] = ($urs['payPwd']=='')?0:1;
        $rs['isDraw'] = ((float)WSTConf('CONF.drawCashShopLimit')<=$rs['shopMoney'])?1:0;
        unset($urs);
        return WSTReturn('',1,$rs);
    }
    
	/**
    * 店铺装修设置
    */
    public function shopDiyset(){
       
	    return $this->fetch('shops/diy/shop_set');
    }
    
    /**
     * 店铺装修
     */
    public function editdecoration(){
    	return $this->fetch('shops/diy/shop_home');
    }
    
    /**
     * 生成店铺装修页面
     */
    public function storedecoration(){
    	return $this->fetch('shops/diy/shop_home');
    }
	
	
	//优惠券  xzx
	public function promotion(){
		$shopId = (int)session('WST_USER.shopId');
		if(input('param.data')){
			$content = input('param.data');
			if($content){
				$where['discount_name'] = array('like',"%".$content."%");
			}			
			$where['discount_delete'] = 1;
			$where['discount_flag'] = 1;
			$where['discount_shopId'] = $shopId;
			$list = db("discount")->where($where)->select();
			foreach($list as $k=>$value){
				$list[$k]['discount_startDate'] = date("Y-m-d",$value['discount_startDate']);
				$list[$k]['discount_endDate'] = date("Y-m-d",$value['discount_endDate']);
			}
			echo json_encode($list);die;
		}
		
		$list = db("discount")->where('discount_delete',1)->where('discount_flag',1)->where('discount_shopId',$shopId)->select();
		$this->assign('list',$list);
		return $this->fetch('shops/promotion/promotion');
	}
	
	//新增优惠券/满减送/红包  xzx
	public function add_promotion(){
		$flag = input("param.flag");
		$this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
		if($flag == 1){
			return $this->fetch('shops/promotion/add_promotion');
		}else if($flag == 2){
			return $this->fetch('shops/promotion/add_delivery');
		}else if($flag == 3){
			return $this->fetch('shops/promotion/add_redPacket');
		}
		
	}
	
	//保存优惠券  xzx  编辑保存优惠券(state为1)
	public function save_promotion(){
		$startDate = $_POST['startDate'];
		$endDate = $_POST['endDate'];
		$promotion_name = $_POST['promotion_name'];
		$promotion_num = $_POST['promotion_num'];
		$promotion_consume = $_POST['promotion_consume'];
		$promotion_value = $_POST['promotion_value'];
		$promotion_img = $_POST['promotion_img'];
		$promotion_flag = $_POST['promotion_flag'];
		if(empty($startDate)) $this->error('起始时间没有选择',url('home/shops/add_promotion',array('flag'=>1)));
		if(empty($endDate)) $this->error('中止时间没有选择',url('home/shops/add_promotion',array('flag'=>1)));
		if(empty($promotion_name)) $this->error('优惠券名称没填写',url('home/shops/add_promotion',array('flag'=>1)));
		if(empty($promotion_num)) $this->error('优惠券数量没有填写',url('home/shops/add_promotion',array('flag'=>1)));
		if(empty($promotion_consume)) $this->error('最低消费没有填写',url('home/shops/add_promotion',array('flag'=>1)));
		if(empty($promotion_value)) $this->error('优惠金额没有填写',url('home/shops/add_promotion',array('flag'=>1)));
		if(empty($promotion_img)) $this->error('优惠券图片没有上传',url('home/shops/add_promotion',array('flag'=>1)));
		
		$shopId = (int)session('WST_USER.shopId');
		$data['discount_shopId'] = $shopId;
		$data['discount_startDate'] = strtotime($startDate);
		$data['discount_endDate'] = strtotime($endDate);
		$data['discount_name'] = $promotion_name;
		$data['discount_num'] = $promotion_num;
		$data['discount_consume'] = $promotion_consume;
		$data['discount_value'] = $promotion_value;
		$data['discount_img'] = $promotion_img;
		$data['discount_flag'] = $promotion_flag;
		$data['discount_add_time'] = time();
		$data['discount_delete'] = 1;
		
		$state = $_POST['state'];
		if($state == 1){
			$id = $_POST['id'];
			$data['discount_edit_time'] = time();
			$result_id = db("discount")->where('discount_id',$id)->update($data);
			if($result_id){
				$this->success('编辑成功',url('home/shops/promotion'));
			}else{
				$this->error('编辑失败',url('home/shops/promotion'));
			}
		}else{
			$result_id = db("discount")->insert($data);
			if($result_id){
				$this->success('添加成功',url('home/shops/promotion'));
			}else{
				$this->error('添加失败',url('home/shops/promotion'));
			}
		}
		
		
	}
	
	//编辑优惠券页面   xzx
	public function edit_promotion(){
		$id = input('param.id');
		$list = db("discount")->where('discount_id',$id)->find();
		$this->assign('list',$list);
		return $this->fetch('shops/promotion/edit_promotion');
	}
	
	
	
	//删除优惠券  xzx
	public function delete_promotion(){
		$id = input('param.id');
		$data['discount_delete'] = 2;
		$result_id = db('discount')->where('discount_id',$id)->update($data);
		if($result_id){
			$this->success('删除成功',url('home/shops/promotion'));
		}else{
			$this->error('删除失败',url('home/shops/promotion'));
		}
	}
	
	
	//满减送  xzx
	public function delivery(){
		$shopId = (int)session('WST_USER.shopId');
		if(input('param.data')){
			$content = input('param.data');
			if($content){
				$where['discount_name'] = array('like',"%".$content."%");
			}			
			$where['discount_delete'] = 1;
			$where['discount_flag'] = 2;
			$where['discount_shopId'] = $shopId;
			$list = db("discount")->where($where)->select();
			foreach($list as $k=>$value){
				$list[$k]['discount_startDate'] = date("Y-m-d",$value['discount_startDate']);
				$list[$k]['discount_endDate'] = date("Y-m-d",$value['discount_endDate']);
			}
			echo json_encode($list);die;
		}
		$list = db("discount")->where('discount_delete',1)->where('discount_flag',2)->where('discount_shopId',$shopId)->select();
		$this->assign('list',$list);
		return $this->fetch('shops/promotion/delivery');
	}
	
	//保存满减送  xzx  编辑保存满减送(state为1)
	public function save_delivery(){
		$startDate = $_POST['startDate'];
		$endDate = $_POST['endDate'];
		$promotion_name = $_POST['delivery_name'];
		$promotion_num = $_POST['delivery_num'];
		$promotion_consume = $_POST['delivery_consume'];
		$promotion_value = $_POST['delivery_value'];
		$promotion_img = $_POST['delivery_img'];
		$promotion_flag = $_POST['delivery_flag'];
		if(empty($startDate)) $this->error('起始时间没有选择',url('home/shops/add_promotion',array('flag'=>2)));
		if(empty($endDate)) $this->error('中止时间没有选择',url('home/shops/add_promotion',array('flag'=>2)));
		if(empty($promotion_name)) $this->error('满减送名称没填写',url('home/shops/add_promotion',array('flag'=>2)));
		if(empty($promotion_num)) $this->error('满减送数量没有填写',url('home/shops/add_promotion',array('flag'=>2)));
		if(empty($promotion_consume)) $this->error('消费金额没有填写',url('home/shops/add_promotion',array('flag'=>2)));
		if(empty($promotion_value)) $this->error('优惠金额没有填写',url('home/shops/add_promotion',array('flag'=>2)));
		if(empty($promotion_img)) $this->error('满减送图片没有上传',url('home/shops/add_promotion',array('flag'=>2)));
		
		$shopId = (int)session('WST_USER.shopId');
		$data['discount_shopId'] = $shopId;
		$data['discount_startDate'] = strtotime($startDate);
		$data['discount_endDate'] = strtotime($endDate);
		$data['discount_name'] = $promotion_name;
		$data['discount_num'] = $promotion_num;
		$data['discount_consume'] = $promotion_consume;
		$data['discount_value'] = $promotion_value;
		$data['discount_img'] = $promotion_img;
		$data['discount_flag'] = $promotion_flag;
		$data['discount_add_time'] = time();
		$data['discount_delete'] = 1;
		
		$state = $_POST['state'];
		if($state == 1){
			$id = $_POST['id'];
			$data['discount_edit_time'] = time();
			$result_id = db("discount")->where('discount_id',$id)->update($data);
			if($result_id){
				$this->success('编辑成功',url('home/shops/delivery'));
			}else{
				$this->error('编辑失败',url('home/shops/delivery'));
			}
		}else{
			$result_id = db("discount")->insert($data);
			if($result_id){
				$this->success('添加成功',url('home/shops/delivery'));
			}else{
				$this->error('添加失败',url('home/shops/delivery'));
			}
		}		
	}
	
	//编辑满减送页面   xzx
	public function edit_delivery(){
		$id = input('param.id');
		$list = db("discount")->where('discount_id',$id)->find();
		$this->assign('list',$list);
		return $this->fetch('shops/promotion/edit_delivery');
	}
	
	//删除优惠券  xzx
	public function delete_delivery(){
		$id = input('param.id');
		$data['discount_delete'] = 2;
		$result_id = db('discount')->where('discount_id',$id)->update($data);
		if($result_id){
			$this->success('删除成功',url('home/shops/delivery'));
		}else{
			$this->error('删除失败',url('home/shops/delivery'));
		}
	}
	
	
	//红包  xzx
	public function redPacket(){
		$shopId = (int)session('WST_USER.shopId');
		if(input('param.data')){
			$content = input('param.data');
			if($content){
				$where['discount_name'] = array('like',"%".$content."%");
			}			
			$where['discount_delete'] = 1;
			$where['discount_flag'] = 3;
			$where['discount_shopId'] = $shopId;
			$list = db("discount")->where($where)->select();
			foreach($list as $k=>$value){
				$list[$k]['discount_startDate'] = date("Y-m-d",$value['discount_startDate']);
				$list[$k]['discount_endDate'] = date("Y-m-d",$value['discount_endDate']);
			}
			echo json_encode($list);die;
		}
		
		$list = db("discount")->where('discount_delete',1)->where('discount_flag',3)->where('discount_shopId',$shopId)->select();
		$this->assign('list',$list);
		return $this->fetch('shops/promotion/redPacket');
	}
	
	//保存红包  xzx  编辑保存红包(state为1)
	public function save_redPacket(){
		$startDate = $_POST['startDate'];
		$endDate = $_POST['endDate'];
		$promotion_name = $_POST['redPacket_name'];
		$promotion_num = $_POST['redPacket_num'];
		$promotion_value = $_POST['redPacket_value'];
		$promotion_img = $_POST['redPacket_img'];
		$promotion_flag = $_POST['redPacket_flag'];
		if(empty($startDate)) $this->error('起始时间没有选择',url('home/shops/add_promotion',array('flag'=>3)));
		if(empty($endDate)) $this->error('中止时间没有选择',url('home/shops/add_promotion',array('flag'=>3)));
		if(empty($promotion_name)) $this->error('红包名称没填写',url('home/shops/add_promotion',array('flag'=>3)));
		if(empty($promotion_num)) $this->error('红包数量没有填写',url('home/shops/add_promotion',array('flag'=>3)));
		if(empty($promotion_value)) $this->error('优惠金额没有填写',url('home/shops/add_promotion',array('flag'=>3)));
		if(empty($promotion_img)) $this->error('红包图片没有上传',url('home/shops/add_promotion',array('flag'=>3)));
		
		$shopId = (int)session('WST_USER.shopId');
		$data['discount_shopId'] = $shopId;
		$data['discount_startDate'] = strtotime($startDate);
		$data['discount_endDate'] = strtotime($endDate);
		$data['discount_name'] = $promotion_name;
		$data['discount_num'] = $promotion_num;
		$data['discount_value'] = $promotion_value;
		$data['discount_img'] = $promotion_img;
		$data['discount_flag'] = $promotion_flag;
		$data['discount_add_time'] = time();
		$data['discount_delete'] = 1;
		
		$state = $_POST['state'];
		if($state == 1){
			$id = $_POST['id'];
			$data['discount_edit_time'] = time();
			$result_id = db("discount")->where('discount_id',$id)->update($data);
			if($result_id){
				$this->success('编辑成功',url('home/shops/redPacket'));
			}else{
				$this->error('编辑失败',url('home/shops/redPacket'));
			}
		}else{
			$result_id = db("discount")->insert($data);
			if($result_id){
				$this->success('添加成功',url('home/shops/redPacket'));
			}else{
				$this->error('添加失败',url('home/shops/redPacket'));
			}
		}		
	}
	
	
	//编辑红包页面   xzx
	public function edit_redPacket(){
		$id = input('param.id');
		$list = db("discount")->where('discount_id',$id)->find();
		$this->assign('list',$list);
		return $this->fetch('shops/promotion/edit_redPacket');
	}
	
	//删除红包  xzx
	public function delete_redPacket(){
		$id = input('param.id');
		$data['discount_delete'] = 2;
		$result_id = db('discount')->where('discount_id',$id)->update($data);
		if($result_id){
			$this->success('删除成功',url('home/shops/delivery'));
		}else{
			$this->error('删除失败',url('home/shops/delivery'));
		}
	}
	
	/*
	上传图片  xzx
	flag参数：1：上传优惠券 2：上传满减送 3：上传红包
	*/  
	public function file_img(){
		$file = $_FILES;
		$flag = $_POST['flag'];
		if($flag == 1){
			$url = $this->uploadfile($file,"promotion");
		}else if($flag == 2){
			$url = $this->uploadfile($file,"delivery");
		}else if($flag == 3){
			$url = $this->uploadfile($file,"redPacket");
		}
		
		echo json_encode($url);
		
	}
	
	
	/*
	店铺优惠券列表 xzx
	shopId: 店铺id
	*/
	public function shop_promotion_list(){
		$shopId = $_POST['shopId'];
		$shop_list = Db::name('discount')->where('discount_shopId',$shopId)->where('discount_delete',1)->order('discount_id desc')->select();
		$new_array = array();
		foreach($shop_list as $k=>$v){
			$new_array[$k]['discount_id'] = $v['discount_id'];
			$new_array[$k]['discount_startDate'] = date("Y-m-d",$v['discount_startDate']);
			$new_array[$k]['discount_endDate'] = date("Y-m-d",$v['discount_endDate']);
			$new_array[$k]['discount_name'] = $v['discount_name'];
			$new_array[$k]['discount_img'] = LINQUAN_IMG.$v['discount_img'];
			if($v['discount_flag'] == 1){
				$new_array[$k]['discount_type'] = '优惠券';
			}else if($v['discount_flag'] == 2){
				$new_array[$k]['discount_type'] = '满减送';
			}else if($v['discount_flag'] == 3){
				$new_array[$k]['discount_type'] = '红包';
			}
			$new_array[$k]['discount_consume'] = $v['discount_consume'];
			$new_array[$k]['discount_value'] = $v['discount_value'];
			$new_array[$k]['discount_flag'] = $v['discount_flag'];
			
			//判断该优惠券是否还能领取的状态(0:还可以领取；1:不能领取)
			$count = Db::name('discount_log')->where('discount_id',$v['discount_id'])->count();
			$new_array[$k]['status'] = ($count < $v['discount_num'])?0:1;
		}
		
		echo json_encode($new_array);die;
	}
	
	
	//领取优惠券
	public function receive_promotion(){
		$userId = (int)session('WST_USER.userId');
		$discount_flag = $_POST['discount_flag'];
		$discount_id = $_POST['discount_id'];
		$shopId = $_POST['id'];
		
		$where['discount_id'] = $discount_id;
		$where['userId'] = $userId;
		$is_receive = Db::name('discount_log')->where($where)->count();
		if($is_receive){
			$datas['flag'] = -1;
			$datas['msg'] = '该券已领过了';
			echo json_encode($datas);die;
		}else{
			$map['userId'] = $userId;
			$map['time'] = time();
			$map['is_use'] = 0;
			$map['discount_id'] = $discount_id;
			$res = Db::name('discount_log')->insert($map);
			if($res){
				$datas['flag'] = 1;
				$datas['msg'] = '领取成功';
			}else{
				$datas['flag'] = -2;
				$datas['msg'] = '领取失败';
			}
		}
		echo json_encode($datas);die;
	}
	
	
	/*
	保存图片  xzx
	file：上传的文件内容
	names：要保存图片路径
	*/
	function uploadfile($file,$names){
        $filename="./upload/".$names;
        if(!is_dir($filename)){
            mkdir($filename);
        }
        if ($_FILES['upload_file']['error'] > 0)
        {
        
          if($_FILES['upload_file']['error']==1){
            $data['res']=-1;
            $data['msg']='图片大小超出上传限制';
            return $data;
          }else if($_FILES['upload_file']['error']==2){
            $data['res']=1;
            $data['msg']='文件只被部分上载';
            return $data;
          }else{
            $data['res']=1;
            $data['msg']='上传文件不全，请重新上传';
            return $data;
          }
        }
        $tp = array("image/gif","image/pjpeg","image/jpeg","image/png"); 
        if (!in_array($_FILES['upload_file']["type"],$tp))
        {   
            $data['res']=1;
            $data['msg']='上传图片类型不是jpg/gif/png';
            return $data;
        } 
        $putname=$filename;
        $aa=md5($_FILES['upload_file']['name'].time()).".png";
        $upfile=$putname."/".$aa;   //系统默认jpg（不加字段）
        if(is_uploaded_file($_FILES['upload_file']['tmp_name'])) //判断是否为上传文件
        {
           if (!move_uploaded_file($_FILES['upload_file']['tmp_name'], $upfile))//移动文件
           {
              $data['res']=1;
              $data['msg']='上传失败';
              return $data;
           }else{
              $data['res']=2;
              $data['msg']=substr($upfile,2);
              return $data;
           }
        }      
        
    }

	
	
}
