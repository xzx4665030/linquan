<?php 
namespace wstmart\admin\model;
use think\Db;
/**

 * 报表业务处理
 */
class Reports extends Base{   
    /**
     * 获取商品销售统计
     */
    public function topSaleGoodsByPage(){
    	$start = date('Y-m-d 00:00:00',strtotime(input('startDate')));
    	$end = date('Y-m-d 23:59:59',strtotime(input('endDate')));
    	return Db::field('og.goodsId,g.goodsName,goodsSn,s.shopId,shopName,sum(og.goodsNum) goodsNum,og.goodsImg')->name('order_goods')->alias('og')
    	  ->join('__ORDERS__ o','og.orderId=o.orderId')
    	  ->join('__GOODS__ g','og.goodsId=g.goodsId')
    	  ->join('__SHOPS__ s','g.shopId=s.shopId')
    	  ->order('goodsNum desc')
    	  ->whereTime('o.createTime','between',[$start,$end])
          ->where('payType=0 or (payType=1 and isPay=1) and o.dataFlag=1')->group('og.goodsId,g.goodsName,goodsSn,s.shopId,shopName,og.goodsImg')
          ->paginate();
    }
    /**
     * 获取店铺销售统计
     */
    public function topShopSalesByPage(){
        $start = date('Y-m-d 00:00:00',strtotime(input('startDate')));
        $end = date('Y-m-d 23:59:59',strtotime(input('endDate')));
        return Db::field('s.shopImg,s.shopName,sum(o.totalMoney) totalMoney,count(o.orderId) orderNum')
                 ->name('shops')->alias('s')
                 ->join('__ORDERS__ o','s.shopId=o.shopId')
                 ->order('totalMoney desc,orderNum desc')
                 ->whereTime('o.createTime','between',[$start,$end])
                 ->where('payType=0 or (payType=1 and isPay=1) and o.dataFlag=1')->group('o.shopId')
                 ->paginate();

    }

    /**
     * 获取销售额
     */
    public function statSales(){
        $start = date('Y-m-d 00:00:00',strtotime(input('startDate')));
        $end = date('Y-m-d 23:59:59',strtotime(input('endDate')));
        $payType = (int)input('payType',-1);
        $rs = Db::field('left(createTime,10) createTime,orderSrc,sum(totalMoney) totalMoney')->name('orders')->whereTime('createTime','between',[$start,$end])
                ->where('(payType=0 or (payType=1 and isPay=1) and dataFlag=1) '.(in_array($payType,[0,1])?" and payType=".$payType:''))
                ->order('createTime asc')
                ->group('left(createTime,10),orderSrc')->select();
        $rdata = [];
        if(count($rs)>0){
            $days = [];
            $payTypes = [0,1,2,3,4];
            $tmp = [];
            foreach($rs as $key => $v){
                if(!in_array($v['createTime'],$days))$days[] = $v['createTime'];
                $tmp[$v['orderSrc']."_".$v['createTime']] = $v['totalMoney'];
            }
            $rdata['map'] = ['p0'=>0,'p1'=>0,'p2'=>0,'p3'=>0,'p4'=>0];
            foreach($days as $v){
                $total = 0;
                foreach($payTypes as $p){
                    $pv = isset($tmp[$p."_".$v])?$tmp[$p."_".$v]:0;
                    $rdata['p'.$p][] = (float)$pv;
                    $total = $total + (float)$pv;
                    $rdata['map']['p'.$p] = $rdata['map']['p'.$p] + (float)$pv;
                }
                $rdata['total'][] = $total;
            }
            $rdata['days'] = $days;
        }
        return WSTReturn('',1,$rdata);
    }

    /**
     * 获取订单统计
     */
    public function statOrders(){
        $start = date('Y-m-d 00:00:00',strtotime(input('startDate')));
        $end = date('Y-m-d 23:59:59',strtotime(input('endDate')));
        $payType = (int)input('payType',-1);
        $rs = Db::field('left(createTime,10) createTime,orderSrc,count(orderId) orderNum')->name('orders')->whereTime('createTime','between',[$start,$end])
                ->where('(payType=0 or (payType=1 and isPay=1) and dataFlag=1) '.(in_array($payType,[0,1])?" and payType=".$payType:''))
                ->order('createTime asc')
                ->group('left(createTime,10),orderSrc')->select();
        $rdata = [];
        if(count($rs)>0){
            $days = [];
            $payTypes = [0,1,2,3,4];
            $tmp = [];
            foreach($rs as $key => $v){
                if(!in_array($v['createTime'],$days))$days[] = $v['createTime'];
                $tmp[$v['orderSrc']."_".$v['createTime']] = $v['orderNum'];
            }
            $rdata['map'] = ['p0'=>0,'p1'=>0,'p2'=>0,'p3'=>0,'p4'=>0];
            foreach($days as $v){
                $total = 0;
                foreach($payTypes as $p){
                    $pv = isset($tmp[$p."_".$v])?$tmp[$p."_".$v]:0;
                    $rdata['p'.$p][] = (float)$pv;
                    $total = $total + (float)$pv;
                    $rdata['map']['p'.$p] = $rdata['map']['p'.$p] + (float)$pv;
                }
                $rdata['total'][] = $total;
            }
            $rdata['days'] = $days;
        }
        return WSTReturn('',1,$rdata);
    }

    /**
     * 获取新增用户
     */
    public function statNewUser(){
        $start = date('Y-m-d 00:00:00',strtotime(input('startDate')));
        $end = date('Y-m-d 23:59:59',strtotime(input('endDate')));
        $urs = Db::field('left(createTime,10) createTime,count(userId) userNum')
                ->name('users')
                ->whereTime('createTime','between',[$start,$end])
                ->where(['dataFlag'=>1,'userType'=>0])
                ->order('createTime asc')
                ->group('left(createTime,10)')
                ->select();
        $srs = Db::field('left(createTime,10) createTime,count(shopId) userNum')
                ->name('shops')
                ->whereTime('createTime','between',[$start,$end])
                ->where(['dataFlag'=>1])
                ->order('createTime asc')
                ->group('left(createTime,10)')
                ->select();
        $rdata = [];
        $days = [];
        $tmp = [];
        if(count($urs)>0){
            foreach($urs as $key => $v){
                if(!in_array($v['createTime'],$days))$days[] = $v['createTime'];
                $tmp["0_".$v['createTime']] = $v['userNum'];
            }
        }
        if(count($srs)>0){
            foreach($srs as $key => $v){
                if(!in_array($v['createTime'],$days))$days[] = $v['createTime'];
                $tmp["1_".$v['createTime']] = $v['userNum'];
            }
        }
        sort($days);
        foreach($days as $v){
            $rdata['u0'][] =  isset($tmp['0_'.$v])?$tmp['0_'.$v]:0;
            $rdata['u1'][] =  isset($tmp['1_'.$v])?$tmp['1_'.$v]:0;
        }
        $rdata['days'] = $days;
        return WSTReturn('',1,$rdata);
    }

    /**
     * 会员登录统计
     */
    public function statUserLogin(){
        $start = date('Y-m-d 00:00:00',strtotime(input('startDate')));
        $end = date('Y-m-d 23:59:59',strtotime(input('endDate')));
        $sql ='select createTime,userType,count(userId) userNum from ( 
             SELECT left(loginTime,10) createTime,`userType`,u.userId
                FROM `lqsj_users` `u` INNER JOIN `lqsj_log_user_logins` `lg` ON `u`.`userId`=`lg`.`userId` 
                WHERE  `loginTime` BETWEEN "'.$start.'" AND "'.$end.'"  AND (  dataFlag=1 )
                GROUP BY left(loginTime,10),userType,lg.userId
              ) a GROUP BY createTime, userType ORDER BY createTime asc ';
        $rs = Db::query($sql);  
        $rdata = [];
        if(count($rs)>0){
            $days = [];
            $tmp = [];
            foreach($rs as $key => $v){
                if(!in_array($v['createTime'],$days))$days[] = $v['createTime'];
                $tmp[$v['userType']."_".$v['createTime']] = $v['userNum'];
            }
            foreach($days as $v){
                $rdata['u0'][] = isset($tmp['0_'.$v])?$tmp['0_'.$v]:0;
                $rdata['u1'][] = isset($tmp['1_'.$v])?$tmp['1_'.$v]:0;
            }
            $rdata['days'] = $days;
        }
        return WSTReturn('',1,$rdata);
    }
}