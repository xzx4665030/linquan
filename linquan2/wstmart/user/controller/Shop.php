<?php
namespace wstmart\user\controller;
/**
 
 * 店铺控制器
 */
//use think\Controller;
use think\Session;
use think\Db;
class Shop extends Base{
    public $userinfo;
    public function __construct(){
       
       $token = $_GET['token'];
       if(!empty($token)){
          $this->is_login($token);
          $this->is_available($token);
       }     
       
       //$user=$this->authcode($token,'DECODE',LINQUAN_KEY,0);
       $user=base64_decode($token);
       $this->userinfo= $userinfo=db('users')->where('loginName',$user)->find();
       return $this->userinfo;
    }
    
    /**
    * 店铺首页 lxt
    */
    public function index(){
      echo header('Content-type: application/json; charset=utf-8');
      $userinfo = $this->userinfo;
      $shop_id=$_GET['shop_id'];
      $ordersort=$_GET['ordersort'];
      $orderstatus=$_GET['orderstatus'];
      $shopCatId1=$_GET['shopCatId1'];
      //店铺信息
      $shop=db('shops')->alias('a')->join('shop_scores b','a.shopId=b.shopId')->where('a.shopId',$shop_id)->find();

      if($shop['shopStatus']!=1){
           $datas['result'] = false;
           $datas['resultString'] = "店铺已关闭";
           echo json_encode($datas);die;
      }

      //分类
      $cats=db('shop_cats')->where('shopId',$shop_id)->where('parentId','0')->where('isShow','1')->where('dataFlag','1')->field('catId,catName')->select();
      //经营范围
      $business=db('cat_shops')->alias('a')->join('goods_cats b','a.catId=b.catId')->where('a.shopId',$shop_id)->field('catName')->select();
      foreach ($business as $key => $value) {
        $business[$key]=$value['catName'];
      }
      //粉丝数
      $fans=db('favorites')->where('targetId',$shop_id)->where('favoriteType','1')->count();
      //是否关注该店铺
      $attention=db('favorites')->where('userId',$userinfo['userId'])->where('targetId',$shop_id)->where('favoriteType','1')->find();
      //地址
      $area=explode('_', $shop['areaIdPath']);
      $province=db('areas')->where('areaId',$area[0])->find();
      $city=db('areas')->where('areaId',$area[1])->find();
      $area=db('areas')->where('areaId',$area[2])->find();
      //商品
      $where['goodsStatus']=1;
      $where['isSale']=1;
      $where['dataFlag']=1;
      $where['shopId']=$shop_id;
      if(!empty($shopCatId1)){
        $where['shopCatId1']=$shopCatId1;
      }

      $order='';
      if($orderstatus==1 && $ordersort==1){
         $order='shopPrice asc';
      }
      if($orderstatus==1 && $ordersort==2){
         $order='shopPrice desc';
      }
      if($orderstatus==2 && $ordersort==1){
         $order='saleNum asc';
      }
      if($orderstatus==2 && $ordersort==2){
         $order='saleNum desc';
      }
      if($orderstatus==3 && $ordersort==1){
         $order='visitNum asc';
      }
      if($orderstatus==3 && $ordersort==2){
         $order='visitNum desc';
      }
      if($orderstatus==4 && $ordersort==1){
         $order='isNew asc';
      }
      if($orderstatus==4 && $ordersort==2){
         $order='isNew desc';
      }
   
      $goods=db('goods')->where($where)->field('goodsId,goodsName,goodsImg,marketPrice,shopPrice,goodsTips,saleNum,visitNum')->order($order)->paginate(6)->toArray();
      foreach ($goods['Rows'] as $key => $value) {
         $goods['Rows'][$key]['goodsImg']=LINQUAN_IMG.$value['goodsImg'];
      }
      
      $arr['shopName']=$shop['shopName'];
      $arr['telephone']=$shop['telephone'];
      $arr['shopCompany']=$shop['shopCompany'];
      $arr['shopFans']=$fans;
      $arr['shopImg']=LINQUAN_IMG.$shop['shopImg'];
      $arr['shopCats']=$cats;
      $arr['shopBusine']=$business;
      $arr['attention']=empty($attention)?0:1;
      $arr['goods']=$goods['Rows'];
      $arr['shopAddress']=$province['areaName'].$city['areaName'].$area['areaName'].$shop['shopAddress'];
      $arr['shopScore']=empty($shop['totalScore'])?'5':round(($shop['totalScore']/$shop['totalUsers']/3),1);
      $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
      $datas['data'] = $arr;
      $datas['result'] = true;
      $datas['resultString'] = "店铺首页";
      echo json_encode($datas);die;
    }



        /**
    * 店铺首页 lxt
    */
    public function market(){
      echo header('Content-type: application/json; charset=utf-8');
      $userinfo = $this->userinfo;
      $shop_id=$_GET['shop_id'];
      $ordersort=$_GET['ordersort'];
      $orderstatus=$_GET['orderstatus'];
      $shopCatId1=$_GET['shopCatId1'];
      //店铺信息
      $shop=db('shops')->alias('a')->join('shop_scores b','a.shopId=b.shopId')->where('a.shopId',$shop_id)->find();

      if($shop['shopStatus']!=1){
           $datas['result'] = false;
           $datas['resultString'] = "店铺已关闭";
           echo json_encode($datas);die;
      }

      //分类
      $cats=db('shop_cats')->where('shopId',$shop_id)->where('parentId','0')->where('isShow','1')->where('dataFlag','1')->field('catId,catName,img')->select();
      foreach ($cats as $key => $value) {
          if(!empty($value['img'])){
             $cats[$key]['img']=LINQUAN_IMG.$value['img'];
          }
      }
      //经营范围
      $business=db('cat_shops')->alias('a')->join('goods_cats b','a.catId=b.catId')->where('a.shopId',$shop_id)->field('catName')->select();
      foreach ($business as $key => $value) {
        $business[$key]=$value['catName'];
      }
      //粉丝数
      $fans=db('favorites')->where('targetId',$shop_id)->where('favoriteType','1')->count();
      //是否关注该店铺
      $attention=db('favorites')->where('userId',$userinfo['userId'])->where('targetId',$shop_id)->where('favoriteType','1')->find();
     
      //商品
      $where['goodsStatus']=1;
      $where['isSale']=1;
      $where['dataFlag']=1;
      $where['shopId']=$shop_id;
      if(!empty($shopCatId1)){
        $where['shopCatId1']=$shopCatId1;
      }

      $order='';
      if($orderstatus==1 && $ordersort==1){
         $order='shopPrice asc';
      }
      if($orderstatus==1 && $ordersort==2){
         $order='shopPrice desc';
      }
      if($orderstatus==2 && $ordersort==1){
         $order='saleNum asc';
      }
      if($orderstatus==2 && $ordersort==2){
         $order='saleNum desc';
      }
      if($orderstatus==3 && $ordersort==1){
         $order='visitNum asc';
      }
      if($orderstatus==3 && $ordersort==2){
         $order='visitNum desc';
      }
      if($orderstatus==4 && $ordersort==1){
         $order='isNew asc';
      }
      if($orderstatus==4 && $ordersort==2){
         $order='isNew desc';
      }
   
      $goods=db('goods')->where($where)->field('goodsId,goodsName,goodsImg,marketPrice,shopPrice,goodsTips,saleNum,visitNum')->order($order)->paginate(6)->toArray();
      foreach ($goods['Rows'] as $key => $value) {
         $goods['Rows'][$key]['goodsImg']=LINQUAN_IMG.$value['goodsImg'];
      }
      
      $arr['shopName']=$shop['shopName'];
      $arr['telephone']=$shop['telephone'];
      $arr['shopCompany']=$shop['shopCompany'];
      
      $arr['shopFans']=$fans;
      $arr['shopImg']=LINQUAN_IMG.$shop['shopImg'];
      $arr['shopCats']=$cats;
      $arr['shopBusine']=$business;
      $arr['attention']=empty($attention)?0:1;
      
      $arr['goods']=$goods['Rows'];
      $adv=db('shop_configs')->where('shopId',$shop_id)->find();
      if(!empty($adv['shopAds'])){
         $arrs=array_filter(explode(',', $adv['shopAds']));
         foreach ($arrs as $key => $value) {
            $arrs[$key]=LINQUAN_IMG.$value;
         }
         $arr['banner']=$arrs;
      }
      $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
      $datas['data'] = $arr;
      $datas['result'] = true;
      $datas['resultString'] = "商场主页";
      echo json_encode($datas);die;
    }



    /**
    * 商品列表 lxt
    */
    public function good(){
      echo header('Content-type: application/json; charset=utf-8');
      $userinfo = $this->userinfo;
      $good_id=$_GET['good_id'];
      //商品信息
      $good=db('goods')->alias('a')->join('goods_scores b','a.goodsId=b.goodsId')->where('a.goodsId',$good_id)->field('a.shopId,a.goodsId,a.goodsName,a.marketPrice,a.shopPrice,a.goodsTips,a.saleNum,a.goodsStock,a.gallery,a.goodsUnit,a.goodsDesc,b.totalScore,b.totalUsers')->find();
      $freight=db('shops')->where('shopId',$good['shopId'])->find();
      $good['freight']=$freight['freight'];
      if($good['totalScore']==0){
         $good['score'] = 5;
      }else{
         $good['score'] = round(((int)$good['totalScore']/(int)$good['totalUsers']/3),1);
      }
      if(!empty($good['goodsDesc'])){
          $good['goodsDesc']=str_replace('/upload/','http://115.159.111.127/linquan2/upload/',$good['goodsDesc']);
        //$good['goodsDesc']='';
      }
      //图片
      $arr=array();
       if(!empty($good['gallery'])){
          $images=array_filter(explode(',', $good['gallery']));
          foreach ($images as $k => $v) {
            $arr[$k]=LINQUAN_IMG.$v;
          }
       }
       $good['gallery']=$arr;
      //判断是否关注该商品
      $favorites=db('favorites')->where('userId',$userinfo['userId'])->where('favoriteType',0)->where('targetId',$good_id)->find();
      if($favorites){
         $good['favorites']=1;
      }else{
         $good['favorites']=0;
      }


      //评价
      $evaluate=db('goods_appraises')->alias('a')->join('users b','a.userId=b.userId')->where('a.goodsId',$good_id)->where('a.isShow','1')->where('a.dataFlag',1)->field('a.content,a.images,a.createTime,b.userName,b.userPhoto')->limit(2)->select();  
          foreach ($evaluate as $key => $value) {
             $evaluate[$key]['userPhoto']=LINQUAN_IMG.$value['userPhoto'];
             $arr=array();
             if(!empty($value['images'])){
                $images=array_filter(explode(',', $value['images']));
                foreach ($images as $k => $v) {
                  $arr[$k]=LINQUAN_IMG.$v;
                }
             }
             $evaluate[$key]['images']=$arr;
          }

        //浏览记录
       if(empty($userinfo)){
          if(empty(cookie('identifiers'))){
            $text=time().rand(10,99);
            $ls['s_id']=$text;
            $ls['content']=$good_id;
            $res1=db('history')->insert($ls);
            if($res1){
              cookie("identifiers",$text,25920000);
            }
          }else{
            $s_id=cookie('identifiers');
            $res1=db('history')->where('s_id',$s_id)->find();
            $arr1=array_filter(explode(',',$res1['content']));
            if(!in_array($good_id, $arr1)){
               $ls['content']=$res1['content'].','.$good_id;
               $res1=db('history')->where('s_id',$s_id)->update($ls);
            }
          }
       }else{
          $res1=db('history')->where('userId',$userinfo['userId'])->find();
          if($res1){
            $arr1=array_filter(explode(',',$res1['content']));
            if(!in_array($good_id, $arr1)){
               $ls['content']=$res1['content'].','.$good_id;
               $res1=db('history')->where('userId',$userinfo['userId'])->update($ls);
            }
          }else{
            $ls['content']=$good_id;
            $ls['userId']=$userinfo['userId'];
            $res1=db('history')->insert($ls);
          }
          
       }

       
       $good['evaluate']=$evaluate;
       $good = is_null($good)?$good = array():$good;   //判断空数组
       $datas['data'] = $good;
       $datas['result'] = true;
       $datas['resultString'] = "商品列表";
       echo json_encode($datas);die;
      
    }


    /**
    * 商品评价 lxt
    */

    public function evaluate(){
      echo header('Content-type: application/json; charset=utf-8');
      $userinfo = $this->userinfo;
      $good_id=$_GET['good_id'];
      $evaluate=db('goods_appraises')->alias('a')->join('users b','a.userId=b.userId')->where('a.goodsId',$good_id)->where('a.isShow','1')->where('a.dataFlag',1)->field('a.content,a.images,a.createTime,b.userName,b.userPhoto')->paginate(6)->toArray();  
          foreach ($evaluate['Rows'] as $key => $value) {
             $evaluate['Rows'][$key]['userPhoto']=LINQUAN_IMG.$value['userPhoto'];
             $arr=array();
             if(!empty($value['images'])){
                $images=array_filter(explode(',', $value['images']));
                foreach ($images as $k => $v) {
                  $arr[$k]=LINQUAN_IMG.$v;
                }
             }
             $evaluate['Rows'][$key]['images']=$arr;
          }

      $arr = is_null($evaluate['Rows'])?$arr = array():$evaluate['Rows'];   //判断空数组
      $datas['data'] = $arr;
      $datas['result'] = true;
      $datas['resultString'] = "商品评价";
      echo json_encode($datas);die;
      
    }
    /**
    * 关注店铺，商品 lxt
    */
    
    public function favorite(){
       echo header('Content-type: application/json; charset=utf-8');
       $userinfo = $this->userinfo;

       $id=$_GET['id'];
       $type=$_GET['type'];
       $resulit=db('favorites')->where('userId',$userinfo['userId'])->where('favoriteType',$type)->where('targetId',$id)->find();
       if($resulit){
         $res=db('favorites')->where('userId',$userinfo['userId'])->where('favoriteType',$type)->where('targetId',$id)->delete();
         if($res){
             $datas['result'] = true;
             $datas['resultString'] = "取消关注成功";
             echo json_encode($datas);die;
          }else{
             $datas['result'] = false;
             $datas['resultString'] = "取消关注失败";
             echo json_encode($datas);die;
          }
       }else{
         $data['userId']=$userinfo['userId'];
         $data['favoriteType']=$type;
         $data['targetId']=$id;
         $data['createTime']=date("Y-m-d H:i:s",time());
         $res=db('favorites')->insert($data);
         if($res){
             $datas['result'] = true;
             $datas['resultString'] = "关注成功";
             echo json_encode($datas);die;
          }else{
             $datas['result'] = false;
             $datas['resultString'] = "关注失败";
             echo json_encode($datas);die;
          }
       }
       
    }


    
    /**
    * 获取商品规格 lxt
    */
    public function cart(){
        echo header('Content-type: application/json; charset=utf-8');
        $userinfo = $this->userinfo;
        $good_id=$_GET['good_id'];
        //$goods_specs=$_GET['goods_specs'];
        //商品信息
        $good=db('goods')->where('goodsId',$good_id)->field('goodsId,goodsName,goodsCatId,goodsImg,goodsTips,marketPrice,shopPrice,goodsStock')->find();
        $good['goodsImg']=LINQUAN_IMG.$good['goodsImg'];
        //规格
        $spec_cats=db('spec_cats')->where('goodsCatId',$good['goodsCatId'])->where('isShow',1)->where('dataFlag',1)->field('catId,catName')->order('isAllowImg desc')->select();
        foreach ($spec_cats as $key => $value) {
           $spec_items=db('spec_items')->where('catId',$value['catId'])->where('goodsId',$good_id)->field('itemId,itemName,itemImg')->select();
           if(empty($spec_items)){
              unset($spec_cats[$key]);
           }else{

              foreach ($spec_items as $k => $v) {
                  if(!empty($v['itemImg'])){
                      $spec_items[$k]['itemImg']=LINQUAN_IMG.$v['itemImg'];
                  }
              }
              $spec_cats[$key]['spec']= $spec_items;

           }

        }
        
        $good['spec_cats']= array_values($spec_cats);
        $specssq=db('goods_specs')->where('goodsId',$good_id)->where('dataFlag',1)->field('id,specIds,specPrice,marketPrice,specStock')->select();
       //$bbb='';
        foreach ($specssq as $key => $value) {
               $bbb='';
               $arr2=explode(':',$value['specIds']);
               foreach ($arr2 as $v) {
                 $bbb+=$v;
               }
               //var_dump($bbb);
               $specssq[$key]['specIds']=$bbb;
        }
       
        $res=db('goods_specs')->where('goodsId',$good_id)->where('isDefault',1)->where('dataFlag',1)->field('specIds,specPrice,marketPrice,specStock')->find();
          if($res){
               $aaa='';
               $arr1=explode(':', $res['specIds']);
               foreach ($arr1 as $key => $value) {
                 $aaa+=$value;
               }
               $good['marketPrice']=$res['marketPrice'];
               $good['shopPrice']=$res['specPrice'];
               $good['goodsStock']=$res['specStock'];
               $good['specIds']=$aaa;
          }
        $good['specs']=$specssq;

      $good = is_null($good)?$good = array():$good;   //判断空数组
      $datas['data'] = $good;
      $datas['result'] = true;
      $datas['resultString'] = "商品规格";
      echo json_encode($datas);die;

    }
    
     /**
    * 加入购物车 lxt
    */
    public function add_cart(){
        echo header('Content-type: application/json; charset=utf-8');
        $userinfo = $this->userinfo;
        $good_id=$_GET['good_id'];
        $goodsSpecId=$_GET['goodsSpecId'];
        $cartNum=$_GET['cartNum'];
        $type=db('goods')->where('goodsId',$good_id)->find();
        $res1=db('carts')->where('userId',$userinfo['userId'])->where('goodsId',$good_id)->where('goodsSpecId',$goodsSpecId)->find();
        if($res1){
          $data['cartNum']=$cartNum+$res1['cartNum'];
          $res=db('carts')->where('userId',$userinfo['userId'])->where('goodsId',$good_id)->where('goodsSpecId',$goodsSpecId)->update($data);
        }else{
          $data['type']=$type['is_transfer'];
          $data['userId']=$userinfo['userId'];
          $data['isCheck']=1;
          $data['goodsId']=$good_id;
          $data['goodsSpecId']=$goodsSpecId;
          $data['cartNum']=$cartNum;
          $res=db('carts')->insert($data);
        }
        
        if($res){
          $datas['result'] = true;
          $datas['resultString'] = "购物车添加成功";
          echo json_encode($datas);die;
        }else{
          $datas['result'] = false;
          $datas['resultString'] = "购物车添加失败";
          echo json_encode($datas);die;
        }
    }


    
     /**
    * 优惠券 lxt
    */
    public function coupon(){
      echo header('Content-type: application/json; charset=utf-8');
      $userinfo = $this->userinfo;
      $shopId=$_GET['shop_id'];
      $time=time();
      $coupon=db('discount')->where('discount_shopId',$shopId)->where('discount_startDate','<',$time)->where('discount_endDate','>',$time)->where('discount_delete',1)->field('discount_id,discount_endDate,discount_name,discount_img,discount_flag')->select();
      foreach ($coupon as $key => $value) {
        if(!empty($value['discount_num'])){
           $sum=db('discount_log')->where('is_use',1)->where('discount_id',$value['discount_id'])->count();
        }
        $res=db('discount_log')->where('discount_id',$value['discount_id'])->where('userId',$userinfo['userId'])->find();
        $coupon[$key]['discount_img']=LINQUAN_IMG.$value['discount_img'];
        $coupon[$key]['discount_endDate']=date("Y-m-d",$value['discount_endDate']);
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
      $coupon = is_null($coupon)?$coupon = array():$coupon;   //判断空数组
      $datas['data'] = $coupon;
      $datas['result'] = true;
      $datas['resultString'] = "优惠券";
      echo json_encode($datas);die;
    }


    /**
    * 领取优惠券 lxt
    */

    public function get_coupon(){
       echo header('Content-type: application/json; charset=utf-8');
       $userinfo = $this->userinfo;
       $coupon_ids=$_GET['coupon_ids'];
       $arr=array_filter(explode(',', $coupon_ids));
       if(!empty($arr)){
         foreach ($arr as $key => $value) {
           $data['time']=time();
           $data['userId']=$userinfo['userId'];
           $data['is_use']=0;
           $data['discount_id']=$value;
           $res=db('discount_log')->insert($data);
         }
         
       }
       $datas['result'] = true;
       $datas['resultString'] = "领取成功";
       echo json_encode($datas);die;
    }


    /**
    * 立即购买 lxt
    */
    public function buying(){
        echo header('Content-type: application/json; charset=utf-8');
        $userinfo = $this->userinfo;
        $goodid=$_GET['good_id'];
        $number=$_GET['number'];
        $goodsSpecId=$_GET['goodsSpecId'];
        //商品信息
        $good=db('goods')->where('goodsId',$goodid)->find();
        $arr['goodsName']=$good['goodsName'];
        $arr['goodsImg']=LINQUAN_IMG.$good['goodsImg'];
        $arr['goodsTips']=$good['goodsTips'];
        $arr['number']=$number;
        $arr['userMoney']=$userinfo['userMoney'];
        if(empty($goodsSpecId)){
            $arr['shopPrice']=$good['shopPrice'];
            $arr['specName']='';
        }else{
            $spec1=db('goods_specs')->where('id',$goodsSpecId)->find();
            $arr['specName']='';
            $arr1=array_filter(explode(':', $spec1['specIds']));
            foreach ($arr1 as $k => $v) {
                 $spec=db('spec_items')->where('itemId',$v)->find();
                 $arr['specName'].=$spec['itemName'].'/';
            }
            $arr['shopPrice']=$spec1['specPrice'];
        }
        //地址
        $address=db('user_address')->where('userId',$userinfo['userId'])->where('isDefault',1)->where('dataFlag',1)->find();
        if(empty($address)){
          $address=db('user_address')->where('userId',$userinfo['userId'])->order('createTime desc')->where('dataFlag',1)->find();
        }
        if(empty($address)){
            $arr['userName']='';
            $arr['userPhone']='';
            $arr['userAddress']='';
            $shop=db('shops')->where('shopId',$good['shopId'])->find();
            $arr['freight']=$shop['freight'];
        }else{
          $area=array_filter(explode('_', $address['areaIdPath']));
          $province=db('areas')->where('areaId',$area[0])->find();
          $city=db('areas')->where('areaId',$area[1])->find();
          $area=db('areas')->where('areaId',$area[2])->find();
          $arr['userName']=$address['userName'];
          $arr['userPhone']=$address['userPhone'];
          $arr['userAddress']=$province['areaName'].$city['areaName'].$area['areaName'].$address['userAddress'];
          $freight=db('shop_freights')->where('shopId',$good['shopId'])->where('areaId2',$city['areaId'])->find();
          $arr['freight']=$freight['freight'];
        }
       
        //运费

        $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
        $datas['data'] = $arr;
        $datas['result'] = true;
        $datas['resultString'] = "立即购买";
        echo json_encode($datas);die;
    }

}
