<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\Accreds as M;
/**
 * 商家认证控制器
 */
 use think\Db;
class Accreds extends Base{
	
    public function index(){
    	return $this->fetch("list");
    }
    /**
     * 获取分页
     */
    public function pageQuery(){
        $m = new M();
        return $m->pageQuery();
    }
    /*
    * 获取数据
    */
    public function get(){
        $m = new M();
        return $m->getById(Input("id/d",0));
    }
    /**
     * 新增
     */
    public function add(){
        $m = new M();
        return $m->add();
    }
    /**
    * 修改
    */
    public function edit(){
        $m = new M();
        return $m->edit();
    }
    /**
     * 删除
     */
    public function del(){
        $m = new M();
        return $m->del();
    }
	
	public function class_index(){
		$cats = db('goods_cats')->where(array('parentId'=>0,'isShow'=>1,'dataFlag'=>1))->select();
        $this->assign('cats',$cats);
		return $this->fetch("classes");
	}
	
	/**
     * 行业分类 xzx
     */
    public function classes(){
        /* $list = db("shop_class")->select();
        $cats = db('goods_cats')->where(array('parentId'=>0,'isShow'=>1,'dataFlag'=>1))->select();
        $this->assign('cats',$cats);
		$this->assign('list',$list);
		return $this->fetch('classes'); */
		
		$list = db('shop_class')->field('class_name,class_id')->paginate(input('pagesize/d'));
		
		return $list;
    }
	
	
	/**
     * 添加行业分类 xzx
     */
    public function add_classes(){
        $name = $_POST['class_name'];
        $show = $_POST['show'];
        $cats_id = $_POST['cats_id'];
		$data['class_name'] = $name;
        $data['show'] = $show;
        $data['cats_id'] = $cats_id;
		$data['add_time'] = time();
		$result = db('shop_class')->insert($data);
		if($result){
			return WSTReturn("行业分类添加成功", 1);
		}else{
			return WSTReturn("行业分类添加失败", -1);
		}
		
    }
	
	//获取行业分类信息
	public function edit_class(){
		$id=$_POST['id'];
		$list = Db::name('shop_class')->where('class_id',$id)->find();
		
		//拆成数组
		$cat_id = explode(',',$list['cats_id']);
		$list['cats_id'] = $cat_id;
		//var_dump($list);
		echo json_encode($list);
	}
	
	
    /**
     * 编辑行业分类 lxt
     */
    public function toEdits(){
       /* $id=$_POST['id'];
       $shop_class=db('shop_class')->where(array('class_id'=>$id))->find();
       $cats = db('goods_cats')->where(array('parentId'=>0,'isShow'=>1,'dataFlag'=>1))->select();
       $this->assign('cats',$cats);
       $this->assign('shop_class',$shop_class); */
       if(!empty($_POST['id'])){
            $name = $_POST['class_name'];
            $show = $_POST['show'];
            $cats_id = $_POST['cats_id'];
            $data['class_name'] = $name;
            $data['show'] = $show;
            $data['cats_id'] = $cats_id;
            $res=db('shop_class')->where(array('class_id'=>$_POST['id']))->update($data);
            if($res){
                return WSTReturn("行业分类修改成功", 1);
            }else{
                return WSTReturn("行业分类修改失败", -1);
            }
       }
    }
    

    /**
     * 删除行业分类 lxt
     */
    public function toDels(){
        $id=$_POST['id'];
        $res=db('shop_class')->where(array('class_id'=>$id))->delete();
        if($res){
          return WSTReturn("行业分类删除成功", 1);
       }else{
          return WSTReturn("行业分类删除失败", -1);
       }
    }
}
