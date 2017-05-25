<?php
namespace wstmart\user\controller;
/**
 * 会员控制器
 */
//use think\Controller;
use think\Session;
use think\Db;
class Login extends Base{
    
    /**
    * 验证码 lxt
    */
    public function code(){
        echo header('Content-type: application/json; charset=utf-8');
        $loginName=$_GET['loginName'];
        $code=123456;
        Session::set('code',$code);
        Session::set('time',time());

        $datas['result'] = true;
        $datas['code'] = $code;
        $datas['resultString'] = '发送成功';
        echo json_encode($datas);die;
    }
    
    /**
    * 注册第一步 lxt
    */
    public function register(){
        echo header('Content-type: application/json; charset=utf-8');
        $code=$_GET['code'];
        $codes=Session::get('code');
        $time=time();
        $times=Session::get('time');
        $loginName=$_GET['loginName'];
        $loginPwd=$_GET['loginPwd'];
        
        // if(($time-$times)>60){
        //    $datas['result'] = false;
        //    $datas['resultString'] = '验证码已失效，请重新获取';
        //    echo json_encode($datas);die;
        // }
        if($code!='123456'){
           $datas['result'] = false;
           $datas['resultString'] = '验证码有误';
           echo json_encode($datas);die;
        }else{
          
           $des=db('users')->where('loginName',$loginName)->find();
           if($des){
              $datas['result'] = false;
              $datas['resultString'] = '手机号已注册';
              echo json_encode($datas);die;
           }
           $data['loginName']=$loginName;
           $data["loginSecret"] = rand(1000,9999);
           $data['loginPwd'] = md5($loginPwd.$data['loginSecret']);
           $data['userPhone']=$loginName;
           $data['userType']=0; 
           $data['userStatus']=1;
           $data['dataFlag']=1;
           $data['createTime']=date("Y-m-d H:i:s",time());
           $res=db('users')->insert($data);
           if($res){
              $datas['result'] = true;
              $datas['resultString'] = '注册成功';
              echo json_encode($datas);die;
           }else{
              $datas['result'] = false;
              $datas['resultString'] = '注册失败';
              echo json_encode($datas);die;
           }
           
        }
        
    }

    /**
    * 注册第二步 lxt
    */
     public function edit(){
        $loginName=$_POST['loginName'];
        $data['userName']=$_POST['userName'];
        $data['userSex']=$_POST['userSex'];
        //上传图片
        $file = request()->file('userPhoto');   //img是name名
        $info = $file->move('./upload/users');       
        $aaa =  $info->getSaveName();    //获取图像保存路径
        //$aaa ='20170419\929771529d4ddd6de3945baead20936d.jpg';
        $arr=explode('\\', $aaa);
        $data['userPhoto']='upload/users/'.$arr[0].'/'.$arr[1];

        $res=db('users')->where('loginName',$loginName)->update($data);
        if($res){
            $datas['result'] = true;
            $datas['resultString'] = '信息填写成功';
            echo json_encode($datas);die;
        }else{
            $datas['result'] = false;
            $datas['resultString'] = '信息填写失败';
            echo json_encode($datas);die;
        }
     }
    /**
    * 登录 lxt
    */
    public function login(){
       echo header('Content-type: application/json; charset=utf-8');
       $loginName=$_GET['loginName'];
       $loginPwd=$_GET['loginPwd'];
       $res=db('users')->where('loginName',$loginName)->find();
       if($res){
            $loginPwd=md5($loginPwd.$res['loginSecret']);
            if($loginPwd==$res['loginPwd']){
                if($res['userStatus']==1 && $res['dataFlag']==1){
                    $datas['result'] = true;
                    //$datas['token'] = $this->authcode($loginName,'ENCODE',LINQUAN_KEY,0);
                    $datas['token']= base64_encode($loginName);
                    $datas['resultString'] = '登录成功';
                    echo json_encode($datas);die;
                }else{
                    $datas['result'] = false;
                    $datas['resultString'] = '该账号不能使用，请联系客服';
                    echo json_encode($datas);die;
                }
               
            }else{
                $datas['result'] = false;
                $datas['resultString'] = '密码错误';
                echo json_encode($datas);die;
            }
       }else{
            $datas['result'] = false;
            $datas['resultString'] = '该用户不存在，请注册';
            echo json_encode($datas);die;
       }
       
    }

    /**
    * 修改头像 lxt
    */
    public function edit_img(){
        echo header('Content-type: application/json; charset=utf-8');
        $token = $_POST['token'];     
        $this->is_login($token);
        $this->is_available($token);
        $user=base64_decode($token);
        $userinfo=db('users')->where('loginName',$user)->find();
        //上传图片
        $file = request()->file('userPhoto');   //img是name名
        $info = $file->move('./upload/users');       
        $aaa =  $info->getSaveName();    //获取图像保存路径
        //$aaa ='20170419\929771529d4ddd6de3945baead20936d.jpg';
        $arr=explode('\\', $aaa);
        $data['userPhoto']='upload/users/'.$arr[0].'/'.$arr[1];

        $res=db('users')->where('userId',$userinfo['userId'])->update($data);
        if($res !==false){
            $datas['result'] = true;
            $datas['resultString'] = '头像编辑成功';
            echo json_encode($datas);die;
        }else{
            $datas['result'] = false;
            $datas['resultString'] = '头像编辑失败';
            echo json_encode($datas);die;
        }
    }
    
}
