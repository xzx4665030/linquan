<?php
namespace wstmart\user\controller;
/**
 
 * 个人中心控制器
 */
//use think\Controller;

class Usercenter extends Base{
    public $userinfo;
    public function __construct(){
       
       $token = $_GET['token'];     
       $this->is_login($token);
       $this->is_available($token);
       //$user=$this->authcode($token,'DECODE',LINQUAN_KEY,0);
       $user=base64_decode($token);
       $this->userinfo= $userinfo=db('users')->where('loginName',$user)->find();
       return $this->userinfo;
    }
   /**
    * 个人中心 lxt
    */
   public function index(){

       $userinfo = $this->userinfo;
       //待支付订单
       $orders_pay=db('orders')->where('userId',$userinfo['userId'])->where('orderStatus','-2')->where('dataFlag','1')->count();
       //待发货订单
       $orders_freceiv=db('orders')->where('userId',$userinfo['userId'])->where('orderStatus','0')->where('dataFlag','1')->count();
       //待收货订单
       $orders_sreceiv=db('orders')->where('userId',$userinfo['userId'])->where('orderStatus','1')->where('dataFlag','1')->count();
       //待评价订单
       $orders_rated=db('orders')->where('userId',$userinfo['userId'])->where('orderStatus','2')->where('isAppraise','0')->where('dataFlag','1')->count();
       
       $data['user_img']=LINQUAN_IMG.$userinfo['userPhoto'];
       $data['user_name']=$userinfo['userName'];
       $data['user_money']=$userinfo['userMoney'];
       $data['orders_pay']=empty($orders_pay)?'0':$orders_pay;
       $data['orders_freceiv']=empty($orders_freceiv)?'0':$orders_freceiv;
       $data['orders_sreceiv']=empty($orders_sreceiv)?'0':$orders_sreceiv;
       $data['orders_rated']=empty($orders_rated)?'0':$orders_rated;
       $data = is_null($data)?$data = array():$data;   //判断空数组
       $datas['data'] = $data;
       $datas['result'] = true;
       $datas['resultString'] = "个人中心数据";
       echo header('Content-type: application/json; charset=utf-8'); 

       echo json_encode($datas);die;
   }

   /**
    * 个人信息 lxt
    */
   public function userinfo(){
       echo header('Content-type: application/json; charset=utf-8'); 
       $userinfo = $this->userinfo;
       $data['userPhoto']=LINQUAN_IMG.$userinfo['userPhoto'];
       $data['userName']=$userinfo['userName'];
       $data['userSex']=$userinfo['userSex'];
       $data['userAge']=empty($userinfo['userAge'])?'0':$userinfo['userAge'];
       $data['userPhone']=$userinfo['userPhone'];
       $data = is_null($data)?$data = array():$data;   //判断空数组
       $datas['data'] = $data;
       $datas['result'] = true;
       $datas['resultString'] = "个人信息数据";
       echo json_encode($datas);die;
   }


    /**
    * 消息 lxt
    */
    public function message(){
      echo header('Content-type: application/json; charset=utf-8'); 
      $userinfo = $this->userinfo;
      $where['dataFlag']=1;
      
      $message=db('messages')->where('receiveUserId',$userinfo['userId'])->where($where)->field('id,msgContent,createTime,msgStatus')->paginate(6)->toArray();
      $message = is_null($message['Rows'])?$message = array():$message['Rows'];   //判断空数组
      $datas['data'] = $message;
      $datas['result'] = true;
      $datas['resultString'] = "消息数据";
      echo json_encode($datas);die;
    }

    /**
    * 商品模块 lxt
    */
    public function order(){
      echo header('Content-type: application/json; charset=utf-8'); 
      $userinfo = $this->userinfo;
      $where['orderStatus']=array('neq','-3');
      $orders=db('orders')->alias('a')->join('shops b','a.shopId=b.shopId')->where('a.userId',$userinfo['userId'])->where('orderStatus !=-3')->paginate(6)->toArray();

      $arr=array();
      
      foreach ($orders['Rows'] as $key => $value) {
        $goods=db('order_goods')->where('orderId',$value['orderId'])->field('goodsId,goodsPrice,goodsNum,goodsName,goodsImg')->select();
        foreach ($goods as $k => $v) {
          $detail=db('goods')->where('goodsId',$v['goodsId'])->find();
          $goods[$k]['goodsTips']=$detail['goodsTips'];
          $goods[$k]['goodsImg']=LINQUAN_IMG.$v['goodsImg'];
        }
        $arr[$key]['shopName']=$value['shopName'];
        $arr[$key]['orderNo']=$value['orderNo'];
        $arr[$key]['createTime']=$value['createTime'];
        $arr[$key]['orderId']=$value['orderId'];
        $arr[$key]['goods']=$goods;
        $arr[$key]['realTotalMoney']=empty($value['realTotalMoney'])?'0':$value['realTotalMoney'];
        $arr[$key]['deliverMoney']=empty($value['deliverMoney'])?'0':$value['deliverMoney'];
        $arr[$key]['orderStatus']=$this->order_status($value['orderStatus'],$value['isRefund'],$value['isAppraise']);
      }
      $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
      $datas['data'] = $arr;
      $datas['result'] = true;
      $datas['resultString'] = "商品模块数据";
      echo json_encode($datas);die;
    }
    

    /**
    * 维权模块 lxt
    */
    public function refund(){
      echo header('Content-type: application/json; charset=utf-8'); 
       $userinfo = $this->userinfo;
       //订单店铺信息
       $orders=db('orders')->alias('a')->join('shops b','a.shopId=b.shopId')->where('a.userId',$userinfo['userId'])->where('orderStatus','-3')->paginate(6)->toArray();
        $arr=array();
       

        foreach ($orders['Rows'] as $key => $value) {
          $goods=db('order_goods')->where('orderId',$value['orderId'])->field('goodsId,goodsPrice,goodsNum,goodsName,goodsImg')->select();
          foreach ($goods as $k => $v) {
            $detail=db('goods')->where('goodsId',$v['goodsId'])->find();
            $goods[$k]['goodsTips']=$detail['goodsTips'];
            $goods[$k]['goodsImg']=LINQUAN_IMG.$v['goodsImg'];
          }
          //退款订单
          $order_t=db('order_refunds')->where('orderId',$value['orderId'])->find();

          $arr[$key]['shopName']=$value['shopName'];
          $arr[$key]['orderNo']=$value['orderNo'];
          $arr[$key]['createTime']=$value['createTime'];
          $arr[$key]['orderId']=$value['orderId'];
          $arr[$key]['goods']=$goods;
          $arr[$key]['realTotalMoney']=empty($value['realTotalMoney'])?'0':$value['realTotalMoney'];
          $arr[$key]['deliverMoney']=empty($value['deliverMoney'])?'0':$value['deliverMoney'];
          $arr[$key]['orderStatus']=$this->order_status($value['orderStatus'],$value['isRefund'],$value['isAppraise']);
          if(empty($order_t['backMoney'])){
               $arr[$key]['backMoney']=0;
          }else{
              $arr[$key]['backMoney']=$order_t['backMoney'];
          }
          
        }
        $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
        $datas['data'] = $arr;
        $datas['result'] = true;
        $datas['resultString'] = "维权模块数据";
        echo json_encode($datas);die;
    }



     /**
    * 维权模块 lxt
    */
    public function status_order(){
       echo header('Content-type: application/json; charset=utf-8'); 
       $userinfo = $this->userinfo;
       $where=array();
       $status=$_GET['status'];
       if($status==1){
          $where['orderStatus']='-2';
          $message='待付款';
       }elseif($status==2){
          $where['orderStatus']=0;
          $message='待发货';
       }elseif($status==3){
          $where['orderStatus']=1;
          $message='待收货';
       }elseif($status==4){
          $where['orderStatus']=2;
          $where['isAppraise']=0;
          $message='待评价';
       }
       //订单店铺信息
       $orders=db('orders')->alias('a')->join('shops b','a.shopId=b.shopId')->where('a.userId',$userinfo['userId'])->where($where)->paginate(6)->toArray();
        $arr=array();
       

        foreach ($orders['Rows'] as $key => $value) {
          $goods=db('order_goods')->where('orderId',$value['orderId'])->field('goodsId,goodsPrice,goodsNum,goodsName,goodsImg')->select();
          foreach ($goods as $k => $v) {
            $detail=db('goods')->where('goodsId',$v['goodsId'])->find();
            $goods[$k]['goodsTips']=$detail['goodsTips'];
            $goods[$k]['goodsImg']=LINQUAN_IMG.$v['goodsImg'];
          }
          
          $arr[$key]['shopName']=$value['shopName'];
          $arr[$key]['orderNo']=$value['orderNo'];
          $arr[$key]['createTime']=$value['createTime'];
          $arr[$key]['orderId']=$value['orderId'];
          $arr[$key]['goods']=$goods;
          $arr[$key]['realTotalMoney']=empty($value['realTotalMoney'])?'0':$value['realTotalMoney'];
          $arr[$key]['deliverMoney']=empty($value['deliverMoney'])?'0':$value['deliverMoney'];
          $arr[$key]['orderStatus']=$this->order_status($value['orderStatus'],$value['isRefund'],$value['isAppraise']);
          
        }
        $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
        $datas['data'] = $arr;
        $datas['result'] = true;
        $datas['resultString'] = $message;
        echo json_encode($datas);die;
    }

    /**
    * 商品收藏 lxt
    */
    public function keep_good(){
        echo header('Content-type: application/json; charset=utf-8'); 
        $userinfo = $this->userinfo;    
        $goods=db('favorites')->alias('a')->join('goods b','a.targetId=b.goodsId')->where('userId',$userinfo['userId'])->where('favoriteType','0')->field('b.goodsId,b.goodsName,b.goodsImg,b.goodsTips,b.shopPrice')->paginate(6)->toArray();
        $arr=array();
        foreach ($goods['Rows'] as $key => $value) {
          $arr[$key]['goodsImg']=LINQUAN_IMG.$value['goodsImg'];
          $arr[$key]['goodsId']=$value['goodsId'];
          $arr[$key]['goodsName']=$value['goodsName'];
          $arr[$key]['goodsTips']=$value['goodsTips'];
          $arr[$key]['shopPrice']=$value['shopPrice'];

        }
        $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
        $datas['data'] = $arr;
        $datas['result'] = true;
        $datas['resultString'] = "关注商品数据";
        echo json_encode($datas);die;        
    }

    /**
    * 店铺收藏 lxt
    */
    public function keep_shop(){
          echo header('Content-type: application/json; charset=utf-8');
          $userinfo = $this->userinfo;
          $shops=db('favorites')->where('userId',$userinfo['userId'])->where('favoriteType','1')->paginate(6)->toArray();
          $arr=array();
          
          foreach ($shops['Rows'] as $key => $value) {
            $shopinfo1=db('shops')->where('shopId',$value['targetId'])->find();
            $shopinfo2=db('shop_scores')->where('shopId',$value['targetId'])->find();
            $shopinfo3=db('cat_shops')->alias('a')->join('goods_cats b','a.catId=b.catId')->where('a.shopId',$value['targetId'])->field('b.catName')->select();
            foreach ($shopinfo3 as $k => $v) {
              $shopinfo3[$k]=$v['catName'];
            }
            $arr[$key]['shopId']=$shopinfo1['shopId'];
            $arr[$key]['shopName']=$shopinfo1['shopName'];
            $arr[$key]['shopImg']=LINQUAN_IMG.$shopinfo1['shopImg'];
            if($shopinfo2['totalScore']==0){
              $score=5;
            }else{
              $score = round(((int)$shopinfo2['totalScore']/(int)$shopinfo2['totalUsers']/3),1);
            }
            $arr[$key]['shopScore']= $score;
            $arr[$key]['shopCats']=$shopinfo3;
            
          } 
            
            $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
            $datas['data'] = $arr;
            $datas['result'] = true;
            $datas['resultString'] = "关注店铺数据";
            echo json_encode($datas);die;
    }


    /**
    * 地址记录 lxt
    */

    public function address(){
      echo header('Content-type: application/json; charset=utf-8'); 
       $userinfo = $this->userinfo;
       $addres=db('user_address')->where('userId',$userinfo['userId'])->where('dataFlag','1')->select();
       $arr=array();
      
       foreach ($addres as $key => $value) {
         $area=explode('_', $value['areaIdPath']);
         $province=db('areas')->where('areaId',$area[0])->find();
         $city=db('areas')->where('areaId',$area[1])->find();
         $area=db('areas')->where('areaId',$area[2])->find();
         $arr[$key]['province']=$province['areaName'];
         $arr[$key]['city']=$city['areaName'];
         $arr[$key]['area']=$area['areaName'];
         $arr[$key]['userAddress']=$province['areaName'].$city['areaName'].$area['areaName'].$value['userAddress'];
         $arr[$key]['userName']=$value['userName'];
         $arr[$key]['userPhone']=$value['userPhone'];
         $arr[$key]['isDefault']=$value['isDefault'];
         $arr[$key]['addressId']=$value['addressId'];
       }
       
       $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
       $datas['data'] = $arr;
       $datas['result'] = true;
       $datas['resultString'] = "地址显示数据";
       echo json_encode($datas);die;
    }
    

    /**
    * 修改默认地址 lxt
    */
    public function default_eidt(){
      echo header('Content-type: application/json; charset=utf-8'); 
      $userinfo = $this->userinfo;
      $addressId=$_GET['addressId'];

      $res2=db('user_address')->where('userId',$userinfo['userId'])->where('isDefault','1')->find();
      if($res2){
         $data1['isDefault']=0;
         $res1=db('user_address')->where('userId',$userinfo['userId'])->where('isDefault','1')->update($data1);
         $data['isDefault']=1;
         $res=db('user_address')->where('addressId',$addressId)->update($data);
         if($res && $res1){
           $datas['result'] = true;
           $datas['resultString'] = "设置默认地址成功";
           echo json_encode($datas);die;
          }else{
           $datas['result'] = false;
           $datas['resultString'] = "设置默认地址失败";
           echo json_encode($datas);die;
         }
      }else{
         $data['isDefault']=1;
         $res=db('user_address')->where('addressId',$addressId)->update($data);
         if($res){
           $datas['result'] = true;
           $datas['resultString'] = "设置默认地址成功";
           echo json_encode($datas);die;
          }else{
           $datas['result'] = false;
           $datas['resultString'] = "设置默认地址失败";
           echo json_encode($datas);die;
         }
      }
      
    }

   
    /**
    * 获取省 lxt
    */
    public function get_province(){
      echo header('Content-type: application/json; charset=utf-8'); 
      $userinfo = $this->userinfo;
      $province=db('areas')->where('areaType','0')->where('isShow','1')->where('dataFlag','1')->order('areaSort asc')->select();
      $arr=array();
      foreach ($province as $key => $value) {
        $arr[$key]['areaName']=$value['areaName'];
        $arr[$key]['areaId']=$value['areaId'];
      }
       $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
       $datas['data'] = $arr;
       $datas['result'] = true;
       $datas['resultString'] = "省数据";
       echo json_encode($datas);die;
    }
    

    /**
    * 获取市 lxt
    */
    public function get_city(){
      echo header('Content-type: application/json; charset=utf-8'); 
      $userinfo = $this->userinfo;
      $provinceId=$_GET['provinceId'];
      $city=db('areas')->where('parentId',$provinceId)->where('isShow','1')->where('dataFlag','1')->order('areaSort asc')->select();
      $arr=array();
      foreach ($city as $key => $value) {
        $arr[$key]['areaName']=$value['areaName'];
        $arr[$key]['areaId']=$value['areaId'];
      }
       $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
       $datas['data'] = $arr;
       $datas['result'] = true;
       $datas['resultString'] = "市数据";
       echo json_encode($datas);die;
    }
    


    /**
    * 获取市 lxt
    */
    public function get_area(){
      echo header('Content-type: application/json; charset=utf-8'); 
      $userinfo = $this->userinfo;
      $cityId=$_GET['cityId'];
      $area=db('areas')->where('parentId',$cityId)->where('isShow','1')->where('dataFlag','1')->order('areaSort asc')->select();
      $arr=array();
      foreach ($area as $key => $value) {
        $arr[$key]['areaName']=$value['areaName'];
        $arr[$key]['areaId']=$value['areaId'];
      }
       $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
       $datas['data'] = $arr;
       $datas['result'] = true;
       $datas['resultString'] = "区数据";
       echo json_encode($datas);die;
    }


    /**
    * 添加地址 lxt
    */

    public function address_add(){
      echo header('Content-type: application/json; charset=utf-8'); 
      $userinfo = $this->userinfo;
      $userName=$_GET['userName'];
      $userPhone=$_GET['userPhone'];
      $userAddress=$_GET['userAddress'];
      $provinceId=$_GET['provinceId'];
      $cityId=$_GET['cityId'];
      $areaId=$_GET['areaId'];

      $data['userId']=$userinfo['userId'];
      $data['userName']=$userName;
      $data['userPhone']=$userPhone;
      $data['areaIdPath']=$provinceId.'_'.$cityId.'_'.$areaId.'_';
      $data['areaId']=$areaId;
      $data['userAddress']=$userAddress;
      $data['isDefault']=0;
      $data['dataFlag']=1;
      $data['createTime']=date("Y-m-d H:i:s",time());
      $res=db('user_address')->insert($data);
      if($res){
         $datas['result'] = true;
         $datas['resultString'] = "地址添加成功";
         echo json_encode($datas);die;
      }else{
         $datas['result'] = false;
         $datas['resultString'] = "地址添加失败";
         echo json_encode($datas);die;
      }
      
    }
    


     /**
    * 编辑地址 lxt
    */

    public function address_eidt(){
      echo header('Content-type: application/json; charset=utf-8'); 
      $userinfo = $this->userinfo;
      $addressId=$_GET['addressId'];
      $userName=$_GET['userName'];
      $userPhone=$_GET['userPhone'];
      $userAddress=$_GET['userAddress'];
      $provinceId=$_GET['provinceId'];
      $cityId=$_GET['cityId'];
      $areaId=$_GET['areaId'];

  
      $data['userName']=$userName;
      $data['userPhone']=$userPhone;
      $data['areaIdPath']=$provinceId.'_'.$cityId.'_'.$areaId.'_';
      $data['areaId']=$areaId;
      $data['userAddress']=$userAddress;
      $res=db('user_address')->where('addressId',$addressId)->update($data);
      if($res){
         $datas['result'] = true;
         $datas['resultString'] = "地址修改成功";
         echo json_encode($datas);die;
      }else{
         $datas['result'] = false;
         $datas['resultString'] = "地址修改失败";
         echo json_encode($datas);die;
      }
    }

    /**
    * 删除地址 lxt
    */

    public function address_del(){
      echo header('Content-type: application/json; charset=utf-8'); 
      $userinfo = $this->userinfo;
      $addressId=$_GET['addressId'];
      $data['dataFlag']='-1';
      $res=db('user_address')->where('addressId',$addressId)->update($data);
      if($res){
        $datas['result'] = true;
        $datas['resultString'] = "地址删除成功";
        echo json_encode($datas);die;
      }else{
        $datas['result'] = false;
        $datas['resultString'] = "地址删除失败";
        echo json_encode($datas);die;
      }
    }


    /**
    * 删除订单 lxt
    */

    public function oreder_del(){
      echo header('Content-type: application/json; charset=utf-8'); 
      $userinfo = $this->userinfo;
      $orderId=$_GET['orderId'];
      $data['dataFlag']='-1';
      $res=db('orders')->where('orderId',$orderId)->update($data);
      if($res){
        $datas['result'] = true;
        $datas['resultString'] = "订单删除成功";
        echo json_encode($datas);die;
      }else{
        $datas['result'] = false;
        $datas['resultString'] = "订单删除失败";
        echo json_encode($datas);die;
      }
    }


    /**
    * 订单详情 lxt
    */
    public function order_detail(){
        echo header('Content-type: application/json; charset=utf-8'); 
        $userinfo = $this->userinfo;
        $orderId=$_GET['orderId'];
        $order=db('orders')->alias('a')->join('shops b','a.shopId=b.shopId')->where('a.orderId',$orderId)->field('a.orderId,a.orderStatus,a.orderNo,a.realTotalMoney,a.deliverMoney,b.shopName,b.telephone,a.createTime,a.userName,a.userAddress,a.userPhone,a.totalMoney,a.isPay,a.isRefund,a.isAppraise')->find();
        $goods=db('order_goods')->where('orderId',$orderId)->field('goodsId,goodsPrice,goodsNum,goodsName,goodsImg')->select();
        foreach ($goods as $key => $value) {
          $goods[$key]['goodsImg']=LINQUAN_IMG.$value['goodsImg'];
        }
        //物流
        $rs = $this->getOrderExpress(input("orderId"));
        $express = json_decode($rs, true);
        $state = $express["state"];
        $data = $this->getOrderInfo();
        $data["express"]["stateTxt"] = $this->getExpressState($state);
        $express["express"] = $data["express"];
        //var_dump($express['express']);die;
        // foreach ($express['data'] as $key => $value) {
        //    $goods['express'][$key]['time']=$value['time'];
        //    $goods['express'][$key]['context']=$value['context'];
        // }
        $order['orderStatus']=$this->order_status($order['orderStatus'],$order['isRefund'],$order['isAppraise']);
        $order['express']=$express["express"]['stateTxt'];
        $order['e_time']=empty($express['data'][0]['time'])?'':$express['data'][0]['time'];
        $order['goods']=$goods;
        $order = is_null($order)?$order = array():$order;   //判断空数组
        $datas['data'] = $order;
        $datas['result'] = true;
        $datas['resultString'] = "订单详情";
        echo json_encode($datas);die;
    }

    /**
    * 查看物流详情 lxt
    */
    public function order_exp(){
        echo header('Content-type: application/json; charset=utf-8'); 
        $userinfo = $this->userinfo;
        $orderId=$_GET['orderId'];
        $rs = $this->getOrderExpress(input("orderId"));
        $express = json_decode($rs, true);
        $arr=array();
        if(!empty($express['data'])){
            foreach ($express['data'] as $key => $value) {
                $arr['exp'][$key]['time']=$value['time'];
                $arr['exp'][$key]['context']=$value['context'];
            }
        }else{
          $arr['exp']=array();
        }
        
        $exp=db('orders')->alias('a')->join('express b','a.expressId=b.expressId')->where('orderId',$orderId)->find();
        $arr['expressName']=empty($exp['expressName'])?'':$exp['expressName'];
        $arr['expressTel']=empty($exp['expressTel'])?'':$exp['expressTel'];
        $arr['expressNo']=empty($exp['expressNo'])?'':$exp['expressNo'];
        $good=db('order_goods')->where('orderId',$orderId)->find();
        $arr['goodsImg']=LINQUAN_IMG.$good['goodsImg'];
        $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
        $datas['data'] = $arr;
        $datas['result'] = true;
        $datas['resultString'] = "查看物流详情";
        echo json_encode($datas);die;
    }




    /**
    * 物流详情 lxt
    */
    public function exp_detail(){
        $rs = $this->getOrderExpress(input("orderId"));
        $express = json_decode($rs, true);
        $arr=array();
        foreach ($express['data'] as $key => $value) {
           $arr[$key]['time']=$value['time'];
           $arr[$key]['context']=$value['context'];
        }
        $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
        $datas['data'] = $arr;
        $datas['result'] = true;
        $datas['resultString'] = "订单详情";
        echo json_encode($datas);die;
    }


    /**
    * 优惠券 lxt
    */
    public function coupon(){
        echo header('Content-type: application/json; charset=utf-8'); 
        $userinfo = $this->userinfo;
        $coupon=db('discount_log')->alias('a')->join('discount b','a.discount_id=b.discount_id')->where('a.userId',$userinfo['userId'])->paginate(6)->toArray();
        $arr=array();
        foreach ($coupon['Rows'] as $key => $value) {
            if($value['discount_flag']==1){
            $arr[$key]['discount_flag']='优惠券';
            }elseif($value['discount_flag']==2){
               $arr[$key]['discount_flag']='满减送';
            }elseif($value['discount_flag']==3){
               $arr[$key]['discount_flag']='红包';
            }
            $arr[$key]['discount_status']=$value['is_use'];
            $arr[$key]['discount_name']=$value['discount_name'];
            $arr[$key]['discount_img']=LINQUAN_IMG.$value['discount_img'];
            $arr[$key]['discount_endDate']=date("Y-m-d",$value['discount_endDate']);
            $arr[$key]['discount_consume']=$value['discount_consume'];
            $arr[$key]['discount_value']=$value['discount_value'];
        }
        $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
        $datas['data'] = $arr;
        $datas['result'] = true;
        $datas['resultString'] = "我的优惠券";
        echo json_encode($datas);die;
    }


    /**
    * 修改个人资料 lxt
    */
    public function edit_info(){
      echo header('Content-type: application/json; charset=utf-8'); 
      $userinfo = $this->userinfo;
      $type=$_GET['type'];
      $content=$_GET['content'];
      if($type==1){
        $data['userName']=$content;
      }elseif($type==2){
        $data['userSex']=$content;
      }elseif($type==3){
        $data['userAge']=$content;
      }elseif($type==4){
        $data['userPhone']=$content;
      }
      $res=db('users')->where('userId',$userinfo['userId'])->update($data);
      if($res !==false){
            $datas['result'] = true;
            $datas['resultString'] = '信息修改成功';
            echo json_encode($datas);die;
        }else{
            $datas['result'] = false;
            $datas['resultString'] = '信息修改失败';
            echo json_encode($datas);die;
        }
    }

}
