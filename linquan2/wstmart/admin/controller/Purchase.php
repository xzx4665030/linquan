<?php
namespace wstmart\admin\controller;

/**

 * 商家认证控制器
 */
 use think\Db;
class Purchase extends Base{
	
    public function index(){
        $where = [];
        $where['dataFlag'] = 1;
    	$purchase=  db('purchase')->where($where)->paginate(input('pagesize/d'))->toArray();
        foreach ($purchase['Rows'] as $key => $value) {
           $supplier = db('supplier')->where('id',$value['supplier_id'])->find();
           $purchase['Rows'][$key]['company']=$supplier['company'];

           $stock= db('roles')->where('roleId',$value['store_id'])->find();
           $purchase['Rows'][$key]['roleName']=$stock['roleName'];

           $staffs= db('staffs')->where('staffId',$value['manager_id'])->find();
           $purchase['Rows'][$key]['loginName']=$staffs['loginName'];
        }

        return $purchase;
    }
    

   /**
   * 获取经办人   lxt
   */
    public function get_manager(){
        $key = input('id');
        
        $where['dataFlag'] = 1;
        $where['staffStatus'] = 1;
        $where['staffRoleId'] = $key ;     
        $list =  db('staffs')->where($where)->select();
        if($key==0){
           return 1;
        }else{
           return $list;
        }
       
    }


    /**
   * 添加采购   lxt
   */
    public function add_purchase(){
        $pur_number=$_POST['pur_number'];
        $store_id=$_POST['store_id'];
        $supplier_id=$_POST['supplier_id'];
        $pur_time=$_POST['pur_time'];
        $note=$_POST['note'];
        $manager_id=$_POST['manager_id'];
        $goods=$_POST['goods'];

        $data['pur_number']=$pur_number;
        $data['store_id']=$store_id;
        $data['supplier_id']=$supplier_id;
        $data['pur_time']=$pur_time;
        $data['note']=$note;
        $data['manager_id']=$manager_id;
        $data['times']=date('Y-m-d H-i-s',time());
        $data['dataFlag']=1;
        
        $res=db('purchase')->insert($data);
        
        $arr=array_filter(explode(';', $goods));  
        foreach ($arr as $key => $value) {
          $result=explode(',', $value);
          $datas['p_number']=$pur_number;
          $datas['p_good_id']=$result[0];
          $datas['p_huohao']=$result[1];
          $datas['pnumber']=$result[2];
          $datas['stock_id']=$store_id;
          $res1=db('purchase_good')->insert($datas);
          //修改库存
          $sql=db('supplier_goods_spec')->where('s_huohao', $result[1])->find();
          if($sql){
              $update=db('supplier_goods_spec')->where('s_huohao', $result[1])->setDec('stock', $result[2]);
          }else{
              $update=db('supplier_goods')->where('productNo', $result[1])->setDec('goodsStock', $result[2]);

          }
          
           //插入记录
          $datass['pur_number']=$pur_number;
          $datass['states']=1;
          $datass['do_time']=time();
          $datass['sum']=$result[2];
          $datass['huohao']=$result[1];
          $log=db('log_stocks_shops')->insert($datass);
          
        }
       

       

        if($res){
            return WSTReturn('添加成功',1);
        }else{
            return WSTReturn('添加失败',-1);
        }
    }

  /**
   * 删除采购   lxt
   */
    public function del_purchase(){
        $id=$_POST['id'];
        $data['dataFlag']='-1';
        $res=db('purchase')->where('id',$id)->update($data);
        if($res){
            return WSTReturn('删除成功',1);
        }else{
            return WSTReturn('删除失败',-1);
        }
    }


    /**
   * 批量删除采购   lxt
   */
    public function dels_purchase(){
        $ids=$_POST['ids'];
        $arr=array_filter(explode(',', $ids));
      
        foreach ($arr as $key => $value) {
          $data['dataFlag']='-1';
          $res=Db::name('purchase')->where('id',$value)->update($data);
        }
        if($res){
            return WSTReturn('删除成功',1);
        }else{
            return WSTReturn('删除失败',-1);
        }
    }

   /**
   * 获取供应商商品   lxt
   */

   public function get_goods(){
      $where['a.supplier_id']=$_POST['id'];
      $where['a.dataFlag']=1;
      $goods=db('supplier_goods')->alias('a')->join("supplier_goods_spec b","a.id=b.good_id",'left')->where($where)->select();
      $arr=array();
      foreach ($goods as $key => $value) {
        $arr[$key]['id']=$value['id'];
        if(empty($value['s_huohao'])){
           $arr[$key]['huohao']=$value['productNo'];
        }else{
           $arr[$key]['huohao']=$value['s_huohao'];
        }
        $arr[$key]['goodsName']=$value['goodsName'];
        $arr[$key]['goodsUnit']=$value['goodsUnit'];
        if(empty($value['stock'])){
            $arr[$key]['stock']=$value['goodsStock'];
        }else{
            $arr[$key]['stock']=$value['stock'];
        }
        if(empty($value['spec_value'])){
           $arr[$key]['spec']='';
        }else{
           $specs=array_filter(explode(',', $value['spec_value']));
           $aaa='';
           foreach ($specs as $k => $v) {
             $aaa=$aaa.$v.'/';
           }
           $arr[$key]['spec']=$aaa;
        }
        
      }
      return  $arr;
   }


    /**
   * 编辑采购   lxt
   */
   public function get_purchase(){
      $id=$_POST['id'];
      $res=db('purchase')->where('id',$id)->find();
      $goods=db('purchase_good')->where('p_number',$res['pur_number'])->select();
      foreach ($goods as $key => $value) {
       
          $good=db('supplier_goods_spec')->alias('a')->join('supplier_goods b','a.good_id=b.id')->where('a.s_huohao',$value['p_huohao'])->find();
          if(empty($good)){
             $good=db('supplier_goods')->where('productNo',$value['p_huohao'])->find();
             $good['s_huohao']=$good['productNo'];
             $good['spec_value']='';
             $good['stock']=$good['goodsStock'];
          }
          
          if(!empty($good['spec_value'])){
             $specs=array_filter(explode(',', $good['spec_value']));
             $aaa='';
             foreach ($specs as $k => $v) {
               $aaa=$aaa.$v.'/';
             }
             $good['spec_value']=$aaa;
          }
        $number=db('log_stocks_shops')->where('pur_number',$res['pur_number'])->where('huohao',$value['p_huohao'])->find();
        if(empty($number)){
            $good['sum']=0;
        }else{
           $good['sum']=$number['sum'];
        }
        

        $res['goods'][$key]=empty($good)?'':$good;
        

      }
      
      return $res;
   }

}
