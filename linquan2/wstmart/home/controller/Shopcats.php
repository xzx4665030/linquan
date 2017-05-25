<?php
namespace wstmart\home\controller;
use wstmart\common\model\ShopCats as M;
/**
 * 门店分类控制器
 */
class Shopcats extends Base{

  /**
   * 列表
   */
  public function index(){
    $m = new M();
    $list = $m->getCatAndChild(session('WST_USER.shopId'),input('post.parentId/d'));
    $this->assign('list',$list);
    return $this->fetch("shops/shopcats/list");
  }
  
    /**
     * 修改名称
     */
    public function editName(){
      $m = new M();
      $rs = array();
      if(input('post.id/d')>0){
        $rs = $m->editName();
      }
      return $rs;
    }
    /**
     * 修改排序
     */
    public function editSort(){
      $m = new M();
      $rs = array();
      if(input('post.id/d')>0){
        $rs = $m->editSort();
      }
      return $rs;
    }
    /**
     * 批量保存商品分类
     */
    public function batchSaveCats(){
      $m = new M();
      $rs = $m->batchSaveCats();
      return $rs;
    }
    /**
     * 删除操作
     */
    public function del(){
      $m = new M();
      $rs = $m->del();
      return $rs;
    }
    
    /**
     * 列表查询
     */
    public function listQuery(){
      $m = new M();
      $list = $m->listQuery((int)session('WST_USER.shopId'),input('post.parentId/d'));
      $rs = array();
      $rs['status'] = 1;
      $rs['list'] = $list;
      return $rs;
    }
    
    public function changeCatStatus(){
      $m = new M();
      $rs = $m->changeCatStatus();
      return $rs;
    }


    /**
     * 添加图片   lxt
     */
    public function add_img(){
        $file = $_FILES;
        $catId=$_GET['id'];
        $res = $this->uploadfile($file);
        if($res['res']==2){
          $data['img']=$res['msg'];
          $res1=db('shop_cats')->where('catId',$catId)->update($data);
        }
        return $res;
    }

    /**
    * 文件上传
    */
    function uploadfile(){
        $filename="./upload/goodscatss";
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
