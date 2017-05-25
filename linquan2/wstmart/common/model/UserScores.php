<?php
namespace wstmart\common\model;
/**
 * 积分业务处理器
 */
class UserScores extends Base{
     /**
      * 获取列表
      */
      public function pageQuery($userId){
      	  $type = (int)input('post.type');
          $where = ['userId'=>(int)$userId];
          if($type!=-1)$where['scoreType'] = $type;
          $page = $this->where($where)->order('scoreId desc')->paginate()->toArray();
          foreach ($page['Rows'] as $key => $v){
          	  $page['Rows'][$key]['dataSrc'] = WSTLangScore($v['dataSrc']);
          }
          return $page;
      }

      /**
       * 新增记录
       */
      public function add($score,$isAddTotal = false){
          $score['createTime'] = date('Y-m-d H:i:s');
          $this->create($score);
          $user = model('common/users')->get($score['userId']);
          if($score['scoreType']==1){
             $user->userScore = $user->userScore + $score['score'];
             if($isAddTotal)$user->userTotalScore = $user->userTotalScore+$score['score'];
          }else{
             $user->userScore = $user->userScore - $score['score'];
          }
          $user->save();
      }
}
