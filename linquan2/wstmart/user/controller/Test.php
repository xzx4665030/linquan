<?php
namespace wstmart\user\controller;
use wstmart\home\model\Goods as M;
use wstmart\common\model\Goods as CM;
/**
 * 会员控制器
 */
//use think\Controller;
use think\Cookie;
use think\Session;
use think\Db;
use think\Paginator;
class Test extends Base{ 
    // public $userinfo;
    // public function __construct(){
       
    //    $token = $_GET['token'];
    //    if(!empty($token)){
    //       $this->is_login($token);
    //       $this->is_available($token);
    //    }     
       
    //    //$user=$this->authcode($token,'DECODE',LINQUAN_KEY,0);
    //    $user=base64_decode($token);
    //    $this->userinfo= $userinfo=db('users')->where('loginName',$user)->find();
    //    return $this->userinfo;
    // }
    /**
    * 商城首页 lxt
    */
    public function index(){
        echo header('Content-type: application/json; charset=utf-8');
        $info=db('mb_special_item')->where('special_id',1)->where('dataFlag',1)->select();
        $arr= $this->index_item($info);
        //分类
        $cats=db('goods_cats')->where('dataFlag',1)->where('isShow',1)->where('parentId',0)->field('catId,catName,img')->select();
        foreach ($cats as $key => $value) {
            $cats[$key]['img']=LINQUAN_IMG.$value['img'];
        }
       $arr['cats']=$cats;
 
      $a='';
      if(!empty($_GET['token'])){
           $token = $_GET['token'];
           $this->is_login($token);
           $this->is_available($token);   
           $user=base64_decode($token);
           $userinfo=db('users')->where('loginName',$user)->find();
           $res=db('history')->where('userId',$userinfo['userId'])->find();
           if($res){
             $a=1;
             
            $new_arr=$this->goods_like($res);
           
            $arr['goods_like']=array_values($new_arr);

           }else{
             $a=3;
           }
      }else{
         if(!empty(cookie('identifiers'))){
           $res=db('history')->where('s_id',cookie('identifiers'))->find();
             if($res){
               $a=2;
               $new_arr=$this->goods_like($res);
                $arr['goods_like']=array_values($new_arr);
          
             }else{
               $a=3;
             }
         }else{
          $a=3;
         }
      }
  
     if($a==3){
        $goods_like=db('goods')->where('dataFlag',1)->where('goodsStatus',1)->where('isSale',1)->where('is_transfer',0)->order('saleNum desc,shopPrice')->paginate(4)->toArray();
        foreach ($goods_like['Rows'] as $key => $value) {
        $arr['goods_like'][$key]['goodsId']=$value['goodsId'];
        $arr['goods_like'][$key]['goodsName']=$value['goodsName'];
        $arr['goods_like'][$key]['goodsTips']=$value['goodsTips'];
        $arr['goods_like'][$key]['goodsImg']=LINQUAN_IMG.$value['goodsImg'];
        $arr['goods_like'][$key]['shopPrice']=$value['shopPrice'];
       }
      }

      if($a==1 || $a==2){
          if(!empty($arr['goods_like'])){
              $count = count($arr['goods_like']);
          }
          $pages=4;
          if(empty($_GET['page'])){
              $f_page=0;
          }else{
              $f_page=($_GET['page']-1)*$pages;
          }
          if($count > $pages){
            $arr['goods_like'] = array_slice($arr['goods_like'],$f_page,$pages);
          }
      }


















       $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
       $datas['data'] = $arr;
       $datas['result'] = true;
       $datas['resultString'] = "首页";
       echo json_encode($datas);die;
    }
    


    /**
    * 专题首页 lxt
    */
    public function item(){
      echo header('Content-type: application/json; charset=utf-8');
      $item_id=$_GET['item_id'];
      $items=db('mb_special')->where('special_id',$item_id)->find();
      $info=db('mb_special_item')->where('special_id',$item_id)->where('dataFlag',1)->select();
      $arr= $this->index_item($info);
        
        if(!empty($arr['goods'])){
            $count = count($arr['goods']);
            $pages=4;
            if(empty($_GET['page'])){
                $f_page=0;
            }else{
                $f_page=($_GET['page']-1)*$pages;
            }
            if($count > $pages){
              $arr['goods'] = array_slice($arr['goods'],$f_page,$pages);
            }
        }
        
       $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
       $datas['data'] = $arr;
       $datas['result'] = true;
       $datas['resultString'] = $items['special_desc'];
       echo json_encode($datas);die;
    }


    /**
    * 优惠券 lxt
    */
    public function coupon(){
      echo header('Content-type: application/json; charset=utf-8');
      $token = $_GET['token'];
      $this->is_login($token);
      $this->is_available($token);   
      $user=base64_decode($token);
      $userinfo=db('users')->where('loginName',$user)->find();
      $time=time();
      $coupon=db('discount')->where('discount_shopId',1)->where('discount_startDate','<',$time)->where('discount_endDate','>',$time)->where('discount_delete',1)->field('discount_id,discount_endDate,discount_name,discount_img,discount_flag')->select();
      foreach ($coupon as $key => $value) {
         foreach ($coupon as $key => $value) {
            if(!empty($value['discount_num'])){
               $sum=db('discount_log')->where('is_use',1)->where('discount_id',$value['discount_id'])->count();
            }
            $res=db('discount_log')->where('discount_id',$value['discount_id'])->where('userId',$userinfo['userId'])->find();
            $coupon[$key]['discount_img']=LINQUAN_IMG.$value['discount_img'];
            $coupon[$key]['discount_endDates']=date("Y-m-d",$value['discount_endDate']);
            if($value['discount_flag']==1){
               $coupon[$key]['discount_flag']='优惠券';
            }elseif($value['discount_flag']==2){
               $coupon[$key]['discount_flag']='满减送';
            }elseif($value['discount_flag']==3){
               $coupon[$key]['discount_flag']='红包';
            }
            if($res){
              $coupon[$key]['discount_status']=1;
            }else{
              $coupon[$key]['discount_status']=0;
            }
          }
         
      }
       $coupon = is_null($coupon)?$coupon = array():$coupon;   //判断空数组
       $datas['data'] = $coupon;
       $datas['result'] = true;
       $datas['resultString'] = '首页优惠券';
       echo json_encode($datas);die;
    }




    /**
    * 历史搜索 lxt
    */
    public function get_search(){
      echo header('Content-type: application/json; charset=utf-8');
      $content=cookie('contents');
      if(empty($content)){
         $content='';
      }
      $datas['data'] = $content;
      $datas['result'] = true;
      $datas['resultString'] = "搜索历史";
      echo json_encode($datas);die;
    }

    /**
    * 删除历史搜索 lxt
    */
    public function del_search(){
      echo header('Content-type: application/json; charset=utf-8');
      cookie('contents', null);
      $content=cookie('contents');
      if(empty($content)){
          $datas['result'] = true;
          $datas['resultString'] = '删除成功';
          echo json_encode($datas);die;
      }else{
          $datas['result'] = false;
          $datas['resultString'] = '删除失败';
          echo json_encode($datas);die;
      }
    }

    /**
    * 搜索 lxt
    */
    public function search(){
      echo header('Content-type: application/json; charset=utf-8');
      $content=$_GET['content'];
      $type=$_GET['type'];
      if($type==1){
         $where['dataFlag']=1;
         $where['isSale']=1;
         $where['goodsStatus']=1;
         $where['is_transfer']=0;
         $where['goodsName']=array('like','%'.$content.'%');
         $goods=db('goods')->where($where)->paginate(6)->toArray();
         $arr=array();
         foreach ($goods['Rows'] as $key => $value) {
         $arr[$key]['goodsId']=$value['goodsId'];
         $arr[$key]['goodsImg']=LINQUAN_IMG.$value['goodsImg'];
         $arr[$key]['goodsName']=$value['goodsName'];
         $arr[$key]['shopPrice']=$value['shopPrice'];
         $arr[$key]['marketPrice']=$value['marketPrice'];
         $arr[$key]['saleNum']=$value['saleNum'];
         $arr[$key]['visitNum']=$value['visitNum'];
         $arr[$key]['goodsTips']=$value['goodsTips'];
         }
      }elseif($type==2){
         $where['dataFlag']=1;
         $where['shopStatus']=1;
         $where['shop_flag']=0;
         $where['shopName']=array('like','%'.$content.'%');
         $shops=db('shops')->where($where)->paginate(6)->toArray();
         $arr=array();
          foreach ($shops['Rows'] as $key => $value) {
            $shopinfo2=db('shop_scores')->where('shopId',$value['shopId'])->find();
            $shopinfo3=db('cat_shops')->alias('a')->join('goods_cats b','a.catId=b.catId')->where('a.shopId',$value['shopId'])->field('b.catName')->select();
            foreach ($shopinfo3 as $k => $v) {
              $shopinfo3[$k]=$v['catName'];
            }
            $arr[$key]['shopId']=$value['shopId'];
            $arr[$key]['shopName']=$value['shopName'];
            $arr[$key]['shopImg']=LINQUAN_IMG.$value['shopImg'];
            if($shopinfo2['totalScore']==0){
              $score=5;
            }else{
              $score = round(((int)$shopinfo2['totalScore']/(int)$shopinfo2['totalUsers']/3),1);
            }
            $arr[$key]['shopScore']= $score;
            $arr[$key]['shopCats']=$shopinfo3;
            
          } 
      }
      $contents=Cookie::get('contents');
      if(empty($contents)){
        cookie("contents",$content,25920000);
      }else{
        $arr1=explode(',', $contents);
        if(!in_array($content, $arr1)){
           $contents=$contents.','.$content;
           cookie("contents",$contents,25920000);
        }
        
      }
       
       $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
       $datas['data'] = $arr;
       $datas['result'] = true;
       $datas['resultString'] = "搜索详情";
       echo json_encode($datas);die;
    }

    //首页调用数据
    public function index_item($info){
        $arr=array();
        foreach ($info as $key => $value) {
            //轮播图
            if($value['item_type']=='adv_list'){
               $adv=unserialize($value['item_data']);
               if(!empty($adv['item'])){
               foreach ($adv['item'] as $k => $v) {
                   $adv['item'][$k]['image']=LINQUAN_IMG.$v['image'];
               }
               $arr[$adv['biaoti']]=$adv['item'];
               }else{
                 $arr['banner']='';   
               } 
            }
            //导航
            if($value['item_type']=='home1'){
               $daohang=unserialize($value['item_data']);
               if(!empty($daohang['item'])){
               foreach ($daohang['item'] as $k => $v) {
                   $daohang['item'][$k]['image']=LINQUAN_IMG.$v['image'];
               }

               $arr[$daohang['biaoti']]=$daohang['item'];
               }else{
                 $arr['home']=''; 
               } 
            }
            //模块
            if($value['item_type']=='home2'){
               $mokuai=unserialize($value['item_data']);
               if(!empty($mokuai)){
               $mokuai['rectangle1_image']['image']=LINQUAN_IMG.$mokuai['rectangle1_image']['image'];
               $mokuai['rectangle2_image']['image']=LINQUAN_IMG.$mokuai['rectangle2_image']['image'];
               $mokuai['square_image']['image']=LINQUAN_IMG.$mokuai['square_image']['image'];
               
               $arr[$mokuai['biaoti']][0]=$mokuai['rectangle1_image'];
               $arr[$mokuai['biaoti']][1]=$mokuai['rectangle2_image'];
               $arr[$mokuai['biaoti']][2]=$mokuai['square_image'];
               }else{
                $arr['recommend']=''; 
               } 
            }
            //活动
            if($value['item_type']=='home3'){
               $activity=unserialize($value['item_data']);
               if(!empty($activity['item'])){
               foreach ($activity['item'] as $k => $v) {
                   $activity['item'][$k]['image']=LINQUAN_IMG.$v['image'];
               }
               $arr[$activity['biaoti']]=$activity['item'];
               }else{
                 $arr['activity']='';  
               }    
            }


            //推荐店铺
            if($value['item_type']=='home5'){
               $shops=unserialize($value['item_data']);
               if(!empty($shops['item'])){
               foreach ($shops['item'] as $k => $v) {
                   $shop=db('shops')->where('shopId',$v['shopId'])->field('areaIdPath,shopAddress,shopId,shopName,shopImg')->find();
                   $shop['shopImg']=LINQUAN_IMG.$shop['shopImg'];
                   $area=explode('_', $shop['areaIdPath']);
                   $province=db('areas')->where('areaId',$area[0])->find();
                   $city=db('areas')->where('areaId',$area[1])->find();
                   $area=db('areas')->where('areaId',$area[2])->find();
                   $shop['shopAddress']=$province['areaName'].$city['areaName'].$area['areaName'].$shop['shopAddress'];
                   $shops['item'][$k]=$shop;
               }
               $arr[$shops['biaoti']]=$shops['item'];
               }else{
                 $arr['shops']='';  
               }    
            }

            //抢购
            if($value['item_type']=='home4'){
               $buying=unserialize($value['item_data']);
               if(!empty($buying['item'])){
               foreach ($buying['item'] as $k => $v) {
                   $buying['item'][$k]['image']=LINQUAN_IMG.$v['image'];
               }

               $arr[$buying['biaoti']]=$buying['item'];
               }else{
                 $arr['buying']='';  
               }
            }

            //商品
            if($value['item_type']=='goods'){
               $goods=unserialize($value['item_data']);
               if(!empty($goods['item'])){
                   foreach ($goods['item'] as $k => $v) {
                   $good=db('goods')->where('goodsId',$v['goodsId'])->field('goodsId,goodsName,goodsTips,goodsImg,shopPrice')->find();
                   $good['goodsImg']=LINQUAN_IMG.$good['goodsImg'];
                   $goods['item'][$k]=$good;
                   }
                   $arr[$goods['biaoti']]=$goods['item'];
               }else{
                 $arr['goods']='';  
               }
                 
            }
            
        }
        return $arr;

    }



   //猜你喜欢数据调用
    public function  goods_like($res){
       $goods=array_filter(explode(',', $res['content']));
        foreach ($goods as $key => $value) {
        $good=db('goods')->where('goodsId',$value)->find();
        $arr['goods_like'][$key]['goodsId']=$good['goodsId'];
        $arr['goods_like'][$key]['goodsName']=$good['goodsName'];
        $arr['goods_like'][$key]['goodsTips']=$good['goodsTips'];
        $arr['goods_like'][$key]['goodsImg']=$good['goodsImg'];
        $arr['goods_like'][$key]['shopPrice']=$good['shopPrice'];
        $arr['goods_like'][$key]['goodsCatId']=$good['goodsCatId'];
        }
        $item=array();
        foreach($arr['goods_like'] as $k=>$v){
            if(!isset($item[$v['goodsCatId']])){
                $item[$v['goodsCatId']][]=$v;
            }else{
                $item[$v['goodsCatId']][] =$v;
            }
        }
        foreach ($item as $key => $value) {
          if(count($value)%2!=0){
             $where['dataFlag']=1;
             $where['isSale']=1;
             $where['goodsStatus']=1;
             $where['goodsCatId']=$key;
             $item[$key][]=db('goods')->where($where)->where('goodsId','not in',$res['content'])->order('goodsId desc')->field('goodsId,goodsName,goodsTips,goodsImg,shopPrice,goodsCatId')->limit(1)->select();
             
          }
        }
        foreach ($item as $k1 => $v1) {
              foreach ($v1 as $k2 => $v2) {
                $new_arr[$k1.$k2] = $v2;         
              }
        }
        return $new_arr;
    }
}
