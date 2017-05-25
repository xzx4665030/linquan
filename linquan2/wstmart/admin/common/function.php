<?php
use think\Db;
/**

 */
/**
 * 加载系统访问路径
 */
function WSTVisitPrivilege(){
	 $listenUrl = cache('WST_LISTEN_URL');
	 if(!$listenUrl){
	     $list = model('admin/Privileges')->getAllPrivileges();
	     $listenUrl = [];
	     foreach ($list as $v){
	     	if($v['privilegeUrl']=='')continue;
	        $listenUrl[strtolower($v['privilegeUrl'])] = ['code'=>$v['privilegeCode'],
												          'url'=>$v['privilegeUrl'],
												          'name'=>$v['privilegeName'],
												          'isParent'=>true,
	        			                                  'menuId'=>$v['menuId']
	                                                     ];
	        if(strpos($v['otherPrivilegeUrl'],'/')!==false){
	        	$t = explode(',',$v['otherPrivilegeUrl']);
	        	foreach ($t as $vv){
	        		if(strpos($vv,'/')!==false){
	        			$listenUrl[strtolower($vv)] = ['code'=>$v['privilegeCode'],
									        		   'url'=>$vv,
									        		   'name'=>$v['privilegeName'],
									        		   'isParent'=>false,
	        			                               'menuId'=>$v['menuId']
									        		  ];
	        		}
	        	}
	        }
	     }
	     cache('WST_LISTEN_URL',$listenUrl);
	 }
     return $listenUrl;
}

/**
 * 判断有没有权限
 * @param $code 权限代码
 * @param $type 返回的类型  true-boolean   false-string
 */
function WSTGrant($code){
	$STAFF = session("WST_STAFF");
	if(in_array($code,$STAFF['privileges']))return true;
	return false;
}

/**
 * 循环删除指定目录下的文件及文件夹
 * @param string $dirpath 文件夹路径
 */
function WSTDelDir($dirpath){
	$dh=opendir($dirpath);
	while (($file=readdir($dh))!==false) {
		if($file!="." && $file!="..") {
		    $fullpath=$dirpath."/".$file;
		    if(!is_dir($fullpath)) {
		        unlink($fullpath);
		    } else {
		        WSTDelDir($fullpath);
		        @rmdir($fullpath);
		    }
	    }
	}	 
	closedir($dh);
    $isEmpty = true;
	$dh=opendir($dirpath);
	while (($file=readdir($dh))!== false) {
		if($file!="." && $file!="..") {
			$isEmpty = false;
			break;
		}
	}
	return $isEmpty;
}
/**
 * 微信配置
 */
function WXAdmin(){
	$wechat = new \wechat\WSTWechat(WSTConf('CONF.wxAppId'),WSTConf('CONF.wxAppKey'));
	return $wechat;
}