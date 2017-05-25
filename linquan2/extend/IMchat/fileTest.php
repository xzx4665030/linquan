<?php
    include "TopSdk.php";
    date_default_timezone_set('Asia/Shanghai'); 

    $c = new TopClient;
    $c->appkey = '23719018';
    $c->secretKey = 'e0aea0fa6f26e7d8b95f47b95a3d4568';
    // $req = new TradeVoucherUploadRequest;
    // $req->setFileName("example");
    // $req->setFileData("@/Users/xt/Downloads/1.jpg");
    // $req->setSellerNick("奥利奥官方旗舰店");
    // $req->setBuyerNick("101NufynDYcbjf2cFQDd62j8M/mjtyz6RoxQ2OL1c0e/Bc=");
    // var_dump($c->execute($req));

    // $req2 = new TradeVoucherUploadRequest;
    // $req2->setFileName("example");

    // $myPic = array(
    //         'type' => 'application/octet-stream',
    //         'content' => file_get_contents('/Users/xt/Downloads/1.jpg')
    //         );
    // $req2->setFileData($myPic);
    // $req2->setSellerNick("奥利奥官方旗舰店");
    // $req2->setBuyerNick("101NufynDYcbjf2cFQDd62j8M/mjtyz6RoxQ2OL1c0e/Bc=");
	
	
    // $req = new OpenimUsersAddRequest;   //添加用户
    // $userinfos = new Userinfos;
    // $userinfos->nick="king";
    // $userinfos->icon_url="http://xxx.com/xxx";
    // $userinfos->email="uid@taobao.com";
    // $userinfos->mobile="18600000000";
    // $userinfos->taobaoid="lxt1234567";
    // $userinfos->userid="1234567";
    // $userinfos->password="1234567";
    // $userinfos->remark="demo";
    // $userinfos->extra="{}";
    // $userinfos->career="demo";
    // $userinfos->vip="{}";
    // $userinfos->address="demo";
    // $userinfos->name="demo";
    // $userinfos->age="123";
    // $userinfos->gender="M";
    // $userinfos->wechat="demo";
    // $userinfos->qq="demo";
    // $userinfos->weibo="demo";
    // $req->setUserinfos(json_encode($userinfos));
    // $resps = $c->execute($req);
	// var_dump($resps);

    // $req = new OpenimUsersGetRequest;         //批量查询
    // $req->setUserids("lxt1234567,lxt123456781");
    // $resp = $c->execute($req);
	
	//获取openim账号的聊天关系
	$c = new TopClient;
	$c->appkey = '23719018';
	$c->secretKey = 'e0aea0fa6f26e7d8b95f47b95a3d4568';
	$req = new OpenimRelationsGetRequest;
	$req->setBegDate("20170501");
	$req->setEndDate("20170511");
	$user = new OpenImUser;
	$user->uid="123456";
	$user->taobao_account="false";
	//$user->app_key="demo";
	$req->setUser(json_encode($user));
	$resp = $c->execute($req);
	

    // $req = new OpenimUsersUpdateRequest;    //更新用户信息
    // $userinfos = new Userinfos;
    // $userinfos->nick="lxt";
    // $userinfos->icon_url="http://lxt.com";
    // $userinfos->email="ceshi@taobao.com";
    // $userinfos->mobile="18600000001";
    // $userinfos->taobaoid="tbnick123";
    // $userinfos->userid="123456";
    // $userinfos->password="123456";
    // $userinfos->remark="demo1";
    // $userinfos->extra="{}";
    // $userinfos->career="demo1";
    // $userinfos->vip="{}";
    // $userinfos->address="demo1";
    // $userinfos->name="demo1";
    // $userinfos->age="1231";
    // $userinfos->gender="M";
    // $userinfos->wechat="demo1";
    // $userinfos->qq="demo1";
    // $userinfos->weibo="demo1";
    // $req->setUserinfos(json_encode($userinfos));
    // $resp = $c->execute($req);


    // $req = new OpenimTribeCreateRequest;  //创建群
    // $user = new OpenImUser;
    // $user->uid="lxt1234567";
    // $user->taobao_account="false";
    // $user->app_key="23719018";
    // $req->setUser(json_encode($user));
    // $req->setTribeName("tribenamedemp");
    // $req->setNotice("tribetypedemp");
    // $req->setTribeType("1");
    // $members = new OpenImUser;
    // $members->uid="lxt1234567";
    // $members->taobao_account="false";
    // $members->app_key="23719018";
    // $req->setMembers(json_encode($members));
    // $resp = $c->execute($req);

    // $req = new OpenimTribeGetmembersRequest; //获取群成员
    // $user = new OpenImUser;
    // $user->uid="lxt1234567";
    // $user->taobao_account="false";
    // $user->app_key="23719018";
    // $req->setUser(json_encode($user));
    // $req->setTribeId("119804842");
    // $resp = $c->execute($req);


    // $req = new OpenimTribeJoinRequest;//加入群
    // $user = new OpenImUser;
    // $user->uid="imuser123";
    // $user->taobao_account="false";
    // $user->app_key="23719018";
    // $req->setUser(json_encode($user));
    // $req->setTribeId("119804842");
    // $resp = $c->execute($req);

    // $req = new OpenimTribeExpelRequest; //群踢出成员
    // $user = new OpenImUser;
    // $user->uid="123456";
    // $user->taobao_account="false";
    // $user->app_key="23719018";
    // $req->setUser(json_encode($user));
    // $req->setTribeId("119804842");
    // $member = new OpenImUser;
    // $member->uid="imuser123";
    // $member->taobao_account="false";
    // $member->app_key="23719018";
    // $req->setMember(json_encode($member));
    // $resp = $c->execute($req);

    // $req = new OpenimTribeSetmanagerRequest;  //设置群管理员
    // $user = new OpenImUser;
    // $user->uid="lxt1234567";
    // $user->taobao_account="false";
    // $user->app_key="23719018";
    // $req->setUser(json_encode($user));
    // $req->setTid("119804842");
    // $member = new OpenImUser;
    // $member->uid="123456";
    // $member->taobao_account="false";
    // $member->app_key="23719018";
    // $req->setMember(json_encode($member));
    // $resp = $c->execute($req);

    // $req = new OpenimTribeGetalltribesRequest;  //获取群列表
    // $user = new OpenImUser; 
    // $user->uid="lxt1234567";
    // $user->taobao_account="false";
    // $user->app_key="23719018";
    // $req->setUser(json_encode($user));
    // $req->setTribeTypes("0,1");
    // $resp = $c->execute($req);

    // $req = new OpenimImmsgPushRequest;  //发消息
    // $immsg = new ImMsg;
    // $immsg->from_user="123456";
    // $immsg->to_users=["lxt1234567"];
    // $immsg->msg_type="0";
    // $immsg->context="刘秀涛shiSB";
    // $immsg->to_appkey="0";
    // $immsg->media_attr="{\"type\":\"amr\",\"playtime\":6}";
    // $immsg->from_taobao="0";
    // $req->setImmsg(json_encode($immsg));
    // $resp = $c->execute($req);

	//查询聊天记录
    // $req = new OpenimChatlogsGetRequest;
    // $user1 = new OpenImUser;
    // $user1->uid="lxt1234567";
    // $user1->taobao_account="false";
    // $user1->app_key="23719018";
    // $req->setUser1(json_encode($user1));
    // $user2 = new OpenImUser;
    // $user2->uid="123456";
    // $user2->taobao_account="false";
    // $user2->app_key="23719018";
    // $req->setUser2(json_encode($user2));
    // $req->setBegin("1494345600");
    // $req->setEnd("1494471089");
	
    // $req->setCount("100");
    // /* $req->setNextKey("sdjfshkhdj=="); */
    // $resp = $c->execute($req);

    echo json_encode($resp);die;
?>