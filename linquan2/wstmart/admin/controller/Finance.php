<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\LogMoneys as M;
use think\Db;
/**
 * 进销存-财务控制器  xzx
 */
class Finance extends Base{
	
    public function index(){
        $res=db('finance')->select();
        $this->assign('res1',$res);
        $operator=db('staffs')->where('staffRoleId',10)->select();
        $this->assign('operator',$operator);
    	return $this->fetch("list");
    }
    
    /**
     * 获取用户分页  
     */
    public function pageQueryByUser(){
    	$m = new M();

      return $m->pageQueryByUser();
    }
    /**
     * 获取财务类别 lxt
     */
    public function pageQueryByShop(){
        $where=array();
        if(!empty($_GET['s3_type'])){
           $where['type']=$_GET['s3_type'];
        }
        if(!empty($_GET['s3_key'])){
            $where['name']=array('like','%'.$_GET['s3_key'].'%');
        }
        
        $res=db('finance')->where($where)->order('sort')->paginate(input('pagesize/d'))->toArray();

        foreach ($res['Rows'] as $key => $value) {
            if($value['type']==1){
               $res['Rows'][$key]['type']='收入';
            }elseif($value['type']==2){
               $res['Rows'][$key]['type']='支出';
            }elseif($value['type']==3){
               $res['Rows'][$key]['type']='内部转账';
            }
        }
        return $res;
    }
    /**
     * 添加财务类别 lxt
     */
    public function add_type(){
        $name=$_POST['name'];
        $type=$_POST['type'];
        $sort=$_POST['sort'];
        
        $data['name']=$name;
        $data['type']=$type;
        $data['sort']=$sort;
        $res=db('finance')->insert($data);
        if($res){
          return WSTReturn("添加成功", 1);
        }else{
          return WSTReturn("添加失败", -1); 
        }

    }

    /**
     * 获取财务类别 lxt
     */
    public function get_type(){
        $id=$_POST['id'];
        $res=db('finance')->where('id',$id)->find();
        return $res;
    }


    /**
     * 修改财务类别 lxt
     */
    public function edit_type(){
        $id=$_POST['id'];
        $name=$_POST['name'];
        $type=$_POST['type'];
        $sort=$_POST['sort'];
        
        $data['name']=$name;
        $data['type']=$type;
        $data['sort']=$sort;
        $res=db('finance')->where('id',$id)->update($data);
        if($res){
          return WSTReturn("编辑成功", 1);
        }else{
          return WSTReturn("编辑失败", -1); 
        }

    }

    /*
    批量删除财务类别  lxt
    */
    public function dels_type(){
        $ids=$_POST['ids'];
        $arr=array_filter(explode(',', $ids));
        foreach ($arr as $key => $value) {
            $res=db('finance')->where('id',$value)->delete();
        }
        
        if($res){
            return WSTReturn('删除成功',1);
        }else{
            return WSTReturn("删除失败", -1);   
        }

    }




    /**
     * 获取账户 lxt
     */
    public function pageQueryAccount(){
        $res=db('finance_account')->where('dataFlag',1)->paginate(input('pagesize/d'))->toArray();

        return $res;
    }




    /**
     * 添加账户 lxt
     */
    public function add_account(){
        $name=$_POST['name'];
        $number=$_POST['number'];
        $account_name=$_POST['account_name'];
        $sort=$_POST['sort'];
        
        $data['name']=$name;
        $data['number']=$number;
        $data['account_name']=$account_name;
        $data['sort']=$sort;
        $data['dataFlag']=1;
        $res=db('finance_account')->insert($data);
        if($res){
          return WSTReturn("添加成功", 1);
        }else{
          return WSTReturn("添加失败", -1); 
        }

    }

    /**
     * 获取单个账户 lxt
     */
    public function get_account(){
        $id=$_POST['id'];
        $res=db('finance_account')->where('id',$id)->find();
        return $res;
    }



    /**
     * 修改账户 lxt
     */
    public function edit_account(){
        $id=$_POST['id'];
        $name=$_POST['name'];
        $number=$_POST['number'];
        $account_name=$_POST['account_name'];
        $sort=$_POST['sort'];
        
        $data['name']=$name;
        $data['number']=$number;
        $data['account_name']=$account_name;
        $data['sort']=$sort;
        
        $res=db('finance_account')->where('id',$id)->update($data);
        if($res){
          return WSTReturn("编辑成功", 1);
        }else{
          return WSTReturn("编辑失败", -1); 
        }

    }


    /*
    批量删除供应商  lxt
    */
    public function dels_account(){
        $ids=$_POST['ids'];
        $arr=array_filter(explode(',', $ids));
        foreach ($arr as $key => $value) {
            $data['dataFlag']='-1';
            $res=db('finance_account')->where('id',$value)->update($data);
        }
        
        if($res){
            return WSTReturn('删除成功',1);
        }else{
            return WSTReturn("删除失败", -1);   
        }

    }

    /*
    删除供应商  lxt
    */
    public function del_account(){
        $id=$_POST['id'];
        $data['dataFlag']='-1';
        $res=db('finance_account')->where('id',$id)->update($data);  
        if($res){
            return WSTReturn('删除成功',1);
        }else{
            return WSTReturn("删除失败", -1);   
        }
    }



    /**
     * 获取账户 lxt
     */
    public function pageQueryFinance(){
        $where=array();
        if(!empty($_GET['s2_type'])){
           $where['type']=$_GET['s2_type'];
        }
        if(!empty($_GET['s2_types'])){
           $where['account_type']=$_GET['s2_types'];
        }
        if(!empty($_GET['s2_key'])){
            $where['number']=array('like','%'.$_GET['s2_key'].'%');
        }
        if(!empty($_GET['startDateB']) && empty($_GET['endDateB']) ){
            $where['time']=array('gt',strtotime($_GET['startDateB']));
        }
        if(empty($_GET['startDateB']) && !empty($_GET['endDateB']) ){
            $where['time']=array('lt',strtotime($_GET['endDateB']));
        }
        if(!empty($_GET['startDateB']) && !empty($_GET['endDateB']) ){
            $where['time']=array('between',array(strtotime($_GET['startDateB']),strtotime($_GET['endDateB'])));
        }
        $res=db('finance_detail')->where($where)->where('dataFlag',1)->paginate(input('pagesize/d'))->toArray();
        foreach ($res['Rows'] as $key => $value) {
          if(empty($value['time'])){
            $res['Rows'][$key]['time']='';
          }else{
            $res['Rows'][$key]['time']=date('Y-m-d',$value['time']);
          }
          $type=db('finance')->where('id',$value['account_type'])->find();
          $res['Rows'][$key]['account_type']=$type['name'];
          $bank1=db('finance_account')->where('id',$value['recive_bank'])->find();
          $res['Rows'][$key]['recive_bank']=$bank1['name'];
          $bank2=db('finance_account')->where('id',$value['pay_bank'])->find();
          $res['Rows'][$key]['pay_bank']=$bank2['name'];
          if($value['status']==1){
            $res['Rows'][$key]['status']='待确定';
          }elseif($value['status']==2){
            $res['Rows'][$key]['status']='已确定';
          }

          $operator=db('staffs')->where('staffId',$value['operator'])->find();
          $res['Rows'][$key]['operator']=$operator['staffName'];
        }
        return $res;
    }


    /**
     * 获取账号 lxt
     */

    public function get_accounts(){

        $res=db('finance_account')->where('dataFlag',1)->select();
        return $res;
    }

    /**
     * 获取财务类型 lxt
     */

    public function get_types(){
        $type=$_POST['type'];
        $res=db('finance')->where('type',$type)->select();
        return $res;
    }

    /**
     * 添加财务明细 lxt
     */
    public function add_detail(){
        $type=$_POST['type'];
        if($type==1){
          $number=$_POST['number'];
          $name=$_POST['name'];
          $money=$_POST['money'];
          $recive_bank=$_POST['recive_bank'];
          $invoice=$_POST['invoice'];
          $operator=$_POST['operator'];
          $status=$_POST['status'];
          $remark=$_POST['remark'];
          $time=strtotime($_POST['time']);
          $account_type=$_POST['account_type'];


          $data['number']=$number;
          $data['name']=$name;
          $data['type']=$type;
          $data['money']=$money;
          $data['recive_bank']=$recive_bank;
          $data['invoice']=$invoice;
          $data['operator']=$operator;
          $data['status']=$status;
          $data['remark']=$remark;
          $data['time']=$time;
          $data['account_type']=$account_type;
          $data['dataFlag']=1;
          
        }elseif($type==2){

          $number=$_POST['number'];
          $name=$_POST['name'];
          $money=$_POST['money'];
          $pay_bank=$_POST['pay_bank'];
          $invoice=$_POST['invoice'];
          $operator=$_POST['operator'];
          $status=$_POST['status'];
          $remark=$_POST['remark'];
          $time=strtotime($_POST['time']);
          $account_type=$_POST['account_type'];


          $data['number']=$number;
          $data['type']=$type;
          $data['name']=$name;
          $data['money']=$money;
          $data['pay_bank']=$pay_bank;
          $data['invoice']=$invoice;
          $data['operator']=$operator;
          $data['status']=$status;
          $data['remark']=$remark;
          $data['time']=$time;
          $data['account_type']=$account_type;
          $data['dataFlag']=1;

        }elseif($type==3){
          $number=$_POST['number'];
        
          $money=$_POST['money'];
          $pay_bank=$_POST['pay_bank'];
          $recive_bank=$_POST['recive_bank'];
          $operator=$_POST['operator'];
          $status=$_POST['status'];
          $remark=$_POST['remark'];
          $time=strtotime($_POST['time']);
          

          $data['number']=$number;
          $data['type']=$type;
          $data['money']=$money;
          $data['pay_bank']=$pay_bank;
          $data['recive_bank']=$recive_bank;
          $data['operator']=$operator;
          $data['status']=$status;
          $data['remark']=$remark;
          $data['time']=$time;
          
          $data['dataFlag']=1;
        }

        $res=db('finance_detail')->insert($data);
          if($res){
             return WSTReturn('添加成功',1);
          }else{
             return WSTReturn("添加失败", -1);
        }
    }


    /**
     * 编辑财务明细 lxt
     */
    public function edit_detail(){
        $id=$_POST['id'];
        $type=$_POST['type'];
        if($type==1){
          $number=$_POST['number'];
          $name=$_POST['name'];
          $money=$_POST['money'];
          $recive_bank=$_POST['recive_bank'];
          $invoice=$_POST['invoice'];
          $operator=$_POST['operator'];
          $status=$_POST['status'];
          $remark=$_POST['remark'];
          $time=strtotime($_POST['time']);
          $account_type=$_POST['account_type'];


          $data['number']=$number;
          $data['name']=$name;
          $data['type']=$type;
          $data['money']=$money;
          $data['recive_bank']=$recive_bank;
          $data['invoice']=$invoice;
          $data['operator']=$operator;
          $data['status']=$status;
          $data['remark']=$remark;
          $data['time']=$time;
          $data['account_type']=$account_type;
          
          
        }elseif($type==2){

          $number=$_POST['number'];
          $name=$_POST['name'];
          $money=$_POST['money'];
          $pay_bank=$_POST['pay_bank'];
          $invoice=$_POST['invoice'];
          $operator=$_POST['operator'];
          $status=$_POST['status'];
          $remark=$_POST['remark'];
          $time=strtotime($_POST['time']);
          $account_type=$_POST['account_type'];


          $data['number']=$number;
          $data['type']=$type;
          $data['name']=$name;
          $data['money']=$money;
          $data['pay_bank']=$pay_bank;
          $data['invoice']=$invoice;
          $data['operator']=$operator;
          $data['status']=$status;
          $data['remark']=$remark;
          $data['time']=$time;
          $data['account_type']=$account_type;
          

        }elseif($type==3){
          $number=$_POST['number'];
        
          $money=$_POST['money'];
          $pay_bank=$_POST['pay_bank'];
          $recive_bank=$_POST['recive_bank'];
          $operator=$_POST['operator'];
          $status=$_POST['status'];
          $remark=$_POST['remark'];
          $time=strtotime($_POST['time']);
          

          $data['number']=$number;
          $data['type']=$type;
          $data['money']=$money;
          $data['pay_bank']=$pay_bank;
          $data['recive_bank']=$recive_bank;
          $data['operator']=$operator;
          $data['status']=$status;
          $data['remark']=$remark;
          $data['time']=$time;
          
        }

        $res=db('finance_detail')->where('id',$id)->update($data);
          if($res){
             return WSTReturn('修改成功',1);
          }else{
             return WSTReturn("修改失败", -1);
        }
    }
    
     /**
     * 删除财务明细 lxt
     */
    public function del_detail(){
        $id=$_POST['id'];
        $data['dataFlag']='-1';
        $res=db('finance_detail')->where('id',$id)->update($data);  
        if($res){
            return WSTReturn('删除成功',1);
        }else{
            return WSTReturn("删除失败", -1);   
        }
    }


    /**
     * 批量删除财务明细 lxt
     */
    
    public function dels_detail(){
        $ids=$_POST['ids'];
        $arr=array_filter(explode(',', $ids));
        foreach ($arr as $key => $value) {
            $data['dataFlag']='-1';
            $res=db('finance_detail')->where('id',$value)->update($data);
        }
        
        if($res){
            return WSTReturn('删除成功',1);
        }else{
            return WSTReturn("删除失败", -1);   
        }

    }

    /**
     * 获取单个财务明细 lxt
     */

    public function get_detail(){
        $id=$_POST['id'];
        $res=db('finance_detail')->where('id',$id)->find();
        $res['time']=date('Y-m-d',$res['time']);
        return $res;
    }



    /**
     * 获取财务统计 lxt
     */
    public function pageQueryStatistics(){
        //收入
        $where=array();
        if(!empty($_GET['startDateD']) && empty($_GET['endDateD']) ){
            $where['time']=array('gt',strtotime($_GET['startDateB']));
        }
        if(empty($_GET['startDateD']) && !empty($_GET['endDateD']) ){
            $where['time']=array('lt',strtotime($_GET['endDateB']));
        }
        if(!empty($_GET['startDateD']) && !empty($_GET['endDateD']) ){
            $where['time']=array('between',array(strtotime($_GET['startDateB']),strtotime($_GET['endDateB'])));
        }
        $total_ss=db('finance_detail')->where($where)->where('type',1)->where('dataFlag',1)->sum('money');
        $total_zs=db('finance_detail')->where($where)->where('type',2)->where('dataFlag',1)->sum('money');

        $total_sw=db('finance_detail')->whereTime('time','w')->where('type',1)->where('dataFlag',1)->sum('money');
        $total_sm=db('finance_detail')->whereTime('time','m')->where('type',1)->where('dataFlag',1)->sum('money');
        $total_sy=db('finance_detail')->whereTime('time','y')->where('type',1)->where('dataFlag',1)->sum('money');
        $res=db('finance')->where('type',1)->select();
        $arr=array();
        foreach ($res as $key => $value) {
          $sw=db('finance_detail')->whereTime('time','w')->where('account_type',$value['id'])->where('dataFlag',1)->sum('money');
          $sm=db('finance_detail')->whereTime('time','m')->where('account_type',$value['id'])->where('dataFlag',1)->sum('money');
          $sy=db('finance_detail')->whereTime('time','y')->where('account_type',$value['id'])->where('dataFlag',1)->sum('money');
          $arr['shouru'][$key]['name']=$value['name'];
          $arr['shouru'][$key]['sw']=$sw;
          $arr['shouru'][$key]['sm']=$sm;
          $arr['shouru'][$key]['sy']=$sy;
        }
        //支出
        $total_zw=db('finance_detail')->whereTime('time','w')->where('type',2)->where('dataFlag',1)->sum('money');
        $total_zm=db('finance_detail')->whereTime('time','m')->where('type',2)->where('dataFlag',1)->sum('money');
        $total_zy=db('finance_detail')->whereTime('time','y')->where('type',2)->where('dataFlag',1)->sum('money');
        $res1=db('finance')->where('type',2)->select();
        foreach ($res1 as $key => $value) {
          $zw=db('finance_detail')->whereTime('time','w')->where('account_type',$value['id'])->where('dataFlag',1)->sum('money');
          $zm=db('finance_detail')->whereTime('time','m')->where('account_type',$value['id'])->where('dataFlag',1)->sum('money');
          $zy=db('finance_detail')->whereTime('time','y')->where('account_type',$value['id'])->where('dataFlag',1)->sum('money');
          $arr['zhichu'][$key]['name']=$value['name'];
          $arr['zhichu'][$key]['zw']=$zw;
          $arr['zhichu'][$key]['zm']=$zm;
          $arr['zhichu'][$key]['zy']=$zy;
        }
        $arr['total']['total_sw']=$total_sw;
        $arr['total']['total_sm']=$total_sm;
        $arr['total']['total_sy']=$total_sy;
        $arr['total']['total_zw']=$total_zw;
        $arr['total']['total_zm']=$total_zm;
        $arr['total']['total_zy']=$total_zy;
        $arr['total']['total_ss']=$total_ss;
        $arr['total']['total_zs']=$total_zs;

        return $arr;

    }










    /**
     * 获取指定记录
     */
    public function tologmoneys(){
        $m = new M();
        $object = $m->getUserInfoByType();
        $this->assign("object",$object);
        return $this->fetch("list_log");
    }
    public function pageQuery(){
        $m = new M();
        return $m->pageQuery();
    }
}
