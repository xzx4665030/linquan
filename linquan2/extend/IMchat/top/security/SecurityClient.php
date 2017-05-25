<?php

	include './SecurityUtil.php';
	include './SecretGetRequest.php';
	include './TopSdkFeedbackUploadRequest.php';
	include './iCache.php';
	include '../../TopSdk.php';

	class SecurityClient
	{
		private $topClient ;
		private $randomNum ;
		private $securityUtil;
		private $cacheClient = null;

		function __construct($client, $random)
		{

			define('APP_SECRET_TYPE','2');
			define('APP_USER_SECRET_TYPE','3');

			$this->topClient = $client;
			$this->randomNum = $random;
			$this->securityUtil = new SecurityUtil();
		}

		/**
		* 设置缓存处理器
		*/
		function setCacheClient($cache)
		{
			$this->cacheClient = $cache;
		}

		/**
		* 单条数据解密,使用appkey级别公钥
		*/
		function decryptPublic($data,$type)
		{
			return $this->decrypt($data,$type,null);
		}
		/**
		* 单条数据解密
		*/
		function decrypt($data,$type,$session)
		{
			if(empty($data) || empty($type)){
				return null;
			}
			if($this->securityUtil->isPublicData($data,$type)){
				$secretContext = $this->callSecretApiWithCache(null,null);
			} else {
				$secretContext = $this->callSecretApiWithCache($session,null);
			}
			$this->incrCounter(2,$type,$secretContext,true);
			
			return $this->securityUtil->decrypt($data,$type,$secretContext);
		}

		/**
		* 多条数据解密，使用appkey级别公钥
		*/
		function decryptBatchPublic($array,$type)
		{
			if(empty($array) || empty($type)){
				return null;
			}
			$secretContext = $this->callSecretApiWithCache(null,null);
			$result = array();
			foreach ($array as $value) {
				$result[$value] = $this->securityUtil->decrypt($value,$type,$secretContext);
				$this->incrCounter(2,$type,$secretContext,true);
			}
			$this->flushCounter($secretContext);

			return $result;
		}

		/**
		* 多条数据解密，必须是同一个type和用户,返回结果是 KV结果
		*/
		function decryptBatch($array,$type,$session)
		{
			if(empty($array) || empty($type)){
				return null;
			}
			$secretContext = $this->callSecretApiWithCache($session,null);
			$appContext = $this->callSecretApiWithCache(null,null);

			$result = array();
			foreach ($array as $value) {
				if($this->securityUtil->isPublicData($value,$type)){
					$result[$value] = $this->securityUtil->decrypt($value,$type,$appContext);
					$this->incrCounter(2,$type,$appContext,false);
				} else {
					$result[$value] = $this->securityUtil->decrypt($value,$type,$secretContext);
					$this->incrCounter(2,$type,$secretContext,false);
				}
			}
			$this->flushCounter($appContext);
			$this->flushCounter($secretContext);

			return $result;
		}

		/**
		* 使用上一版本秘钥解密，app级别公钥
		*/
		function decryptPreviousPublic($data,$type)
		{
			$secretContext = $this->callSecretApiWithCache(null,-1);
			return $this->securityUtil->decrypt($data,$type,$secretContext);
		}
		/**
		* 使用上一版本秘钥解密，一般只用于更新秘钥
		*/
		function decryptPrevious($data,$type,$session)
		{
			if($this->securityUtil->isPublicData($data,$type)){
				$secretContext = $this->callSecretApiWithCache(null,-1);
			} else {
				$secretContext = $this->callSecretApiWithCache($session,-1);
			}
			return $this->securityUtil->decrypt($data,$type,$secretContext);
		}

		/**
		* 加密单条数据,使用app级别公钥
		*/
		function encryptPublic($data,$type)
		{
			return $this->encrypt($data,$type,null);
		}
		/**
		* 加密单条数据
		*/
		function encrypt($data,$type,$session)
		{
			if(empty($data) || empty($type)){
				return null;
			}
			$secretContext = $this->callSecretApiWithCache($session,null);
			$this->incrCounter(1,$type,$secretContext,true);

			return $this->securityUtil->encrypt($data,$type,$secretContext);
		}

		/**
		* 加密多条数据，使用app级别公钥
		*/
		function encryptBatchPublic($array,$type)
		{
			if(empty($array) || empty($type)){
				return null;
			}
			$secretContext = $this->callSecretApiWithCache(null,null);
			$result = array();
			foreach ($array as $value) {
				$result[$value] = $this->securityUtil->encrypt($value,$type,$secretContext);
				$this->incrCounter(1,$type,$secretContext,false);
			}
			$this->flushCounter($secretContext);

			return $result;
		}

		/**
		* 加密多条数据，必须是同一个type和用户,返回结果是 KV结果
		*/
		function encryptBatch($array,$type,$session)
		{
			if(empty($array) || empty($type)){
				return null;
			}
			$secretContext = $this->callSecretApiWithCache($session,null);
			$result = array();
			foreach ($array as $value) {
				$result[$value] = $this->securityUtil->encrypt($value,$type,$secretContext);
				$this->incrCounter(1,$type,$secretContext,false);
			}
			$this->flushCounter($secretContext);
			return $result;
		}

		/**
		* 使用上一版本秘钥加密，使用app级别公钥
		*/
		function encryptPreviousPublic($data,$type)
		{
			$secretContext = $this->callSecretApiWithCache(null,-1);
			$this->incrCounter(1,$type,$secretContext,true);

			return $this->securityUtil->encrypt($data,$type,$secretContext);
		}
		/**
		* 使用上一版本秘钥加密，一般只用于更新秘钥
		*/
		function encryptPrevious($data,$type,$session)
		{
			$secretContext = $this->callSecretApiWithCache($session,-1);
			$this->incrCounter(1,$type,$secretContext,true);

			return $this->securityUtil->encrypt($data,$type,$secretContext);
		}

		/**
		* 根据session生成秘钥
		*/
		function initSecret($session)
		{
			return $this->callSecretApiWithCache($session,null);
		}

		function buildCacheKey($session,$secretVersion)
		{
			if(empty($secretVersion)){
				if(empty($session)){
					return "_" ;
				}else{
					return $session ;
				}
			}
			return $session.'_'.$secretVersion ;
		}

		/**
		* 判断是否是已加密的数据
		*/
		function isEncryptData($data,$type)
		{
			if(empty($data) || empty($type)){
				return false;
			}
			return $this->securityUtil->isEncryptData($data,$type);
		}

		/**
		* 判断是否是已加密的数据，数据必须是同一个类型
		*/
		function isEncryptDataArray($array,$type)
		{
			if(empty($array) || empty($type)){
				return false;
			}
			return $this->securityUtil->isEncryptDataArray($array,$type);
		}

		/**
		* 判断数组中的数据是否存在密文，存在任何一个返回true,否则false
		*/
		function isPartEncryptData($array,$type)
		{
			if(empty($array) || empty($type)){
				return false;
			}
			return $this->securityUtil->isPartEncryptData($array,$type);
		}

		/**
		* 获取秘钥，使用缓存
		*/
		function callSecretApiWithCache($session,$secretVersion)
		{
			if($this->cacheClient)
			{
				$time = time();
				$cacheKey = $this->buildCacheKey($session,$secretVersion);
				$response = $this->cacheClient->getCache($cacheKey);

				if($response)
				{
					if($response->canUpload()){
						if($this->report($response)){
							//清除统计数据
							$response->clearReport();
						}
					}
				}

				if($response && $response->invalidTime > $time)
				{
					return $response;
				}
			}

			$response = $this->callSecretApi($session,$secretVersion);

			if($this->cacheClient)
			{
				$response->cacheKey = $cacheKey;
				$this->cacheClient->setCache($cacheKey,$response);
			}

			return $response;
		}

		function incrCounter($op,$type,$secretContext,$flush)
		{
			if($op == 1){
				switch ($type) {
					case 'nick':
					$secretContext->encryptNickNum ++ ;
						break;
					case 'simple':
						$secretContext->encryptSimpleNum ++ ;
						break;
					case 'receiver_name':
						$secretContext->encryptReceiverNameNum ++ ;
						break;
					case 'phone':
						$secretContext->encryptPhoneNum ++ ;
						break;
					default:
						break;
				}
			}else if($op == 2){
				switch ($type) {
					case 'nick':
					$secretContext->decryptNickNum ++ ;
						break;
					case 'simple':
						$secretContext->decryptSimpleNum ++ ;
						break;
					case 'receiver_name':
						$secretContext->decryptReceiverNameNum ++ ;
						break;
					case 'phone':
						$secretContext->decryptPhoneNum ++ ;
						break;
					default:
						break;
				}
			}else{
				switch ($type) {
					case 'nick':
					$secretContext->searchNickNum ++ ;
						break;
					case 'simple':
						$secretContext->searchSimpleNum ++ ;
						break;
					case 'receiver_name':
						$secretContext->searchReceiverNameNum ++ ;
						break;
					case 'phone':
						$secretContext->searchPhoneNum ++ ;
						break;
					default:
						break;
				}
			}

			if($flush && $this->cacheClient){
				$this->cacheClient->setCache($secretContext->cacheKey,$secretContext);
			}
		}

		function flushCounter($secretContext)
		{
			if($this->cacheClient){
				$this->cacheClient->setCache($secretContext->cacheKey,$secretContext);
			}			
		}

		/*
		* 上报信息
		*/
		function report($secretContext)
		{
			$request = new TopSdkFeedbackUploadRequest;
			$request->setContent($secretContext->toLogString());

			if(empty($secretContext->session)){
				$request->setType(APP_SECRET_TYPE);
			}else{
				$request->setType(APP_USER_SECRET_TYPE);				
			}

			$response = $this->topClient->execute($request,$secretContext->session);
			if($response->code == 0){
				return true;
			}
			return false;
		}

		/**
		* 获取秘钥，不使用缓存
		*/
		function callSecretApi($session,$secretVersion)
		{
			$request = new TopSecretGetRequest;
			$request->setRandomNum($this->randomNum);
			if($secretVersion)
			{
				$request->setSecretVersion($secretVersion);
			}
			
			if($session != null && $session[0] == '_')
			{
				$request->setCustomerUserId(substr(session,1));
			}

			$response = $this->topClient->execute($request,$session);
			if($response->code != 0){
				throw new Exception($response->msg);
			}

			$time = time();
			$secretContext = new SecretContext();
			$secretContext->maxInvalidTime = $time + intval($response->max_interval);
			$secretContext->invalidTime = $time + intval($response->interval);
			$secretContext->secret = strval($response->secret);
			$secretContext->session = $session;
			if(empty($session)){
				$secretContext->secretVersion = -1 * intval($response->secret_version);
			}else{
				$secretContext->secretVersion = intval($response->secret_version);
			}
 			
			return $secretContext;
		}
	}    
?>