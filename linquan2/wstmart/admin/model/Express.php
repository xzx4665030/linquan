<?php
namespace wstmart\admin\model;
/**

 * 快递业务处理
 */
class Express extends Base{
	/**
	 * 分页
	 */
	public function pageQuery(){
		return $this->where('dataFlag',1)->field('expressId,expressName,expressCode')->order('expressId desc')->paginate(input('pagesize/d'));
	}
	public function getById($id){
		return $this->get(['expressId'=>$id,'dataFlag'=>1]);
	}
	/**
	 * 新增
	 */
	public function add(){
		$data = ['expressName'=>input('post.expressName'),'expressCode'=>input('post.expressCode'),'expressTel'=>input('post.expressTel')];

		$result = $this->validate('Express.add')->allowField(['expressName','expressCode','expressTel'])->save($data);
        if(false !== $result){
        	return WSTReturn("新增成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
    /**
	 * 编辑
	 */
	public function edit(){
		$expressId = input('post.expressId/d',0);
	    $result = $this->validate('Express.edit')->allowField(['expressName','expressCode','expressTel'])->save(['expressName'=>input('post.expressName'),'expressCode'=>input('post.expressCode'),'expressTel'=>input('post.expressTel')],['expressId'=>$expressId]);

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
		$data['dataFlag'] = -1;
	    $result = $this->update($data,['expressId'=>$id]);
        if(false !== $result){
        	return WSTReturn("删除成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
	
}
