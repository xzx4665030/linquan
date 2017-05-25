<?php
namespace wstmart\admin\model;
use think\Db;
/**

 * 资金流水日志业务处理
 */
class LogMoneys extends Base{
	/**
	 * 用户资金列表 
	 */
	public function pageQueryByUser(){
		$key = input('key');
		$where = [];
		$where['dataFlag'] = 1;
        $where['loginName'] = ['like','%'.$key.'%'];
		return model('users')->where($where)->field('loginName,userId,userName,userMoney,lockMoney')->paginate(input('pagesize/d'));
	}
	/**
	 * 商家资金列表 
	 */
	public function pageQueryByShop(){
		$key = input('key');
		$where = [];
		$where['u.dataFlag'] = 1;
		$where['s.dataFlag'] = 1;
        $where['loginName'] = ['like','%'.$key.'%'];
		return Db::name('shops')->alias('s')->join('__USERS__ u','s.userId=u.userId','inner')->where($where)->field('loginName,shopId,shopName,shopMoney,s.lockMoney')->paginate(input('pagesize/d'));
	}

	/**
	 * 获取用户信息
	 */
	public function getUserInfoByType(){
		$type = (int)input('type',0);
		$id = (int)input('id');
		$data = [];
        if($type==1){
            $data = Db::name('shops')->alias('s')->join('__USERS__ u','s.userId=u.userId','inner')->where('shopId',$id)->field('shopId as userId,shopName as userName,loginName,1 as userType')->find();
        }else{
            $data = model('users')->where('userId',$id)->field('loginName,userId,userName,0 as userType')->find();
        }
        return $data;
	}

    /**
	 * 分页
	 */
	public function pageQuery(){
		$userType = input('get.type');
		$userId = input('get.id');
		$startDate = input('get.startDate');
		$endDate = input('get.endDate');
		$where = [];
		if($startDate!='')$where['createTime'] = ['>=',$startDate." 00:00:00"];
		if($endDate!='')$where[' createTime'] = ['<=',$endDate." 23:59:59"];
		$where['targetType'] = $userType;
		$where['targetId'] = $userId;
		$page = $this->where($where)->order('id', 'desc')->paginate(input('pagesize/d'))->toArray();
		if(count($page['Rows'])>0){
			foreach ($page['Rows'] as $key => $v) {
				$page['Rows'][$key]['dataSrc'] = WSTLangMoneySrc($v['dataSrc']);
			}
		}
		return $page;
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
