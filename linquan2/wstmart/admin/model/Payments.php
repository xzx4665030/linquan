<?php
namespace wstmart\admin\model;
/**

 * 支付管理业务处理
 */
class Payments extends Base{
	/**
	 * 分页
	 */
	public function pageQuery(){
		return $this->field(true)->order('id desc')->paginate(input('pagesize/d'));
	}
	public function getById($id){
		return $this->get(['id'=>$id]);
	}
	
    /**
	 * 编辑
	 */
	public function edit(){
		$Id = input('post.id/d',0);
		//获取数据
		$data = input('post.');
		$data["payConfig"] = isset($data['payConfig'])?json_encode($data['payConfig']):"";
		$data['enabled']=1;
	    $result = $this->validate('payments.edit')->allowField(true)->save($data,['id'=>$Id]);
        if(false !== $result){
        	return WSTReturn("编辑成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
	/**
	 * 删除
	 */
    public function del(){
	    $id = input('post.id/d',0);
		$data = [];
		$data['enabled'] = 0;
	    $result = $this->update($data,['id'=>$id]);
        if(false !== $result){
        	return WSTReturn("卸载成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
	
}
