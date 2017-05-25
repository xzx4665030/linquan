<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\LogMoneys as M;
/**
 * 进销存-配置控制器  xzx
 */
use think\Db;
class Configure extends Base{
	
    public function index(){
		/*  IP定位经纬度
		$ip = $this->getIP();
		$url = "http://restapi.amap.com/v3/ip?key=20679e9d465cbce35f1009ee74be3e92&ip=".$ip;
		$result = $this->https_request($url);
		$arr = json_decode($result,true);
		$jingwei = explode(";",$arr['rectangle']);
		$jwd = $jingwei[0];
		$this->assign('jwd',$jwd);
		*/
		// $supplier_group=db('supplier_group')->where('dataFlag','1')->select();
		// $this->assign('supplier_group',$supplier_group);
		$province=db('areas')->where('areaType','0')->where('dataFlag','1')->select();
		$this->assign('province',$province);
		
		$stock_list = db('roles')->where('dataFlag',1)->where("roleName","like","%仓库%")->select();
		$this->assign('stock_list',$stock_list);
		//$province=db('areas')->where('areaType','0')->where()->select();
    	return $this->fetch("list");
    }
	
	//获取网店列表
	public function pageQueryByShop(){
		$key = input('key');
		$where = [];
		$where['dataFlag'] = 1;
		$where['shop_flag'] = 1;
        $where['shopName'] = ['like','%'.$key.'%'];
		return db('shops')->where($where)->field('shopName,telephone,shopAddress,shopkeeper,shopId')->paginate(input('pagesize/d'));
	}
    
    /**
     * 添加网店
     */
    public function add_shop(){
		$loginName = $_POST['loginName'];
		$shopName = $_POST['shopName'];
		$pwd = $_POST['pwd'];
		$shopkeeper = $_POST['shopkeeper'];
		$telephone = $_POST['telephone'];
		$shopAddress = $_POST['shopAddress'];
		$lngX = $_POST['lngX'];
		$latY = $_POST['latY'];
		
		if(empty($shopName)) return WSTReturn("网点名称没有填写", -1);
		if(empty($loginName)) return WSTReturn("账号没有填写", -1);
		if(empty($pwd)) return WSTReturn("密码没有填写", -1);
		if(empty($shopkeeper)) return WSTReturn("联系人没有填写", -1);
		if(empty($telephone)) return WSTReturn("联系电话没有填写", -1);
		if(empty($shopAddress)) return WSTReturn("网店地址没有填写", -1);
		if(empty($lngX) && empty($latY)) return WSTReturn("地图坐标没有选择", -1);
		
		$des = Db::name('users')->where('loginName',$loginName)->find();
		$shops = db('shops')->where('userId',$des['userId'])->find();
		if($shops){    //已经注册过店铺
			//$this->error('店铺已注册过');
			return WSTReturn("店铺已注册过", -1);
		}		
		
	    if($des){   //买家手机已注册
			$res = $des['userId'];
		}else{
			//先插入用户表
			$data['loginName'] = $loginName;
			$data["loginSecret"] = rand(1000,9999);
			$data['loginPwd'] = md5($pwd.$data['loginSecret']);
			//$data['loginSecret'] = $data['loginSecret'];
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
		$dat['shopName'] = $shopName;
		$dat['shopkeeper'] = $shopkeeper;
		$dat['telephone'] = $loginName;
		$dat['shopCompany'] = '';
		$dat['shopImg'] = '';
		$dat['shopTel'] = $telephone;
		$dat['shopAddress'] = $shopAddress;
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
		//$dat['shop_class'] = $shop_class;
		$dat['jwd'] = $lngX."|".$latY;
		$dat['shop_flag'] = 1;
		$ress = db("shops")->insertGetId($dat);
		
		if($ress){
			return WSTReturn("添加成功", 1);
		}else{
			//$this->error('添加失败',url('admin/configure/index'));
			return WSTReturn("添加失败", -1);
		}
		
    }
	
	/*
	获取网店信息  xzx
	*/
	public function get_shop(){
		$id = $_POST['id'];
		return db('shops')->alias("s")->join("users u","s.userId=u.userId")->where('shopId',$id)->field('s.shopName,s.telephone,s.shopAddress,s.shopkeeper,s.shopId,u.loginName')->find();		
	}
	
	
	//修改网点信息
	public function edit_shop(){
		$id = $_POST['expressId'];  //店铺id
		$loginName = $_POST['loginName'];
		$shopName = $_POST['shopName'];
		$pwd = $_POST['pwd'];
		$shopkeeper = $_POST['shopkeeper'];
		$telephone = $_POST['telephone'];
		$shopAddress = $_POST['shopAddress'];
		$lngX = $_POST['lngX'];
		$latY = $_POST['latY'];
		
		if(empty($shopName)) return WSTReturn("网点名称没有填写", -1);
		if(empty($loginName)) return WSTReturn("账号没有填写", -1);
		if(empty($pwd)) return WSTReturn("密码没有填写", -1);
		if(empty($shopkeeper)) return WSTReturn("联系人没有填写", -1);
		if(empty($telephone)) return WSTReturn("联系电话没有填写", -1);
		if(empty($shopAddress)) return WSTReturn("网店地址没有填写", -1);
		if(empty($lngX) && empty($latY)) return WSTReturn("地图坐标没有选择", -1);		
		
		$data['shopName'] = $shopName;
		$data['shopkeeper'] = $shopkeeper;
		$data['shopTel'] = $telephone;
		$data['shopAddress'] = $shopAddress;
		$data['jwd'] = $lngX."|".$latY;
		$data['telephone'] = $loginName;
		$res = db('shops')->where('shopId',$id)->update($data);
		
		$shop_info = db('shops')->where('shopId',$id)->find();
		$datas['loginName'] = $loginName;
		$datas["loginSecret"] = rand(1000,9999);
		$datas['loginPwd'] = md5($pwd.$datas['loginSecret']);
		//$datas['loginSecret'] = $datas['loginSecret'];
		$datas['userPhone'] = $loginName;
		$user_res = db('users')->where('userId',$shop_info['userId'])->update($datas);
		
		if($res && $user_res){
			$msg['status'] = 1;
			$msg['msg'] = "编辑成功";
		}else{
			$msg['status'] = 2;
			$msg['msg'] = "编辑失败";
		}
		echo json_encode($msg);
		
	}
	
	
	/*
	删除网店  xzx
	*/
	public function del_shop(){
		$shopId = $_POST['id'];
		
		$data['dataFlag'] = -1;
		$res = db("shops")->where('shopId',$shopId)->update($data);
		if($res){
			$msg['status'] = 1;
			$msg['msg'] = "删除成功";
		}else{
			$msg['status'] = 2;
			$msg['msg'] = "删除失败";
		}
		echo json_encode($msg);
		
	}
	
	
	
	//网店库存渲染页面  xzx
	public function shop_stock(){
		$shop_id = $_GET['id'];
		$shop_info = db('shops')->where('shopId',$shop_id)->find();
		$this->assign('object',$shop_info);
		return $this->fetch('list_log1');
	}
	
	//网店库存获取商品表  xzx
	public function pageQueryShopGoods(){
		$shop_id = $_GET['id'];
		$where['shopId'] = $shop_id;
		$where['is_transfer'] = 1;
		$goods = db('goods')->alias('g')->join('call_goods cg','cg.call_goods_ids=g.transfer_id')->join('supplier_goods s','s.id=cg.call_goods_id')->where($where)->paginate(input('pagesize/d'))->toArray();
		return $goods;
	}
	
	
	//获取仓库列表  xzx
	public function pageQueryByStock(){
		$key = input('s2_type');
		$stock_list = db('roles')->where('dataFlag',1)->where("roleName","like","%仓库%")->select();
		foreach($stock_list as $value){
			$arr[] = $value['roleId'];
		}
		
		$where = [];
		$where['s.dataFlag'] = 1;
		$where['staffStatus'] = 1;
        // $where['loginName'] = ['like','%'.$key.'%'];
        if(empty($key)){
            $where['staffRoleId'] = ['in',$arr];
        }else{
        	$where['staffRoleId']=$key;
        }
		
		$list =  db('staffs')->alias('s')->join('roles r','r.roleId=s.staffRoleId')->where($where)->field('s.loginName,r.roleName,s.createTime,s.tel,s.staffId,r.roleId')->paginate(input('pagesize/d'));
		return $list;
	}
	
	
	//编辑仓库显示页面 xzx
	public function get_stock(){
		$id = $_POST['id'];
		$where['dataFlag'] = 1;
		$where['staffStatus'] = 1;
        $where['staffId'] = $id;
		$list = db('staffs')->where($where)->field('staffId,tel,loginName,staffRoleId')->find();
		//var_dump($list);
		return $list;
	}
	
	
	//处理仓库  xzx
	public function edit_stock(){
		$id = $_POST['expressId'];
		
		$loginName = $_POST['loginName'];
		$loginPwd = $_POST['loginPwd'];
		$tel = $_POST['tel'];
		$staffRoleId = $_POST['staffRoleId'];
		$staffStatus = $_POST['staffStatus'];
				
		if(empty($loginName)) return WSTReturn("管理账号没有填写", -1);
		if(empty($loginPwd)) return WSTReturn("登录密码没有填写", -1);
		if(empty($tel)) return WSTReturn("联系方式没有填写", -1);
		if(empty($staffRoleId)) return WSTReturn("分组没有填写", -1);
		if(empty($staffStatus)) return WSTReturn("状态没有填写", -1);
		
		$data['loginName'] = $loginName;
		$data["secretKey"] = rand(1000,9999);
		$data['loginPwd'] = md5($loginPwd.$data['secretKey']);
		$data['staffStatus'] = $staffStatus;
		$data['staffRoleId'] = $staffRoleId;
		$data['tel'] = $tel;
		
		
		$res = db('staffs')->where('staffId',$id)->update($data);
		if($res !== false){
			return WSTReturn("编辑成功", 1);
		}else{
			return WSTReturn("编辑失败", -1);
		}
	}
	
	
	//删除仓库  xzx
	public function del_stock(){
		$id = $_POST['id'];
		//var_dump($id);
		$data['dataFlag'] = -1;
		$res = db('staffs')->where('staffId',$id)->update($data);
		if($res){
			$msg['status'] = 1;
			$msg['msg'] = "删除成功";
		}else{
			$msg['status'] = 2;
			$msg['msg'] = "删除失败";
		}
		echo json_encode($msg);
	}
	
	
	//添加仓库   xzx
	public function add_stock(){
		$loginName = $_POST['loginName'];
		$loginPwd = $_POST['loginPwd'];
		$tel = $_POST['tel'];
		$staffRoleId = $_POST['staffRoleId'];
		$staffStatus = $_POST['staffStatus'];
		
		
		if(empty($loginName)) return WSTReturn("管理账号没有填写", -1);
		if(empty($loginPwd)) return WSTReturn("登录密码没有填写", -1);
		if(empty($tel)) return WSTReturn("联系方式没有填写", -1);
		if(empty($staffRoleId)) return WSTReturn("分组没有填写", -1);
		if(empty($staffStatus)) return WSTReturn("状态没有填写", -1);
		
		
		$des = Db::name('staffs')->where('loginName',$loginName)->find();
		if($des){    //已经注册过店铺
			//$this->error('店铺已注册过');
			return WSTReturn("账号已注册过", -1);
		}
		
		$data['loginName'] = $loginName;
		$data["secretKey"] = rand(1000,9999);
		$data['loginPwd'] = md5($loginPwd.$data['secretKey']);
		$data['staffStatus'] = $staffStatus;
		$data['staffRoleId'] = $staffRoleId;
		$data['tel'] = $tel;
		$data['dataFlag'] = 1;
		$data['createTime'] = date('Y-m-d H:i:s',time());
		$res = db('staffs')->insert($data);
		if($res){
			return WSTReturn("新增成功", 1);
		}else{
			return WSTReturn("新增失败", -1);
		}
		
		
	}

    /*
	供应商分组列表  lxt
	*/
	public function supplier_group(){
	  $where=array();
	  if(!empty($_GET['s4_key'])){
        $where['group_name']=array('like','%'.$_GET['s4_key'].'%');
	  }
	  $where['dataFlag'] = 1;

	  $res=db('supplier_group')->where($where)->paginate(input('pagesize/d'));
	  return $res;
	}

	/*
	  获取供应商分组列表  lxt
	*/
	  public function supplier_groups(){
	  	 $where['dataFlag'] = 1;
	  	 $res=db('supplier_group')->where($where)->select();
		 return $res;
	  }

    /*
	添加供应商分组  lxt
	*/
	public function add_group(){
		$group_name=$_POST['group_name'];
		$sort=$_POST['sort'];
		$remark=$_POST['remark'];

		$data['group_name']=$group_name;
		$data['sort']=$sort;
		$data['remark']=$remark;
		$data['dataFlag']=1;
		$data['time']=date("Y-m-d H:i:s",time());
        $res=Db::name('supplier_group')->insert($data);
        if($res){
            return WSTReturn("新增成功", 1);
        }else{
            return WSTReturn('新增失败',-1);	
        }

	}


	/*
	修改供应商分组  lxt
	*/
	public function edit_group(){
        
		$id=$_POST['id'];
		$group_name=$_POST['group_name'];
		$sort=$_POST['sort'];
		$remark=$_POST['remark'];
        
		$data['group_name']=$group_name;
		$data['sort']=$sort;
		$data['remark']=$remark;
        $res=Db::name('supplier_group')->where('id',$id)->update($data);
        if($res !== false){
            return WSTReturn("修改成功", 1);
        }else{
            return WSTReturn('修改失败',-1);	
        }

	}

	/*
	删除供应商分组  lxt
	*/
	public function del_group(){
		$ids=$_POST['ids'];
		$arr=array_filter(explode(',', $ids));
		foreach ($arr as $key => $value) {
			$data['dataFlag']='-1';
			$res=Db::name('supplier_group')->where('id',$value)->update($data);
		}
        
        if($res){
            return WSTReturn('删除成功',1);
        }else{
            return WSTReturn("删除失败", -1);	
        }

	}

	/*
	显示编辑  lxt
	*/
	public function get_group(){
		$id=$_POST['id']; 
		$res=db('supplier_group')->where('id',$id)->find();
		return $res;
	}
    

    /*
	供应商列表  lxt
	*/
    public function supplier(){
      $where = array();
      if(!empty($_GET['s3_type'])){
         $where['a.group_id']=$_GET['s3_type'];
      }
      if(!empty($_GET['s3_status'])){
         $where['a.status']=$_GET['s3_status'];
      }
      if(!empty($_GET['s3_key'])){
            $where['a.company']=array('like','%'.$_GET['s3_key'].'%');
      }
      if(!empty($_GET['startDateC']) && empty($_GET['endDateC']) ){
            $where['a.times']=array('gt',strtotime($_GET['startDateC']));
      }
      if(empty($_GET['startDateC']) && !empty($_GET['endDateC']) ){
            $where['a.times']=array('lt',strtotime($_GET['endDateC']));
      }
      if(!empty($_GET['startDateC']) && !empty($_GET['endDateC']) ){
            $where['a.times']=array('between',array(strtotime($_GET['startDateC']),strtotime($_GET['endDateC'])));
      }
	  $where['a.dataFlag'] = 1;
	  $res=db('supplier')->alias('a')->join('supplier_group b','a.group_id=b.id','inner')->where($where)->paginate(input('pagesize/d'))->toArray();
	  foreach ($res['Rows'] as $key => $value) {
	  	 $res['Rows'][$key]['times']=date('Y-m-d H:i:s',$value['times']);
	  	 
	  }
	  return $res;
    }

    /*
	添加供应商列表  lxt
	*/
    public function supplier_add(){
        $company=$_POST['company'];
		$introductions=$_POST['introductions'];
		$contact=$_POST['contact'];
		$mobile=$_POST['mobile'];
		$dianhua=$_POST['dianhua'];
		$qqNum=$_POST['qqNum'];
		$email=$_POST['email'];
		$postcode=$_POST['postcode'];
		$locality=$_POST['locality'];
		$address=$_POST['address'];
		$group_id=$_POST['group_id'];
		$status=$_POST['status'];
		$remarks=$_POST['remarks'];
        
		$data['company']=$company;
		$data['introductions']=$introductions;
		$data['contact']=$contact;
		$data['mobile']=$mobile;
		$data['dianhua']=$dianhua;
		$data['qqNum']=$qqNum;
		$data['email']=$email;
		$data['postcode']=$postcode;
		$data['locality']=$locality;
		$data['address']=$address;
		$data['group_id']=$group_id;
		$data['status']=$status;
		$data['remarks']=$remarks;

		$data['dataFlag']=1;
		$data['times']=time();
        $res=Db::name('supplier')->insert($data);
        if($res){
            return WSTReturn("新增成功", 1);
        }else{
            return WSTReturn('新增失败',-1);	
        }
    }

    /*
	显示编辑  lxt
	*/
	public function get_supplier(){
		$id=$_POST['id']; 
		$res=db('supplier')->where('id',$id)->find();
		return $res;
	}


	/*
	编辑供应商列表  lxt
	*/
	public function supplier_edit(){
		$id=$_POST['id'];
		$company=$_POST['company'];
		$introductions=$_POST['introductions'];
		$contact=$_POST['contact'];
		$mobile=$_POST['mobile'];
		$dianhua=$_POST['dianhua'];
		$qqNum=$_POST['qqNum'];
		$email=$_POST['email'];
		$postcode=$_POST['postcode'];
		$locality=$_POST['locality'];
		$address=$_POST['address'];
		$group_id=$_POST['group_id'];
		$status=$_POST['status'];
		$remarks=$_POST['remarks'];
        
		$data['company']=$company;
		$data['introductions']=$introductions;
		$data['contact']=$contact;
		$data['mobile']=$mobile;
		$data['dianhua']=$dianhua;
		$data['qqNum']=$qqNum;
		$data['email']=$email;
		$data['postcode']=$postcode;
		$data['locality']=$locality;
		$data['address']=$address;
		$data['group_id']=$group_id;
		$data['status']=$status;
		$data['remarks']=$remarks;
        $res=Db::name('supplier')->where('id',$id)->update($data);
        if($res !== false){
            return WSTReturn("修改成功", 1);
        }else{
            return WSTReturn('修改失败',-1);	
        }

	}


	/*
	批量删除供应商  lxt
	*/
	public function dels_supplier(){
		$ids=$_POST['ids'];
		$arr=array_filter(explode(',', $ids));
		foreach ($arr as $key => $value) {
			$data['dataFlag']='-1';
			$res=Db::name('supplier')->where('id',$value)->update($data);
		}
        
        if($res){
            return WSTReturn('删除成功',1);
        }else{
            return WSTReturn("删除失败", -1);	
        }

	}

	/*
	删除供应商  lxt
	*/
	public function del_supplier(){
		$id=$_POST['id'];
		$data['dataFlag']='-1';
		$res=Db::name('supplier')->where('id',$id)->update($data);	
        if($res){
            return WSTReturn('删除成功',1);
        }else{
            return WSTReturn("删除失败", -1);	
        }
    }

    /*
	获取供应商分组  lxt
	*/
	public function get_groups(){
        $supplier_group=db('supplier_group')->where('dataFlag','1')->select();
        return $supplier_group;
	}

	/*
	仓库库存  lxt
	*/

	public function sum_store(){
	  $id=$_GET['id'];
	  $res=db('roles')->where('roleId',$id)->find();
	  $this->assign('roles',$res);
	  $supplier=db('supplier')->where('dataFlag',1)->select();
	  $this->assign('supplier',$supplier);
      return $this->fetch('list_log2');
	}

	/*
	仓库商品  lxt
	*/

	public function sum_goods(){
		$id=$_GET['id'];
        if(!empty($_GET['p_id'])){
           $where['a.supplier_id']=$_GET['p_id'];
           $where['a.dataFlag']=1;
           $where['a.store_id']=$id;
        }else{
        	$where['a.dataFlag']=1;
            $where['a.store_id']=$id;
        }
		$goods=db('purchase')->alias('a')->join('purchase_good b','a.pur_number=b.p_number','left')->where($where)->paginate(input('pagesize/d'))->toArray();
		$arr=array();
		foreach ($goods['Rows'] as $key => $value) {
			$manager=db('staffs')->where('staffId',$value['manager_id'])->find();
			$good=db('supplier_goods')->where('id',$value['p_good_id'])->find();
			$good_spec=db('supplier_goods_spec')->where('s_huohao',$value['p_huohao'])->find();
            $arr['Rows'][$key]['goodName']=$good['goodsName'];
            $arr['Rows'][$key]['huohao']=$value['p_huohao'];
            $arr['Rows'][$key]['pur_number']=$value['pur_number'];
            $arr['Rows'][$key]['pnumber']=$value['pnumber'];
            $arr['Rows'][$key]['manager']=$manager['loginName'];
            $arr['Rows'][$key]['pur_time']=$value['pur_time'];
            if(empty($good_spec)){
               $arr['Rows'][$key]['marketPrice']=$good['marketPrice'];
               $arr['Rows'][$key]['shopPrice']=$good['shopPrice'];
               $arr['Rows'][$key]['spec_value']='';
            }else{
               $arr['Rows'][$key]['marketPrice']=$good_spec['marketPrice'];
               $arr['Rows'][$key]['shopPrice']=$good_spec['specPrice'];
               $specs=array_filter(explode(',', $good_spec['spec_value']));
	           $aaa='';
	           foreach ($specs as $k => $v) {
	             $aaa=$aaa.$v.'/';
	           }
               $arr['Rows'][$key]['spec_value']=$aaa;
            }
		}
       
		return $arr;
	}
}
