<?php
namespace wstmart\admin\model;
/**

 * 友情链接业务处理
 */
use think\Db;
class friendlinks extends Base{
	/**
	 * 分页
	 */
	public function pageQuery(){
		return $this->where('dataFlag',1)->field('friendlinkId,friendlinkName,friendlinkIco,friendlinkSort,friendlinkUrl')->order('friendlinkId desc')->paginate(input('pagesize/d'));
	}
	public function getById($id){
		return $this->get(['friendlinkId'=>$id,'dataFlag'=>1]);
	}
	/**
	 * 新增
	 */
	public function add(){
		$data = input('post.');
		$data['createTime'] = date('Y-m-d H:i:s');
		WSTUnset($data,'friendlinkId');
		Db::startTrans();
		try{
			$result = $this->validate('friendlinks.add')->allowField(true)->save($data);
			$id = $this->friendlinkId;
	        if(false !== $result){
	        	//启用上传图片
			    WSTUseImages(1, $id, $data['friendlinkIco']);
			    Db::commit();
	        	return WSTReturn("新增成功", 1);
	        }
		}catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn('新增失败',-1);
	}
    /**
	 * 编辑
	 */
	public function edit(){
		$id = (int)input('post.friendlinkId');
		$data = input('post.');
		WSTUnset($data,'createTime');
		Db::startTrans();
		try{
			WSTUseImages(1, $id, $data['friendlinkIco'], 'friendlinks', 'friendlinkIco');
		    $result = $this->validate('friendlinks.edit')->allowField(true)->save($data,['friendlinkId'=>$id]);
	        if(false !== $result){
	        	Db::commit();
	        	return WSTReturn("编辑成功", 1);
	        }
	    }catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn('编辑失败',-1);  
	}
	/**
	 * 删除
	 */
    public function del(){
	    $id = input('post.id/d');
	    Db::startTrans();
		try{
			$data = [];
			$data['dataFlag'] = -1;
		    $result = $this->update($data,['friendlinkId'=>$id]);
	        if(false !== $result){
	        	WSTUnuseImage('friendlinks','friendlinkIco',$id);
	        	Db::commit();
	        	return WSTReturn("删除成功", 1);
	        }
		}catch (\Exception $e) {
            Db::rollback();
            return WSTReturn('删除失败',-1);
        }
	}
	
}
