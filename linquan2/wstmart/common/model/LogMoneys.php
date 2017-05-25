<?php
namespace wstmart\common\model;
use think\Db;
/**
 * 资金流水业务处理器
 */
class LogMoneys extends Base{
     /**
      * 获取列表
      */
      public function pageQuery($targetType,$targetId){
      	  $type = (int)input('post.type',-1);
          $where['targetType'] = (int)$targetType;
          $where['targetId'] = (int)$targetId;
          if(in_array($type,[0,1]))$where['moneyType'] = $type;
          $page = $this->where($where)->order('id desc')->paginate()->toArray();
          foreach ($page['Rows'] as $key => $v){
          	  $page['Rows'][$key]['dataSrc'] = WSTLangMoneySrc($v['dataSrc']);
          }
          return $page;
      }
      
      
      public function complateRecharge($obj){
			$trade_no = $obj["trade_no"];
	      	$orderNo = $obj["out_trade_no"];
	      	$targetId = (int)$obj["targetId"];
	      	$targetType = (int)$obj["targetType"];
	      	$payFrom = (int)$obj["payFrom"];
	      	$payMoney = (float)$obj["total_fee"];
	      	
	      	$log = $this->where(["tradeNo"=>$trade_no,"payType"=>$payFrom])->find();
	      	if(!empty($log)){
	      		return WSTReturn('已充值',-1);
	      	}
	      	Db::startTrans();
	      	try {
	      		if($targetType==1){
	      			$data = array();
	      			$data["shopMoney"] = array("exp","shopMoney+".$payMoney);
	      			model('shops')->where(["shopId"=>$targetId])->update($data);
	      		}else{
	      			$data = array();
	      			$data["userMoney"] = array("exp","userMoney+".$payMoney);
	      			model('users')->where(["userId"=>$targetId])->update($data);
	      		}
	      		
	      		//创建一条充值流水记录
	      		$lm = [];
	      		$lm['targetType'] = $targetType;
	      		$lm['targetId'] = $targetId;
	      		$lm['dataId'] = $orderNo;
	      		$lm['dataSrc'] = 4;
	      		$lm['remark'] = '钱包充值 ¥'.$payMoney;
	      		$lm['moneyType'] = 1;
	      		$lm['money'] = $payMoney;
	      		$lm['payType'] = $payFrom;
	      		$lm['tradeNo'] = $trade_no;
	      		$lm['createTime'] = date('Y-m-d H:i:s');
	      		model('LogMoneys')->save($lm);
	      		Db::commit();
	      		return WSTReturn('充值成功',1);
	      	} catch (Exception $e) {
	      		Db::rollback();
	      		return WSTReturn('充值失败',-1);
	      	}
      }

      /**
       * 新增记录
       */
      public function add($log){
          $log['createTime'] = date('Y-m-d H:i:s');
          $this->create($log);
          if($log['moneyType']==1){
              if($log['targetType']==1){
	      	      Db::name('shops')->where(["shopId"=>$log['targetId']])->setInc('shopMoney',$log['money']);
		      }else{
		      	  Db::name('users')->where(["userId"=>$log['targetId']])->setInc('userMoney',$log['money']);
		      }
          }else{
              if($log['targetType']==1){
	      	      Db::name('shops')->where(["shopId"=>$log['targetId']])->setDec('shopMoney',$log['money']);
		      }else{
		      	  Db::name('users')->where(["userId"=>$log['targetId']])->setDec('userMoney',$log['money']);
		      }
          }
      }
}
