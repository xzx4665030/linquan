<?php
namespace wstmart\user\controller;
/**
 * 会员控制器
 */
use think\Session;
use think\Db;
class Order extends Base{
    /**
    * 退款 lxt
    */
    public function refund(){
      echo header('Content-type: application/json; charset=utf-8');
      $token = $_GET['token'];     
      $this->is_login($token);
      $this->is_available($token);
      $user=base64_decode($token);
      $userinfo=db('users')->where('loginName',$user)->find();
      $order_id=$_GET['order_id'];
      $order=db('orders')->where('orderId',$order_id)->find();
      $arr=array();
      $arr['realTotalMoney']=$order['realTotalMoney'];
      $reson=db('datas')->where('catId',4)->field('dataVal,dataName')->select();
      $arr['reson']=$reson;
      $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
      $datas['data'] = $arr;
      $datas['result'] = true;
      $datas['resultString'] = "退货";
      echo json_encode($datas);die;
    }


    /**
    * 修改退货申请 lxt
    */
    public function edit_refund(){
      echo header('Content-type: application/json; charset=utf-8');
      $token = $_GET['token'];     
      $this->is_login($token);
      $this->is_available($token);
      $user=base64_decode($token);
      $userinfo=db('users')->where('loginName',$user)->find();
      $order_id=$_GET['order_id'];
      $order=db('order_refunds')->where('orderId',$order_id)->find();
      $arr=array();
      $arr['backMoney']=$order['backMoney'];
      $arr['refundReson']=$order['refundReson'];
      if($order['refundReson']==10000){
         $arr['refundOtherReson']=$order['refundOtherReson'];
      }else{
         $arr['refundOtherReson']='';
      }
      $aaa=array();
      if(!empty($order['img'])){
          $img=array_filter(explode(',', $order['img']));
          foreach ($img as $key => $value) {
             $aaa[$key]=LINQUAN_IMG.$value;
          }
      }
      $arr['img']=$aaa;
      
      $reson=db('datas')->where('catId',4)->field('dataVal,dataName')->select();
      $arr['reson']=$reson;
      
      $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
      $datas['data'] = $arr;
      $datas['result'] = true;
      $datas['resultString'] = "修改退货申请";
      echo json_encode($datas);die;
    }

    /**
    * 提交修改退款 lxt
    */
    public function add_edit(){
       echo header('Content-type: application/json; charset=utf-8');
       $token = $_POST['token'];     
       $this->is_login($token);
       $this->is_available($token);
       $user=base64_decode($token);
       $userinfo=db('users')->where('loginName',$user)->find();
       $order_id=$_POST['order_id'];
       $dataVal=$_POST['dataVal'];
       $content=$_POST['content'];
       //图片
       $img='';
       $file = request()->file('userPhoto');   //img是name名
       if(!empty($file)){
           foreach ($file as $key => $value) {
           $info = $value->move('./upload/refund');       
           $aaa =  $info->getSaveName();    //获取图像保存路径
           $arr=explode('\\', $aaa);
           $img='upload/users/'.$arr[0].'/'.$arr[1].','.$img;
           }
       }

       $data1['refundReson']=$dataVal;
       $data1['img']=$img;
       if(!empty($content)){
          $data1['refundOtherReson']=$content;
       }
       $res1=db('order_refunds')->where('orderId',$order_id)->update($data1);

       if($res1 !==false ){
          $datas['result'] = true;
          $datas['resultString'] = '修改退款申请成功';
          echo json_encode($datas);die;
       }else{
          $datas['result'] = false;
          $datas['resultString'] = '修改退款申请失败';
          echo json_encode($datas);die;
       }    
    }



    
    /**
    * 提交退款 lxt
    */
    public function add_refund(){
       echo header('Content-type: application/json; charset=utf-8');
       $token = $_POST['token'];     
       $this->is_login($token);
       $this->is_available($token);
       $user=base64_decode($token);
       $userinfo=db('users')->where('loginName',$user)->find();
       $order_id=$_POST['order_id'];
       $money=$_POST['money'];
       $dataVal=$_POST['dataVal'];
       $content=$_POST['content'];
       //图片
       $img='';
       $file = request()->file('userPhoto');   //img是name名
       if(!empty($file)){
           foreach ($file as $key => $value) {
           $info = $value->move('./upload/refund');       
           $aaa =  $info->getSaveName();    //获取图像保存路径
           $arr=explode('\\', $aaa);
           $img='upload/users/'.$arr[0].'/'.$arr[1].','.$img;
           }
       }    
       $data['orderStatus']='-1';
       $res=db('orders')->where('orderId',$order_id)->update($data);
       
       $data1['orderId']=$order_id;
       $data1['backMoney']=$money;
       $data1['refundReson']=$dataVal;
       $data1['img']=$img;
       $data1['refundStatus']=1;
       $data1['createTime']=date("Y-m-d H:i:s",time());
       if(!empty($content)){
          $data1['refundOtherReson']=$content;
       }
       $res1=db('order_refunds')->insert($data1);

       if($res !==false && $res1 !==false ){
          $datas['result'] = true;
          $datas['resultString'] = '退款申请成功';
          echo json_encode($datas);die;
       }else{
          $datas['result'] = false;
          $datas['resultString'] = '退款申请失败';
          echo json_encode($datas);die;
       }
    }


    /**
    * 退款详情 lxt
    */
    public function refund_detail(){
      echo header('Content-type: application/json; charset=utf-8');
      $token = $_GET['token'];     
      $this->is_login($token);
      $this->is_available($token);
      $user=base64_decode($token);
      $userinfo=db('users')->where('loginName',$user)->find();
      $order_id=$_GET['order_id'];
      $order=db('orders')->alias('a')->join('order_refunds b','a.orderId=b.orderId')->where('a.orderId',$order_id)->find();
      $arr=array();
      if($order['refundReson']!=10000){
         $reson=db('datas')->where('catId',4)->where('dataVal',$order['refundReson'])->find();
         $arr['reson']=$reson['dataName'];
      }else{
         $arr['reson']=$order['refundOtherReson'];
      }
      $arr['money']=$order['backMoney'];
      $shop=db('shops')->where('shopId',$order['shopId'])->find();
      $arr['shopName']=$shop['shopName'];
      $arr['refundTime']=empty($order['refundTime'])?'':$order['refundTime'];
      $arr['refundStatus']=$order['refundStatus'];

      $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
      $datas['data'] = $arr;
      $datas['result'] = true;
      $datas['resultString'] = "退货详情";
      echo json_encode($datas);die;
    }

    /**
    * 退款协商 lxt
    */
    public function refund_consult(){
      echo header('Content-type: application/json; charset=utf-8');
      $token = $_GET['token'];     
      $this->is_login($token);
      $this->is_available($token);
      $user=base64_decode($token);
      $userinfo=db('users')->where('loginName',$user)->find();
      $order_id=$_GET['order_id'];
      $order=db('orders')->alias('a')->join('order_refunds b','a.orderId=b.orderId')->where('a.orderId',$order_id)->find();
      $arr=array();
      if($order['refundReson']!=10000){
         $reson=db('datas')->where('catId',4)->where('dataVal',$order['refundReson'])->find();
         $arr['reson']=$reson['dataName'];
      }else{
         $arr['reson']=$order['refundOtherReson'];
      }
      $arr['money']=$order['backMoney'];
      $shop=db('shops')->where('shopId',$order['shopId'])->find();
      $arr['shopName']=$shop['shopName'];
      $arr['refundTime']=empty($order['refundTime'])?'':$order['refundTime'];
      $arr['refundStatus']=$order['refundStatus'];
      $arr['createTime']=$order['createTime'];

      $arr = is_null($arr)?$arr = array():$arr;   //判断空数组
      $datas['data'] = $arr;
      $datas['result'] = true;
      $datas['resultString'] = "退货协商";
      echo json_encode($datas);die;
    }
    
}
