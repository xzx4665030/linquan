<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\Accreds as M;
/**

 * 商家认证控制器
 */
 use think\Db;
class Mobile extends Base{
	
    /**
     * 首页  lxt
     */
    public function index(){
        
        return $this->fetch("list");
    }

    /**
     * 首页内容  lxt
     */
    public function pageQueryByMobile(){
        $where['dataFlag'] = 1;
        $where['special_id']=array('gt',2);
        return db('mb_special')->where($where)->paginate(input('pagesize/d'));
    }

    /**
     * 添加专题   lxt
     */
    public function special_add(){
        $special_desc=$_POST['special_desc'];
        $data['special_desc']=$special_desc;
        $data['dataFlag']=1;
        $res=db('mb_special')->insert($data);
        if($res){
            return WSTReturn("添加成功", 1);
        }else{
            return WSTReturn("添加失败", -1);
        }
    }
    

    /**
     * 编辑专题  lxt
     */
    public function special_get(){
        $id=$_POST['id'];
        return db('mb_special')->where('special_id',$id)->find();
    }
    
    /**
     * 修改专题   lxt
     */
    public function special_edit(){
        $id=$_POST['id'];
        $special_desc=$_POST['special_desc'];
        $data['special_desc']=$special_desc;
        $res=db('mb_special')->where('special_id',$id)->update($data);
        if($res !== false){
            return WSTReturn("修改成功", 1);
        }else{
            return WSTReturn("修改失败", -1);
        }
    }

    /**
     * 删除专题  lxt
     */
    public function special_del(){
        $id=$_POST['id'];
        $res=db('mb_special')->where('special_id',$id)->delete();
        if($res){
            return WSTReturn("删除成功", 1);
        }else{
            return WSTReturn("删除失败", -1);
        }
    }


    /**
     * 专题项目首页  lxt
     */
    public function item_index(){
       $id=$_GET['id'];
      
       $this->assign('id',$id); 
       return $this->fetch('edit');
    }

    /**
     * 专题项目数据  lxt
     */
    public function item(){
      //var_dump($_POST);die;
       $id=$_POST['id'];
       $item=db('mb_special_item')->where('special_id',$id)->where('dataFlag',1)->order('item_sort asc')->select();
       
       foreach ($item as $key => $value) {
           $item[$key]['item_data']=unserialize($value['item_data']);
           if($item[$key]['item_type']=='adv_list' || $item[$key]['item_type']=='home1' || $item[$key]['item_type']=='home3'){
                if(!empty($item[$key]['item_data']['item'])){
                    $item[$key]['item_data']['item']=array_values($item[$key]['item_data']['item']);
                }
                
           }
           elseif ($item[$key]['item_type']=='goods') {
            if(!empty($item[$key]['item_data']['item'])){
              foreach ($item[$key]['item_data']['item'] as $k => $v) {
               $good=db('goods')->where('goodsId',$v['goodsId'])->field('goodsName,goodsImg,shopPrice')->find();
               $good['goodsImg']=LINQUAN_IMG.$good['goodsImg'];
               $item[$key]['item_data']['item'][$k]=$good;
             }
            }
             
           } 

           elseif($item[$key]['item_type']=='home5'){
            if(!empty($item[$key]['item_data']['item'])){
            foreach ($item[$key]['item_data']['item'] as $k => $v) {
               $shop=db('shops')->where('shopId',$v['shopId'])->field('shopId,shopName,shopImg')->find();
               $shop['shopImg']=LINQUAN_IMG.$shop['shopImg'];
               $item[$key]['item_data']['item'][$k]=$shop;
            }
            }
        }   
       }
       //var_dump($item); die;
       return $item;
    }


    /**
     * 首页 lxt
     */
    public function item_indexs(){  
      $id=1;
       $this->assign('id',$id); 
       return $this->fetch('edit');
    }

    /**
     * 网点首页 lxt
     */
    public function item_indexss(){  
       $id=2;
       $this->assign('id',$id); 
       return $this->fetch('edit');
    }


    /**
     * 添加专题项目  lxt
     */
    public function item_add(){
       $id=$_POST['id'];
       $type=$_POST['lb'];
       if($type==1){
         $data['item_type']='adv_list';
       }elseif($type==2){
         $data['item_type']='home1';
       }elseif($type==3){
         $data['item_type']='home2';
       }elseif($type==4){
         $data['item_type']='goods';
       }elseif($type==5){
         $data['item_type']='home3';
       }elseif($type==6){
         $data['item_type']='home4';
       }elseif($type==7){
         $data['item_type']='home5';
       }
       $data['special_id']=$id;
       $data['dataFlag']=1;
       $res=db('mb_special_item')->where('special_id',$id)->where('dataFlag',1)->count();
       $data['item_sort']=$res;
       $res1=db('mb_special_item')->insert($data);
       if($res1){
          return  1;
       }else{
          return 2;
       }
    }

     /**
     * 专题项目排序  lxt
     */
    public function item_sort(){
       $id=$_POST['id']; 
       $sort=$_POST['xl'];
       if(!empty($sort)){
         $arr=array_filter(explode(',', $sort));
         $aaa='';
         foreach ($arr as $key => $value) {
             $data['item_sort']=$key;
             $res=db('mb_special_item')->where('item_id',$value)->where('special_id',$id)->update($data);
         }
       }
    }


    /**
     * 删除专题项目  lxt
     */
    public function item_del(){
       $id=$_POST['id']; 
       $data['dataFlag']=-1;
       $res=db('mb_special_item')->where('item_id',$id)->update($data);
       if($res){
         return 1;
       }else{
         return 2;
       }
    }

    /**
     * 编辑专题项目  lxt
     */
    public function item_edit(){
       $id=$_GET['id']; 
       $this->assign('id',$id);
       $leibie=$_GET['leibie'];
       if($leibie==1){
         return $this->fetch('item_1');
       }elseif($leibie==2){
         return $this->fetch('item_2');
       }elseif($leibie==3){
         return $this->fetch('item_3');
       }elseif($leibie==4){
         return $this->fetch('item_4');
       }elseif($leibie==5){
         return $this->fetch('item_5');
       }elseif($leibie==6){
         return $this->fetch('item_6');
       }
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
        $filename="./upload/mobile";
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


    /**
     * 编辑项目内容   lxt
     */
    public function edit_item(){
        $id=$_POST['id'];
        $data=$_POST['data'];
        //保存
        if(!empty($data)){
            $datas['item_data']=serialize($data);
        }else{
            $datas['item_data']='';
        }
        
        $res=db('mb_special_item')->where('item_id',$id)->update($datas);
        if($res !== false){
          return 1;
        }else{
          return 2;
        }
    }


    /**
     * 获取项目内容   lxt
     */
    public function get_item(){
        $id=$_POST['id'];
        $res=db('mb_special_item')->where('item_id',$id)->find();
       
        $res['item_data']=unserialize($res['item_data']);
        if($res['item_type']=='goods'){
          if(!empty($res['item_data']['item'])){
            foreach ($res['item_data']['item'] as $k => $v) {
               $good=db('goods')->where('goodsId',$v['goodsId'])->field('goodsId,goodsName,goodsImg,shopPrice')->find();
               $good['goodsImg']=LINQUAN_IMG.$good['goodsImg'];
               $res['item_data']['item'][$k]=$good;
             }
          }
        }
        if($res['item_type']=='home5'){
          if(!empty($res['item_data']['item'])){
              foreach ($res['item_data']['item'] as $k => $v) {
               $shop=db('shops')->where('shopId',$v['shopId'])->field('shopId,shopName,shopImg')->find();
               $shop['shopImg']=LINQUAN_IMG.$shop['shopImg'];
               $res['item_data']['item'][$k]=$shop;
             }
          }
            
        }
        // if($res['item_type']=='adv_list' || $res['item_type']=='home1' || $res['item_type']=='home3'){
        //     if(!empty($res['item_data'])){
        //         $res['item_data']=array_values($res['item_data']);
        //     }
                
        // }    

        return $res;
    }

    /**
     * 获取商品   lxt
     */
    public function get_good(){
       $content=$_POST['content'];
       $where['dataFlag']=1;
       $where['isSale']=1;
       $where['goodsStatus']=1;
       $where['is_transfer']=0;
       $where['goodsName']=array('like','%'.$content.'%');
       $goods=db('goods')->where($where)->paginate(20)->toArray();
       $arr=array();
       foreach ($goods['Rows'] as $key => $value) {
         $arr[$key]['goodsId']=$value['goodsId'];
         $arr[$key]['goodsImg']=LINQUAN_IMG.$value['goodsImg'];
         $arr[$key]['goodsName']=$value['goodsName'];
         $arr[$key]['shopPrice']=$value['shopPrice'];
       }
       return $arr;
    }

    /**
     * 获取商品   lxt
     */
    public function get_shop(){
       $content=$_POST['content'];
       $where['dataFlag']=1;
       
       $where['shopStatus']=1;
       
       $where['shopName ']=array('like','%'.$content.'%');
       $goods=db('shops')->where($where)->paginate(20)->toArray();
       $arr=array();
       foreach ($goods['Rows'] as $key => $value) {
         $arr[$key]['shopId']=$value['shopId'];
         $arr[$key]['shopImg']=LINQUAN_IMG.$value['shopImg'];
         $arr[$key]['shopName']=$value['shopName']; 
       }
       return $arr;
    }
}
