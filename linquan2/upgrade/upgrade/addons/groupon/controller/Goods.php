<?php
namespace addons\groupon\controller;

use think\addons\Controller;
use addons\groupon\model\Groupons as M;
/**
 * ============================================================================
 * WSTMart多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.wstmart.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！未经本公司授权您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 团购商品插件
 */
class Goods extends Controller{
	public function __construct(){
		parent::__construct();
        $m = new M();
        $data = $m->getConfigs();
        $this->assign("seoGrouponKeywords",$data['seoGrouponKeywords']);
        $this->assign("seoGrouponDesc",$data['seoGrouponDesc']);
		$this->assign("v",WSTConf('CONF.wstVersion')."_".WSTConf('CONF.wstPCStyleId'));
	}

	/**
	 * 团购列表
	 */
	public function lists(){
        $catId = (int)input('catId');
        $orderBy = (int)input('orderBy');
        $order = (int)input('order');
        $data = [];
        $data['grouponCatId'] = $catId;
        $m = new M();
        $data['goodsPage'] = $m->pageQuery();
        $cats = WSTGoodsCats(0);
        $catName = '全部商品分类';
        foreach($cats as $k => $v){
            if($catId==$v['catId'])$catName = $v['catName'];
        }
        $data['catName'] = $catName;
        $data['catList'] = $cats;
		return $this->fetch("/home/index/list",$data);
	}

    /**
     * 商品详情
     */
    public function detail(){
        $m = new M();
        $goodsId = input('id/d',0);
        $goods = $m->getBySale($goodsId);
        if(!empty($goods)){
            $history = cookie("history_goods");
            $history = is_array($history)?$history:[];
            array_unshift($history, (string)$goods['goodsId']);
            $history = array_values(array_unique($history));
            
            if(!empty($history)){
                cookie("history_goods",$history,25920000);
            }
            $this->assign('goods',$goods);
            $this->assign('shop',$goods['shop']);
            
            //分享信息
            $conf = $m->getConfigs();
            $shareInfo['link'] = addon_url('groupon://goods/detail',array('id'=>$goodsId,'shareUserId'=>base64_encode((int)session('WST_USER.userId'))),true,true);
            $shareInfo['title'] = $goods['goodsName'];
            $shareInfo['desc'] = (isset($conf["goodsShareTitle"]) && $conf["goodsShareTitle"]!="")?$conf["goodsShareTitle"]:WSTConf("CONF.mallSlogan");
            $shareInfo['imgUrl'] = WSTRoot()."/".$goods['goodsImg'];
            $this->assign('shareInfo', $shareInfo);
            
            return $this->fetch("/home/index/detail");
        }else{
            $this->redirect('home/error/goods');
        }
    }


    /**
     * 查看团购商品列表
     */
    public function pageByAdmin(){
        $this->checkAdminPrivileges();
        $this->assign("areaList",model('common/areas')->listQuery(0));
        return $this->fetch("/admin/list");
    }

    /**
     * 查询团购商品
     */
    public function pageQueryByAdmin(){
        $this->checkAdminPrivileges();
        $m = new M();
        return $m->pageQueryByAdmin(1);
    }
    /**
     * 查询待审核团购商品
     */
    public function pageAuditQueryByAdmin(){
        $this->checkAdminPrivileges();
        $m = new M();
        return $m->pageQueryByAdmin(0);
    }

    /**
    * 设置违规商品
    */
    public function illegal(){
        $this->checkAdminPrivileges();
        $m = new M();
        return $m->illegal();
    }
    /**
     * 通过商品审核
     */
    public function allow(){
        $this->checkAdminPrivileges();
        $m = new M();
        return $m->allow();
    }

    /**
     * 删除
     */
    public function delByAdmin(){
        $this->checkAdminPrivileges();
        $m = new M();
        return $m->delByAdmin();
    }
    
    /**
     * 微信团购列表页
     */
    public function wxlists(){
    	$gModel = model('wechat/GoodsCats');
    	$data['goodscats'] = $gModel->getGoodsCats();
    	$this->assign("keyword", input('keyword'));
    	$this->assign("goodsCatId", input('goodsCatId/d'));
    	$this->assign("data", $data);
    	return $this->fetch("/wechat/index/list");
    }
    /**
     * 团购列表
     */
    public function wxGrouplists(){
    	$m = new M();
    	$rs = $m->pageQuery();
    	if(!empty($rs['Rows'])){
    		foreach ($rs['Rows'] as $key =>$v){
    			$rs['Rows'][$key]['goodsImg'] = WSTImg($v['goodsImg'],2);
    		}
    	}
    	return $rs;
    }
    /**
     * 微信商品详情
     */
    public function wxdetail(){
    	$m = new M();
    	$goodsId = input('id/d',0);
    	$goods = $m->getBySale($goodsId);
    	
    	if(!empty($goods)){
    		$goods['goodsDesc']=htmlspecialchars_decode($goods['goodsDesc']);
    		$rule = '/<img src="\/(upload.*?)"/';
    		preg_match_all($rule, $goods['goodsDesc'], $images);
    		
    		foreach($images[0] as $k=>$v){
    			$goods['goodsDesc'] = str_replace('/'.$images[1][$k], request()->root().'/'.WSTConf("CONF.goodsLogo") . "\"  data-echo=\"".request()->root()."/".WSTImg($images[1][$k],3), $goods['goodsDesc']);
    		}
    		
    		$history = cookie("history_goods");
    		$history = is_array($history)?$history:[];
    		array_unshift($history, (string)$goods['goodsId']);
    		$history = array_values(array_unique($history));
    
    		if(!empty($history)){
    			cookie("history_goods",$history,25920000);
    		}
    		$this->assign('info',$goods);
    		$we = WSTWechat();
    		$datawx = $we->getJsSignature('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    		$this->assign("datawx", $datawx);
    		
    		//分享信息
    		$conf = $m->getConfigs();
    		$shareInfo['link'] = addon_url('groupon://goods/wxdetail',array('id'=>$goodsId,'shareUserId'=>base64_encode((int)session('WST_USER.userId'))),true,true);
    		$shareInfo['title'] = $goods['goodsName'];
    		$shareInfo['desc'] = (isset($conf["goodsShareTitle"]) && $conf["goodsShareTitle"]!="")?$conf["goodsShareTitle"]:WSTConf("CONF.mallSlogan");
    		$shareInfo['imgUrl'] = WSTRoot()."/".$goods['goodsImg'];
    		$this->assign('shareInfo', $shareInfo);
    		
    		return $this->fetch("/wechat/index/detail");
    	}else{
    		session('wxdetail','对不起你要找的商品不见了~~o(>_<)o~~');
    		$this->redirect('wechat/error/message',['code'=>'wxdetail']);
    	}
    }
    
    /**
     * 手机团购列表页
     */
    public function molists(){
    	$gModel = model('mobile/GoodsCats');
    	$data['goodscats'] = $gModel->getGoodsCats();
    	$this->assign("keyword", input('keyword'));
    	$this->assign("goodsCatId", input('goodsCatId/d'));
    	$this->assign("data", $data);
    	return $this->fetch("/mobile/index/list");
    }
    /**
     * 手机商品详情
     */
    public function modetail(){
    	$m = new M();
    	$goodsId = input('id/d',0);
    	$goods = $m->getBySale($goodsId);
    	if(!empty($goods)){
    		$goods['goodsDesc']=htmlspecialchars_decode($goods['goodsDesc']);
    		$rule = '/<img src="\/(upload.*?)"/';
    		preg_match_all($rule, $goods['goodsDesc'], $images);
    
    		foreach($images[0] as $k=>$v){
    			$goods['goodsDesc'] = str_replace('/'.$images[1][$k], request()->root().'/'.WSTConf("CONF.goodsLogo") . "\"  data-echo=\"".request()->root()."/".WSTImg($images[1][$k],3), $goods['goodsDesc']);
    		}
    
    		$history = cookie("history_goods");
    		$history = is_array($history)?$history:[];
    		array_unshift($history, (string)$goods['goodsId']);
    		$history = array_values(array_unique($history));
    
    		if(!empty($history)){
    			cookie("history_goods",$history,25920000);
    		}
    		$this->assign('info',$goods);
    		
    		//分享信息
    		$conf = $m->getConfigs();
    		$shareInfo['link'] = addon_url('groupon://goods/modetail',array('id'=>$goodsId,'shareUserId'=>base64_encode((int)session('WST_USER.userId'))),true,true);
    		$shareInfo['title'] = $goods['goodsName'];
    		$shareInfo['desc'] = (isset($conf["goodsShareTitle"]) && $conf["goodsShareTitle"]!="")?$conf["goodsShareTitle"]:WSTConf("CONF.mallSlogan");
    		$shareInfo['imgUrl'] = WSTRoot()."/".$goods['goodsImg'];
    		$this->assign('shareInfo', $shareInfo);
    		
    		return $this->fetch("/mobile/index/detail");
    	}else{
    		session('modetail','对不起你要找的商品不见了~~o(>_<)o~~');
    		$this->redirect('mobile/error/message',['code'=>'modetail']);
    	}
    }
}