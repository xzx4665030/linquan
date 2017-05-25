var time = 0;
var isSend = false;
$(document).ready(function(){
	WST.initFooter('user');
});
//修改登录密码
function inLogin(){
	location.href = WST.U('wechat/users/editLoginPass');
}
function editLogin(type){
	if(type==1){
		var orloginPwd = $('#orloginPwd').val();
	    if(orloginPwd==''){
	    	WST.msg('原密码不能为空','info');
		    $('#orloginPwd').focus();
	        return false;
	    }
	}
	var loginPwd = $('#loginPwd').val();
	var cologinPwd = $('#cologinPwd').val();
	if(loginPwd==''){
    	WST.msg('新密码不能为空','info');
    	$('#loginPwd').focus();
        return false;
    }
	if(cologinPwd==''){
    	WST.msg('确认密码不能为空','info');
    	$('#cologinPwd').focus();
        return false;
    }
	if(cologinPwd.length < 6 || loginPwd.length < 6){
    	WST.msg('请输入6位数字或者字母密码','info');
    	$('#cologinPwd').focus();
        return false;
    }
	if(cologinPwd!=loginPwd){
    	WST.msg('确认密码不一致','info');
    	$('#cologinPwd').focus();
        return false;
    }
	WST.load('设置中···');
    var param = {};
    param.type = type;
    param.oldPass = orloginPwd;
    param.newPass = loginPwd;
	$('#modifyPwd').addClass("active").attr('disabled', 'disabled');
    $.post(WST.U('wechat/users/editloginPwd'), param, function(data){
        var json = WST.toJson(data);
        if( json.status == 1 ){
        	WST.msg(json.msg,'success');
            setTimeout(function(){
            	location.href = WST.U('wechat/users/security');
            },2000);
        }else{
        	WST.msg(json.msg,'warn');
        	$('#modifyPwd').removeAttr('disabled').removeClass("active");
        }
        WST.noload();
        data = json = null;
    });
}
//修改支付密码
function inPay(){
	location.href = WST.U('wechat/users/editPayPass');
}
function editPay(type){
	if(type==1){
		var orpayPwd = $('#orpayPwd').val();
	    if(orpayPwd==''){
	    	WST.msg('原密码不能为空','info');
		    $('#orpayPwd').focus();
	        return false;
	    }
		if(orpayPwd.length != 6){
	    	WST.msg('请输入6位数字密码','info');
	    	$('#orpayPwd').focus();
	        return false;
	    }
	}
	var payPwd = $('#payPwd').val();
	var copayPwd = $('#copayPwd').val();
	if(payPwd==''){
    	WST.msg('新密码不能为空','info');
    	$('#payPwd').focus();
        return false;
    }
	if(copayPwd==''){
    	WST.msg('确认密码不能为空','info');
    	$('#copayPwd').focus();
        return false;
    }
	if(copayPwd.length != 6 || payPwd.length !=6){
    	WST.msg('请输入6位数字密码','info');
    	$('#copayPwd').focus();
        return false;
    }
	if(copayPwd!=payPwd){
    	WST.msg('确认密码不一致','info');
    	$('#copayPwd').focus();
        return false;
    }
	WST.load('设置中···');
    var param = {};
    param.type = type;
    param.oldPass = orpayPwd;
    param.newPass = payPwd;
	$('#modifyPwd').addClass("active").attr('disabled', 'disabled');
    $.post(WST.U('wechat/users/editpayPwd'), param, function(data){
        var json = WST.toJson(data);
        if( json.status == 1 ){
        	WST.msg(json.msg,'success');
            setTimeout(function(){
            	location.href = WST.U('wechat/users/security');
            },2000);
        }else{
        	WST.msg(json.msg,'warn');
        	$('#modifyPwd').removeAttr('disabled').removeClass("active");
        }
        WST.noload();
        data = json = null;
    });
}
//找回支付密码
function backpayCode(){
	if(window.conf.SMS_VERFY==1){
		var smsVerfy = $('#smsVerfy').val();
	    if(smsVerfy ==''){
	    	WST.msg('请输入验证码','info');
		    $('#smsVerfy').focus();
	        return false;
	    }
	}
    var param = {};
	param.smsVerfy = smsVerfy;
	if(isSend)return;
	isSend = true;
    $.post(WST.U('wechat/users/backpayCode'), param, function(data){
        var json = WST.toJson(data);
        if( json.status == 1 ){
        	WST.msg(json.msg,'success');
			time = 120;
			$('#obtain').attr('disabled', 'disabled').html('120秒获取');
			var task = setInterval(function(){
				time--;
				$('#obtain').html(''+time+"秒获取");
				if(time==0){
					isSend = false;
					clearInterval(task);
					$('#obtain').removeAttr('disabled').html("重新发送");
				}
			},1000);
        }else{
        	WST.msg(json.msg,'warn');
        	WST.getVerify("#verifyImg");
        	isSend = false;
        }
        data = json = null;
    });
}
function backPaypwd(type){
	if(type==1){
		var payPwd = $('#payPwd').val();
		var copayPwd = $('#copayPwd').val();
		if(payPwd==''){
	    	WST.msg('新密码不能为空','info');
	    	$('#payPwd').focus();
	        return false;
	    }
		if(copayPwd==''){
	    	WST.msg('确认密码不能为空','info');
	    	$('#copayPwd').focus();
	        return false;
	    }
		if(copayPwd.length != 6 || payPwd.length !=6){
	    	WST.msg('请输入6位数字密码','info');
	    	$('#copayPwd').focus();
	        return false;
	    }
		if(copayPwd!=payPwd){
	    	WST.msg('确认密码不一致','info');
	    	$('#copayPwd').focus();
	        return false;
	    }
		WST.load('设置中···');
	    var param = {};
	    param.newPass = payPwd;
		$('#modifyPwd').addClass("active").attr('disabled', 'disabled');
	    $.post(WST.U('wechat/users/resetbackPay'), param, function(data){
	        var json = WST.toJson(data);
	        if( json.status == 1 ){
	        	WST.msg(json.msg,'success');
	            setTimeout(function(){
	            	location.href = WST.U('wechat/users/security');
	            },2000);
	        }else{
	        	WST.msg(json.msg,'warn');
	        	$('#modifyPwd').removeAttr('disabled').removeClass("active");
	        }
	        WST.noload();
	        data = json = null;
	    });
	}else{
		var phoneCode = $('#phoneCode').val();
	    if(phoneCode==''){
	    	WST.msg('请输入短信验证码','info');
	    	$('#phoneCode').focus();
	        return false;
	    }
	    var param = {};
	    param.phoneCode = phoneCode;
		$('#modifyPhone').addClass("active").attr('disabled', 'disabled');
	    $.post(WST.U('wechat/users/verifybackPay'), param, function(data){
	        var json = WST.toJson(data);
	        if( json.status == 1 ){
	        	WST.msg(json.msg,'success');
	            setTimeout(function(){
	            	location.href = WST.U('wechat/users/backPayPass');
	            },2000);
	        }else{
	        	WST.msg(json.msg,'warn');
	        	$('#modifyPhone').removeAttr('disabled').removeClass("active");
	        }
	        data = json = null;
	    });	
	}
}
//修改手机
function inPhone(){
	location.href = WST.U('wechat/users/editPhone');
}
//发送短信
function obtainCode(type){
	if(type==0){
		var userPhone = $('#userPhone').val();
	    if(userPhone ==''){
	    	WST.msg('请输入手机号码','info');
		    $('#userPhone').focus();
	        return false;
	    }
	}
	if(window.conf.SMS_VERFY==1){
		var smsVerfy = $('#smsVerfy').val();
	    if(smsVerfy ==''){
	    	WST.msg('请输入验证码','info');
		    $('#smsVerfy').focus();
	        return false;
	    }
	}
    var param = {};
	param.userPhone = userPhone;
	param.smsVerfy = smsVerfy;
	if(isSend)return;
	isSend = true;
    $.post(WST.U('wechat/users/'+((type==0)?"sendCodeTie":"sendCodeEdit")), param, function(data){
        var json = WST.toJson(data);
        if( json.status == 1 ){
        	WST.msg(json.msg,'success');
			time = 120;
			$('#obtain').attr('disabled', 'disabled').html('120秒获取');
			var task = setInterval(function(){
				time--;
				$('#obtain').html(''+time+"秒获取");
				if(time==0){
					isSend = false;
					clearInterval(task);
					$('#obtain').removeAttr('disabled').html("重新发送");
				}
			},1000);
        }else{
        	WST.msg(json.msg,'warn');
        	WST.getVerify("#verifyImg");
        	isSend = false;
        }
        data = json = null;
    });
}
//修改手机号码
function editPhone(type){
	if(type==0){
		var userPhone = $('#userPhone').val();
	    if(userPhone==''){
	    	WST.msg('手机号码不能为空','info');
		    $('#userPhone').focus();
	        return false;
	    }
	}
	var phoneCode = $('#phoneCode').val();
    if(phoneCode==''){
    	WST.msg('请输入短信验证码','info');
    	$('#phoneCode').focus();
        return false;
    }
    var param = {};
    param.phoneCode = phoneCode;
	$('#modifyPhone').addClass("active").attr('disabled', 'disabled');
    $.post(WST.U('wechat/users/'+((type==0)?"phoneEdit":"phoneEdito")), param, function(data){
        var json = WST.toJson(data);
        if( json.status == 1 ){
        	WST.msg(json.msg,'success');
        	if(type==0){
                setTimeout(function(){
                	location.href = WST.U('wechat/users/security');
                },2000);
        	}else{
                setTimeout(function(){
                	location.href = WST.U('wechat/users/editPhoneo');
                },2000);
        	}

        }else{
        	WST.msg(json.msg,'warn');
        	$('#modifyPhone').removeAttr('disabled').removeClass("active");
        }
        data = json = null;
    });
}