<?php
namespace wstmart\user\controller;
/**
 
 * 店铺控制器
 */
//use think\Controller;
use think\Session;
use think\Db;
class Branch extends Base{
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
    * 店铺首页 lxt
    */
    public function index(){
      echo header('Content-type: application/json; charset=utf-8');
      if(!empty($_GET['position'])){
           $position=explode('|',$_GET['position']);
      }
      
      $info=db('mb_special_item')->where('special_id',2)->where('dataFlag',1)->select();
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
        //附近店铺
        $shops=db('shops')->where('dataFlag',1)->where('shopStatus',1)->where('shop_flag',1)->field('shopId,shopName,shopImg,shopAddress,jwd')->select();
        foreach ($shops as $key => $value) {
           $jwd=explode('|', $value['jwd']);
           $jl=$this->getDistance($position[0],$position[1],$jwd[0],$jwd[1]);
           $arr['near_shop'][$key]['shopId']=$value['shopId'];
           $arr['near_shop'][$key]['shopName']=$value['shopName'];
           $arr['near_shop'][$key]['shopImg']=LINQUAN_IMG.$value['shopImg'];
           $arr['near_shop'][$key]['shopAddress']=$value['shopAddress'];
           $arr['near_shop'][$key]['distance']=$jl;
           $business=db('cat_shops')->alias('a')->join('goods_cats b','a.catId=b.catId')->where('a.shopId',$value['shopId'])->field('catName')->select();
           if(empty($business)){
               $business='';
           }else{
              foreach ($business as $k => $v) {
                $business[$k]=$v['catName'];
              }
           }
            
           $arr['near_shop'][$key]['cats']=$business;
           $sum_oeder=db('orders')->where('isPay',1)->where('shopId',$value['shopId'])->count();
           $arr['near_shop'][$key]['sum_oeder']=$sum_oeder;
          
        }
        
        if(!empty($arr['near_shop'])){
            $arr['near_shop']=array_values($arr['near_shop']);
            //排序
            $sort = array(
            'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
            'field'     => 'sum_oeder',       //排序字段
            );
            $arrSort = array();
            foreach($arr['near_shop'] AS $uniqid => $row){
                foreach($row AS $key=>$value){
                    $arrSort[$key][$uniqid] = $value;
                }
            }
            if($sort['direction']){
                array_multisort($arrSort[$sort['field']], constant($sort['direction']), $arr['near_shop']);
            }

            $count = count($arr['near_shop']);
            $pages=6;
            if(empty($_GET['page'])){
                $f_page=0;
            }else{
                $f_page=($_GET['page']-1)*$pages;
            }
            if($count > $pages){
              $arr['near_shop'] = array_slice($arr['near_shop'],$f_page,$pages);
            }
        }
        
        
        $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
        $datas['data'] = $arr;
        $datas['result'] = true;
        $datas['resultString'] = "网点首页";
        echo json_encode($datas);die;
    }

    public function near_shop(){
        echo header('Content-type: application/json; charset=utf-8');
        if(!empty($_GET['position'])){
           $position=explode('|',$_GET['position']);
        }
        $cats_id=$_GET['cats_id'];
        $arr=array();
        //附近店铺
        $shops=db('shops')->where('dataFlag',1)->where('shopStatus',1)->where('shop_flag',1)->field('shopId,shopName,shopImg,shopAddress,jwd')->select();
        foreach ($shops as $key => $value) {
           $jwd=explode('|', $value['jwd']);
           $jl=$this->getDistance($position[0],$position[1],$jwd[0],$jwd[1]);
           if($jl>2000){
             unset($shops[$key]);
           }else{
             $arr['near_shop'][$key]['shopId']=$value['shopId'];
             $arr['near_shop'][$key]['shopName']=$value['shopName'];
             $arr['near_shop'][$key]['shopImg']=LINQUAN_IMG.$value['shopImg'];
             $arr['near_shop'][$key]['shopAddress']=$value['shopAddress'];
             $arr['near_shop'][$key]['distance']=$jl;
             $business=db('cat_shops')->alias('a')->join('goods_cats b','a.catId=b.catId')->where('a.shopId',$value['shopId'])->field('catName')->select();
             if(empty($business)){
                 $business='';
             }else{
                foreach ($business as $k => $v) {
                  $business[$k]=$v['catName'];
                }
             }
              
             $arr['near_shop'][$key]['cats']=$business;
             $sum_oeder=db('orders')->where('isPay',1)->where('shopId',$value['shopId'])->count();
             $arr['near_shop'][$key]['sum_oeder']=$sum_oeder;
           }
        }
     
        if(!empty($cats_id)){
           foreach ($arr['near_shop'] as $key => $value) {
              $cats1=db('cat_shops')->where('shopId',$value['shopId'])->field('catId')->select();
              $arr1=array();
              foreach ($cats1 as $k => $v) {
                $arr1[$k]=$v['catId'];
              }
              if(!in_array($cats_id, $arr1)){
                 unset($arr['near_shop'][$key]);
              }
           }
        }


        
        if(!empty($arr['near_shop'])){
            $arr['near_shop']=array_values($arr['near_shop']);
            $count = count($arr['near_shop']);
            $pages=6;
            if(empty($_GET['page'])){
                $f_page=0;
            }else{
                $f_page=($_GET['page']-1)*$pages;
            }
            if($count > $pages){
              $arr['near_shop'] = array_slice($arr['near_shop'],$f_page,$pages);
            }
        }
        //分类
        $clsaa=db('shop_class')->where('class_id',31)->find();
        $class_cats=explode(',', $clsaa['cats_id']);
        $arrs=array();
        foreach ($class_cats as $key => $value) {
            $catss=db('goods_cats')->where('catId',$value)->where('dataFlag',1)->find();
            $arrs[$key]['catId']=$catss['catId'];
            $arrs[$key]['catName']=$catss['catName'];
        }
        $arr['cats']=$arrs;
        
        
        $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
        $datas['data'] = $arr;
        $datas['result'] = true;
        $datas['resultString'] = "附近网点";
        echo json_encode($datas);die;
    }



    /**
    * 购物车 lxt
    */
    public  function carts(){
       echo header('Content-type: application/json; charset=utf-8');   
       $token = $_GET['token'];
       $type=$_GET['type'];
       $this->is_login($token);
       $this->is_available($token); 
       $user=base64_decode($token);
       $userinfo=db('users')->where('loginName',$user)->find();
       $goods=db('carts')->alias('a')->join('goods b','a.goodsId=b.goodsId')->where('userId',$userinfo['userId'])->where('type',$type)->field('a.cartId,a.isCheck,a.cartNum,a.goodsSpecId,b.goodsName,b.goodsImg,b.shopPrice,b.shopId')->select();
       $order_sum=0;
       $money_sum=0;
       foreach ($goods as $key => $value) {
         $goods[$key]['goodsImg']=LINQUAN_IMG.$value['goodsImg'];
         $res=db('goods_specs')->where('id',$value['goodsSpecId'])->find();
         if($res){
            $goods[$key]['goodsSpecId']='';
            $arr=array_filter(explode(':', $res['specIds']));
            if($value['isCheck']==1){
                 $money_sum+=$res['specPrice']*$value['cartNum'];
            }
            $goods[$key]['shopPrice']=$res['specPrice'];
            foreach ($arr as $k => $v) {
               $spec=db('spec_items')->where('itemId',$v)->find();
               $goods[$key]['goodsSpecId'].=$spec['itemName'].'/';
            }
         }else{
           $goods[$key]['goodsSpecId']='';
           if($value['isCheck']==1){
             $money_sum+=$value['shopPrice']*$value['cartNum'];
           }
         }
         if($value['isCheck']==1){
            $order_sum+=1;
         }
       }
      
       $item=array();
        foreach($goods as $k=>$v){
            if(!isset($item[$v['shopId']])){
                $item[$v['shopId']][]=$v;
            }else{
                $item[$v['shopId']][] =$v;
            }
        }
        //获取店铺信息
        $arr1=array();
        $arr1['order_sum']=$order_sum;
        $arr1['money_sum']=$money_sum;
        foreach ($item as $key => $value) {
           $shop=db('shops')->where('shopId',$key)->find();
           $arr1['order'][$key]['shopName']=$shop['shopName'];
           $arr1['order'][$key]['goods']=$value;
        }
        $arr1['order']=array_values($arr1['order']);
        $arr1 = is_null($arr1)?$arr1 = array():$arr1;   //判断空数组
        $datas['data'] = $arr1;
        $datas['result'] = true;
        $datas['resultString'] = "购物车";
        echo json_encode($datas);die;
    }

    /**
    * 购物车取消勾选 lxt
    */
    public function check(){
      echo header('Content-type: application/json; charset=utf-8');
      $cartId=$_GET['cartId'];
      $type=$_GET['type'];
      $arr=explode(',',$cartId);
      if($type==1){
        foreach ($arr as $key => $value) {
          $data['isCheck']=1;
          $res=db('carts')->where('cartId',$value)->update($data);
          if($res !== false){
             $a=1;
          }else{
             $a=2;
          }
        }
        if($a==1){
        $datas['result'] = true;
        $datas['resultString'] = "勾选成功";
        echo json_encode($datas);die;
        }else{
          $datas['result'] = false;
          $datas['resultString'] = "勾选失败";
          echo json_encode($datas);die;
        }
      }else{
         foreach ($arr as $key => $value) {
          $data['isCheck']=0;
          $res=db('carts')->where('cartId',$value)->update($data);
          if($res !== false){
             $a=1;
          }else{
             $a=2;
          }
         }
          if($a==1){
            $datas['result'] = true;
            $datas['resultString'] = "取消勾选成功";
            echo json_encode($datas);die;
          }else{
            $datas['result'] = false;
            $datas['resultString'] = "取消勾选失败";
            echo json_encode($datas);die;
          }
      } 
    }


    /**
    * 购物车删除商品 lxt
    */
    public function cats_del(){
      echo header('Content-type: application/json; charset=utf-8');
      $cartId=$_GET['cartId'];
      $res=db('carts')->where('cartId',$cartId)->delete();
      if($res){
        $datas['result'] = true;
        $datas['resultString'] = "移除成功";
        echo json_encode($datas);die;
      }else{
        $datas['result'] = false;
        $datas['resultString'] = "移除失败";
        echo json_encode($datas);die;
      }
    }


    /**
    * 购物车提交订单 lxt
    */
    public function buying(){
         echo header('Content-type: application/json; charset=utf-8');   
         $token = $_GET['token'];
         $type=$_GET['type'];
         $this->is_login($token);
         $this->is_available($token); 
         $user=base64_decode($token);
         $userinfo=db('users')->where('loginName',$user)->find();
         $goods=db('carts')->alias('a')->join('goods b','a.goodsId=b.goodsId')->where('userId',$userinfo['userId'])->where('type',$type)->where('isCheck',1)->field('a.cartId,a.isCheck,a.cartNum,a.goodsSpecId,b.goodsName,b.goodsImg,b.shopPrice,b.shopId')->select();
         foreach ($goods as $key => $value) {
           $goods[$key]['goodsImg']=LINQUAN_IMG.$value['goodsImg'];
           $res=db('goods_specs')->where('id',$value['goodsSpecId'])->find();
           if($res){
              $goods[$key]['specName']='';
              $goods[$key]['shopPrice']=$res['specPrice'];
              $arr=array_filter(explode(':', $res['specIds']));
              foreach ($arr as $k => $v) {
                 $spec=db('spec_items')->where('itemId',$v)->find();
                 $goods[$key]['specName'].=$spec['itemName'].'/';
              }
           }else{
             $goods[$key]['specName']='';
           }
         }
         $item=array();
          foreach($goods as $k=>$v){
              if(!isset($item[$v['shopId']])){
                  $item[$v['shopId']][]=$v;
              }else{
                  $item[$v['shopId']][] =$v;
              }
          }
          //获取店铺信息
          $arr1=array();
          $arr1['total_money']='';
          foreach ($item as $key => $value) {
             $shop=db('shops')->where('shopId',$key)->find();
             $arr1['order'][$key]['shopName']=$shop['shopName'];
             $arr1['order'][$key]['goods']=$value;
             $arr1['order'][$key]['order_sum']=count($value);
             $money_sum=0;
             foreach ($value as $k => $v) {
                $money_sum+=$v['shopPrice']*$v['cartNum'];
             }
             $arr1['order'][$key]['money_sum']=$money_sum;
             $arr1['total_money']+=$money_sum;
          }
          //地址
          $address=db('user_address')->where('userId',$userinfo['userId'])->where('isDefault',1)->where('dataFlag',1)->find();
          if(empty($address)){
            $address=db('user_address')->where('userId',$userinfo['userId'])->order('createTime desc')->where('dataFlag',1)->find();
          }
          if(empty($address)){
              $arr1['userName']='';
              $arr1['userPhone']='';
              $arr1['userAddress']='';
          }else{
            $area=explode('_', $address['areaIdPath']);
            $province=db('areas')->where('areaId',$area[0])->find();
            $city=db('areas')->where('areaId',$area[1])->find();
            $area=db('areas')->where('areaId',$area[2])->find();
            $arr1['userName']=$address['userName'];
            $arr1['userPhone']=$address['userPhone'];
            $arr1['userAddress']=$province['areaName'].$city['areaName'].$area['areaName'].$address['userAddress'];
          }
          $arr1['order']=array_values($arr1['order']);
          $arr1 = is_null($arr1)?$arr1 = array():$arr1;   //判断空数组
          $datas['data'] = $arr1;
          $datas['result'] = true;
          $datas['resultString'] = "提交购物车订单";
          echo json_encode($datas);die;
    }
}
