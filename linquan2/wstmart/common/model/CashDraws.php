<?php
namespace wstmart\common\model;
use think\Db;
/**
 * 提现流水业务处理器
 */
class CashDraws extends Base{
     /**
      * 获取列表
      */
      public function pageQuery($targetType,$targetId){
      	  $type = (int)input('post.type',-1);
          $where = [];
          $where['targetType'] = (int)$targetType;
          $where['targetId'] = (int)$targetId;
          if(in_array($type,[0,1]))$where['moneyType'] = $type;
          return $this->where($where)->order('cashId desc')->paginate()->toArray();
      }

      /**
       * 申请提现
       */
      public function drawMoney(){
          $userId = (int)session('WST_USER.userId');
          $money = (float)input('money');
          $accId = (float)input('accId');
          $payPwd = input('payPwd');
          $limitMoney = (float)WSTConf('CONF.drawCashUserLimit');
          if($money<$limitMoney)return WSTReturn('提取金额必须大于或等于￥'.$limitMoney.'方可提现');
          if($payPwd=='')return WSTReturn('支付密码不能为空');
          //加载提现账号信息
          $acc = Db::name('cash_configs')->alias('cc')
                   ->join('__BANKS__ b','cc.accTargetId=b.bankId')->where(['cc.dataFlag'=>1,'id'=>$accId])
                   ->field('b.bankName,cc.*')->find();
          if(empty($acc))return WSTReturn('提现账号不存在');
          $areas = model('areas')->getParentNames($acc['accAreaId']);
          //加载用户
          $user = model('users')->get($userId);
          $payPwd = md5($payPwd.$user->loginSecret);
          if($payPwd!=$user->payPwd)return WSTReturn('支付密码错误');
          if($money>$user->userMoney)return WSTReturn('提取金额不能大于用户余额');
          //减去要提取的金额
          $user->userMoney = $user->userMoney-$money;
          $user->lockMoney = $user->lockMoney+$money;
          Db::startTrans();
          try{
             $result = $user->save();
             if(false !==$result){
                //创建提现记录
                $data = [];
                $data['targetType'] = 0;
                $data['targetId'] = $userId;
                $data['money'] = $money;
                $data['accType'] = 3;
                $data['accTargetName'] = $acc['bankName'];
                $data['accAreaName'] = implode('',$areas);
                $data['accNo'] = $acc['accNo'];
                $data['accUser'] = $acc['accUser'];
                $data['cashSatus'] = 0;
                $data['cashConfigId'] = $accId;
                $data['createTime'] = date('Y-m-d H:i:s');
                $data['cashNo'] = '';
                $this->save($data);
                $this->cashNo = $this->cashId.(fmod($this->cashId,7));
                $this->save();
                Db::commit();
                return WSTReturn('提现申请成功，请留意系统信息',1);
             }
          }catch (\Exception $e) {
            Db::rollback();
            return WSTReturn('提现申请失败',-1);
          }
      }

      public function drawMoneyByShop(){
          $shopId = (int)session('WST_USER.shopId');
          $userId = (int)session('WST_USER.userId');
          $money = (float)input('money');
          $accId = (float)input('accId');
          $payPwd = input('payPwd');
          $limitMoney = (float)WSTConf('CONF.drawCashShopLimit');
          if($money<$limitMoney)return WSTReturn('提取金额必须大于或等于￥'.$limitMoney.'方可提现');
          if($payPwd=='')return WSTReturn('支付密码不能为空');
          $shops = model('shops')->get($shopId);
          $areas = model('areas')->getParentNames($shops->bankAreaId);
          $bank = model('banks')->get($shops->bankId);
          //加载用户
          $user = model('users')->get($userId);
          $payPwd = md5($payPwd.$user->loginSecret);
          if($payPwd!=$user->payPwd)return WSTReturn('支付密码错误');
          if($money>$shops->shopMoney)return WSTReturn('提取金额不能大于商家钱包金额');
          //减去要提取的金额
          $shops->shopMoney = $shops->shopMoney-$money;
          $shops->lockMoney = $shops->lockMoney+$money;
          Db::startTrans();
          try{
             $result = $shops->save();
             if(false !==$result){
                //创建提现记录
                $data = [];
                $data['targetType'] = 1;
                $data['targetId'] = $shopId;
                $data['money'] = $money;
                $data['accType'] = 3;
                $data['accTargetName'] = $bank['bankName'];
                $data['accAreaName'] = implode('',$areas);
                $data['accNo'] = $shops['bankNo'];
                $data['accUser'] = $shops['bankUserName'];
                $data['cashSatus'] = 0;
                $data['cashConfigId'] = 0;
                $data['createTime'] = date('Y-m-d H:i:s');
                $data['cashNo'] = '';
                $this->save($data);
                $this->cashNo = $this->cashId.(fmod($this->cashId,7));
                $this->save();
                Db::commit();
                return WSTReturn('提现申请成功，请留意系统信息',1);
             }
          }catch (\Exception $e) {
            Db::rollback();
            return WSTReturn('提现申请失败',-1);
          }
      }
	  
	  
	  //app店铺申请提现
	  public function tx_shop($array){
		 if($array['money'] <= 0){
			$datas['result'] = false;
			$datas['resultString'] = "输入提现金额必须大于0";
			
		}
		$shop_info = Db::name('shops')->where('shopId',$array['shop_id'])->find();
		$data['lockMoney'] = $shop_info['lockMoney'] + $array['money'];  //冻结
		$data['shopMoney'] = $shop_info['shopMoney'] - $array['money'];  //冻结
		
		//回滚
		Db::startTrans();
		try{
			//提现减去商家账户里钱加到冻结资金里
			
			Db::name('shops')->where('shopId',$array['shop_id'])->update($data);
			
			//先插入提现表，cashNo这个是计算出来的，需要新增的id
			$map['targetType'] = 1;
			$map['targetId'] = $array['shop_id'];
			$map['money'] = $array['money'];
			$map['cashSatus'] = 0;
			$map['cashConfigId'] = 0;
			$map['createTime'] = date('Y-m-d H:i:s',time());
			$map['cashNo'] = '';
			if($array['type'] == 3){
				$map['tx_lionId'] = $array['id'];
				$map['accType'] = 3;
			}else{
				$map['tx_bankId'] = $array['id'];
				$map['accType'] = ($array['type'] == 1)?1:2;
			}
			$this->save($map);
			
			$this->cashNo = $this->cashId.(fmod($this->cashId,7));
            $this->save();
			
			// 提交事务
			$datas['result'] = true;
			$datas['resultString'] = '提现成功';
			
			Db::commit(); 						
			return $datas;
		} catch (\Exception $e) {
			// 回滚事务
			$datas['result'] = false;
			$datas['resultString'] = '提现失败';
			
			Db::rollback();
			return $datas;
			
		}
		
		
	  }

     
}
