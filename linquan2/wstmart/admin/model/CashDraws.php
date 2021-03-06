<?php
namespace wstmart\admin\model;
use think\Db;
/**

 * 提现分类业务处理
 */
class CashDraws extends Base{
	/**
	 * 分页
	 */
	public function pageQuery(){
		$targetType = input('targetType',-1);
		$cashNo = input('cashNo');
		$cashSatus = input('cashSatus',-1);
        $where = [];
        if(in_array($targetType,[0,1]))$where['targetType'] = $targetType;
        if(in_array($cashSatus,[0,1]))$where['cashSatus'] = $cashSatus;
        if($cashNo!='')$where['cashNo'] = ['like','%'.$cashNo.'%'];
        return $this->where($where)->paginate(input('pagesize/d'))->toArray();
	}

	/**
	 * 获取提现详情
	 */
	public function getById(){
		$id = (int)input('id');
		return $this->get($id);
	}

	/**
	 * 处理提现
	 */
	public function handle(){
		$id = (int)input('cashId');
		$cash = $this->get($id);
		if(empty($cash))return WSTReturn('无效的提现申请记录');
		Db::startTrans();
		try{
			$targetId = $cash->targetId;
            if($cash->targetType==0){
		        $user = model('users')->get($cash->targetId);
				if($user->lockMoney<$cash->money)return WSTReturn('操作失败，被冻结的金额小于提现金额');
				$user->lockMoney = $user->lockMoney-$cash->money;
            	$user->save();
            }else{
                $shop = model('shops')->get($cash->targetId);
				if($shop->lockMoney<$cash->money)return WSTReturn('操作失败，被冻结的金额小于提现金额');
                $shop->lockMoney = $shop->lockMoney-$cash->money;
            	$shop->save();
            }
            $cash->cashSatus = 1;
            $cash->cashRemarks = input('cashRemarks');
            $result = $cash->save();

            if(false != $result){
            	//创建一条流水记录
            	$lm = [];
				$lm['targetType'] = $cash->targetType;
				$lm['targetId'] = $targetId;
				$lm['dataId'] = $id;
				$lm['dataSrc'] = 3;
				$lm['remark'] = '提现申请单【'.$cash->cashNo.'】申请提现¥'.$cash->money.'。'.(($cash->cashRemarks!='')?"【操作备注】：".$cash->cashRemarks:'');
				$lm['moneyType'] = 0;
				$lm['money'] = $cash->money;
				$lm['payType'] = 0;
				$lm['createTime'] = date('Y-m-d H:i:s');
				model('LogMoneys')->add($lm);
				//发送信息信息
				$tpl = WSTMsgTemplates('CASH_DRAW_SUCCESS');
		        if($tpl['tplContent']!=''){
		            $find = ['${CASH_NO}'];
		            $replace = [$cash->cashNo];
		            WSTSendMsg($targetId,str_replace($find,$replace,$tpl['tplContent']),['from'=>5,'dataId'=>$id]);
		        } 
				//微信消息
				if((int)WSTConf('CONF.wxenabled')==1){
					$params = [];
					$params['CASH_NO'] = $cash->cashNo;
					$params['MONEY'] = $cash->money;
					$params['CASH_TYPE'] = '银行提现';           
					$params['CASH_TIME'] = $cash['createTime'];
					$params['CASH_RESULT'] = "审核通过。【备注：".((input('cashRemarks')=='')?"无":input('cashRemarks'))."】";
					$params['EXAMINE_TIME'] = date('Y-m-d H:i:s');
					WSTWxMessage(['CODE'=>'WX_CASH_DRAW_SUCCESS','userId'=>$targetId,'params'=>$params]);
				}
				Db::commit();
				return WSTReturn('操作成功!',1);
            }
		}catch (\Exception $e) {
            Db::rollback();
        }
		return WSTReturn('操作失败!',-1);
	}
}
