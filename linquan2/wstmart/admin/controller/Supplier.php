<?php
namespace wstmart\admin\controller;
use wstmart\common\model\Goods as CGoods;
/**
 * 供应商商品控制器
 */
 use think\Db;
class Supplier extends Base{
	//首页
    public function index(){
        $where['dataFlag'] = 1;
        $where['id']=$_GET['id'];
        $supplier=db('supplier')->where($where)->find();
        $this->assign('supplier',$supplier);
        $cats = db('goods_cats')->where(array('parentId'=>0,'isShow'=>1,'dataFlag'=>1))->select();
        $this->assign('cats',$cats);

    	return $this->fetch("configure/list_log");
    }
    
	//获取商品规格  xzx
    public function get(){
		$class_id = Input('post.class_id/d');
		$goodsCatIds = model('GoodsCats')->getParentIs($class_id);
		$data = [];		
		$specs = Db::name('spec_cats')->where(['dataFlag'=>1,'isShow'=>1,'goodsCatId'=>['in',$goodsCatIds]])->field('catId,catName,isAllowImg')->order('isAllowImg desc,catSort asc,catId asc')->select();
		$spec0 = null;
		$spec1 = [];
		foreach ($specs as $key => $v){
			if($v['isAllowImg']==1){
				$spec0 = $v;
			}else{
				$spec1[] = $v;
			}
		}
		$data['spec0'] = $spec0;
		$data['spec1'] = $spec1;		
		$data['attrs'] = Db::name('attributes')->where(['dataFlag'=>1,'isShow'=>1,'goodsCatId'=>['in',$goodsCatIds]])->field('attrId,attrName,attrType,attrVal')->order('attrSort asc,attrId asc')->select();
		echo json_encode($data);
    }
	
	//添加商品
    public function add_good(){
        $goodsCats = model('GoodsCats')->getParentIs($_POST['class_id']);      
        $class_id = implode('_',$goodsCats)."_";
         
		$goodsName = $_POST['goodsName'];
		$goodsSn = $_POST['goodsSn'];
		$productNo = $_POST['productNo'];
		$goodsImg = $_POST['goodsImg'];
		$marketPrice = $_POST['marketPrice'];
		$shopPrice = $_POST['shopPrice'];
		$goodsStock = $_POST['goodsStock'];
		$goodsUnit = $_POST['goodsUnit'];
		$goodsDesc = $_POST['goodsDesc'];
		$supplierid = $_POST['supplierid'];  //供应商id
		
		if(empty($goodsName)) return WSTReturn("商品名称没有填写", -1);
		if(empty($goodsSn)) return WSTReturn("商品编号没有填写", -1);
		if(empty($productNo)) return WSTReturn("商品货号没有填写", -1);
		if(empty($goodsImg)) return WSTReturn("商品图片没有填写", -1);
		if(empty($marketPrice)) return WSTReturn("进价没有填写", -1);
		if(empty($shopPrice)) return WSTReturn("市场价没有填写", -1);
		if(empty($goodsStock)) return WSTReturn("商品总库存没有选择", -1);
		if(empty($goodsUnit)) return WSTReturn("单位没有填写", -1);
		if(empty($class_id)) return WSTReturn("商品分类没有选择", -1);
		if(empty($goodsDesc)) return WSTReturn("商品描述没有填写", -1);
		
		$data['goodsName'] = $goodsName;
		$data['goodsSn'] = $goodsSn;
		$data['productNo'] = $productNo;
		$data['goodsImg'] = $goodsImg;
		$data['marketPrice'] = $marketPrice;
		$data['shopPrice'] = $shopPrice;
		$data['goodsStock'] = $goodsStock;
		$data['goodsUnit'] = $goodsUnit;
		$data['goodsDesc'] = $goodsDesc;
		$data['goodsCatIdPath'] = $class_id;
		$data['supplier_id'] = $supplierid;
		$data['dataFlag'] = 1;
		$data['createTime'] = date('Y-m-d H:i:s',time());
		$res = db('supplier_goods')->insert($data);
		if($res){
			$msg['status'] = 1;
			$msg['msg'] = "添加成功";
		}else{
			$msg['status'] = 2;
			$msg['msg'] = "添加失败";
		}
		echo json_encode($msg);
		
    }
	
	
	//添加供应商商品规格   id大于0就是编辑
	public function add_spec_cats(){
		$spec_id = $_POST['spec_id'];
		$spec_value = $_POST['spec_value'];
		$marketPrice = $_POST['marketPrice'];
		$shopPrice = $_POST['shopPrice'];
		$goodsStock = $_POST['goodsStock'];
		$alarm = $_POST['alarm'];
		$goods_id = $_POST['goods_id'];
		//var_dump($_POST);die;
		$id = $_POST['id'];
		
		if(empty($spec_value)) return WSTReturn("商品规格没有填写", -1);
		if(empty($marketPrice)) return WSTReturn("市场价没有填写", -1);
		if(empty($shopPrice)) return WSTReturn("本店价没有填写", -1);
		if(empty($goodsStock)) return WSTReturn("库存没有填写", -1);
		if(empty($alarm)) return WSTReturn("库存预警没有填写", -1);
		
		
		//货号
		$huohao = db('supplier_goods')->where('id',$goods_id)->find();
		$count = db('supplier_goods_spec')->where('good_id',$goods_id)->count();
		$huohaos = $huohao['productNo'].'-'.($count+1);
						
		$data['spec_value'] = $spec_value;
		$data['stock'] = $goodsStock;
		$data['warning'] = $alarm;
		$data['marketPrice'] = $marketPrice;
		$data['specPrice'] = $shopPrice;
		
		if($id > 0){			
			$res = db('supplier_goods_spec')->where('s_id',$id)->update($data);

			if($res){
				$msg['status'] = 1;
				$msg['msg'] = '编辑成功';
			}else{
				$msg['status'] = 2;
				$msg['msg'] = '编辑失败';
			}
		}else{
			$data['spec_id'] = $spec_id;
			$data['good_id'] = $goods_id;
			$data['s_huohao'] = $huohaos;
			$data['dataFlag'] = 1;
			$res = db('supplier_goods_spec')->insert($data);
			if($res){
				$msg['status'] = 1;
				$msg['msg'] = '添加成功';
			}else{
				$msg['status'] = 2;
				$msg['msg'] = '添加失败';
			}
		}
		
		echo json_encode($msg);
		
	}
	
	
	/*
	获取供应商添加商品的列表  xzx
	*/
	public function get_supplier(){
		$supplier_id = $_GET['id'];
		$supplier_list = db('supplier_goods')->where('supplier_id',$supplier_id)->where('dataFlag',1)->paginate(input('pagesize/d'));
		//var_dump($supplier_list);die;
		return $supplier_list;		
	}
	
	
	//获取某个商品的不同种规格列表页面  xzx
	public function get_spec_list(){
		$id = $_GET['id'];
		$this->assign('id',$id);
		return $this->fetch('configure/box');
	}
	
	//获取某个商品的不同种规格列表  xzx
	public function get_spec_cats(){
		$goods_id = $_POST['goods_id'];
		//var_dump($goods_id);die;
		$goods_info = db('supplier_goods')->where('id',$goods_id)->find();
		
		//获取不同种规格
		$spec_list = db('spec_cats')->where('goodsCatPath',$goods_info['goodsCatIdPath'])->field('catName,catId')->select();		
		$data['spec_list'] = $spec_list;
		$spec = '';
		//获取规格的名称
		foreach($spec_list as $v){
			$spec = $spec.$v['catName'].',';
		}
		$data['spec_name'] = $spec;
		
		//获取已经添加规格的列表
		$goods_list = db('supplier_goods_spec')->where('good_id',$goods_id)->where('dataFlag',1)->select();
		$data['goods_list'] = $goods_list;
		
		echo json_encode($data);
	}
	
	
	//编辑某个商品某一个规格的数据  xzx
	public function edit_spec_cats(){
		$id = $_POST['id'];
		$list = db('supplier_goods_spec')->where('s_id',$id)->find();
		/*
		$spc = explode(',',$list['spec_value']);
		for($i = 0;$i < count($spc);$i++){
			$list['spc'.$i] = $spc[$i];
		}
		$list['length'] = count($spc)-1;
		*/
		echo json_encode($list);
	}
	
	
	//删除某个商品某一个规格的数据
	public function del_spec_cats(){
		$id = $_POST['id'];
		$data['dataFlag'] = -1;
		$res = db('supplier_goods_spec')->where('s_id',$id)->update($data);
		if($res){
			$msg['status'] = 1;
			$msg['msg'] = '添加成功';
		}else{
			$msg['status'] = 2;
			$msg['msg'] = '添加失败';
		}
		echo json_encode($msg);
		
	}
		
     /**
     * 添加图片   lxt
     */
    public function add_img(){
        $file = $_FILES;
        $res = $this->uploadfile($file);
        return $res;
    }

        /**
    * 文件上传
    */
    function uploadfile(){
        $filename="./upload/goodscats";
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
        $upfile=$putname."/".md5($_FILES['upload_file']['name'].time()).".png";   //系统默认jpg（不加字段）
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
