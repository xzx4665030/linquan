<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\GoodsCats as M;
/**

 * 商品分类控制器
 */
class GoodsCats extends Base{
	
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
    /**
     * 获取列表
     */
    public function listQuery(){
    	$m = new M();
    	$rs = $m->listQuery(input('parentId/d',0));
    	return WSTReturn("", 1,$rs);
    }
    /**
     * 获取商品分类
     */
    public function get(){
    	$m = new M();
    	return $m->get((int)Input("post.id"));
    }
    
    /**
     * 设置是否推荐/不推荐
     */
    public function editiIsFloor(){
    	$m = new M();
    	return $m->editiIsFloor();
    }
       
    /**
     * 设置是否显示/隐藏
     */
    public function editiIsShow(){
    	$m = new M();
    	return $m->editiIsShow();
    }
    
    /**
     * 新增
     */
    public function add(){
    	$m = new M();
    	return $m->add();
    }
    
    /**
     * 编辑
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
