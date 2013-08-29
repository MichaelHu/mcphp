<?php

class Request{
	private $cookie;
	private $cookieString;
	private $requestParams;
	private $requestData;

	// 影响程序执行路线的参数：逻辑参数
	private $logicParamsConfig;
	private $logicParams;

	public function __construct(){
		$this->init();
	}

	protected function init(){
		$this->cookie = $_COOKIE;

        // 取决于浏览器是否发出该头部
		$this->cookieString = isset($_SERVER['HTTP_COOKIE'])
            ? $_SERVER['HTTP_COOKIE']
            : '';

		$this->_getRequestParams();
		$this->_getRequestData();
		
		$this->_getLogicParamsConfig();
		$this->_getLogicParams();
	}

	public function getCookie(){
		return $this->cookie;
	}

	public function getCookieString(){
		return $this->cookieString;
	}

	public function getRequestParams(){
		return $this->requestParams;
	}

	public function getRequestParam($key){
		return $this->requestParams[$key];
	}

	public function getLogicParams(){
		return $this->logicParams;
	}

	public function getParams(){
		return $this->getLogicParams();
	}

	public function getLogicParam($key){
		return (isset($this->logicParams[$key]) ? 
			$this->logicParams[$key] : null
		);
	}

	public function getParam($key){
		return $this->getLogicParam($key);
	}

	public function setLogicParam($key, $value){
		if(!isset($this->logicParams[$key])){
			$this->logicParams[$key] = $value;
		}
		else{
			// illegal action
		}
	}

	public function setParam($key, $value){
		$this->setLogicParam($key, $value);
	}

	public function modifyLogicParam($key, $value){
		$this->logicParams[$key] = $value;
	}

	public function modifyParam($key, $value){
		$this->modifyLogicParam($key, $value);
	}

	public function getLogicString(){
		return self::array2Query($this->logicParams);
	}

	private function _getRequestParams(){
		$queryString = $_SERVER['QUERY_STRING'];
		$this->requestParams = self::query2Array($queryString);
	}

	private function _getRequestData(){
		$this->requestData = array();
	}

	private function _getLogicParamsConfig(){
		$this->logicParamsConfig = RequestConfig::$logicParams;
	}

	private function _getLogicParams(){
		$this->logicParams = array();
		$config = $this->logicParamsConfig;
		foreach($config as $k => $v){
			$this->logicParams[$k] 
				= $this->_getParamFromSpecifiedSource($k, $v['source']);
		}
		$this->_validate();
	}

	// 验证逻辑参数的正确性
	protected function _validate(){
		$params = $this->logicParams;
		foreach($params as $k => $v){
			if(!isset($v)){
				continue;
			}

			if(array_key_exists($k, $this->logicParamsConfig)){
				$pattern = $this->logicParamsConfig[$k]['pattern'];	
				if(!isset($pattern) || !is_string($pattern) || null === $pattern){
					continue;
				}
				$rslt = preg_match($pattern, $v);
				if(false === $rslt){
					// match error
				}

				if(0 === $rslt){
					// no match
					$this->logicParams[$k] = $this->logicParamsConfig[$k]['default'];
				}
			}
		}
	}

	private function _getParamFromSpecifiedSource($name, $source){
		$hashes = explode('|', $source);

		// 先从Request对象中获取
		$params = $this->$hashes[0];

		if(isset($params)){
			for($i=1; $i<count($hashes); $i++){
				if(isset($params[$hashes[$i]])){
					$params = $params[$hashes[$i]];
				}		
				else{
					$params = null;
					break;
				}
			}
			if(isset($params)){
				return $params;
			}
		}
	
		// 否则从配置文件中获取默认值
		$params = $this->logicParamsConfig;
		if(isset($params) && isset($params[$name])
			&& isset($params[$name]['default'])){
			return $params[$name]['default'];
		}

		return false;
	}

	private static function query2Array($query){
		$ret = array();
		if(!isset($query) || empty($query)){
			return $ret;
		}
		$queries = explode('&', $query);
		foreach($queries as $v){
			$fields = explode('=', $v);
			$ret[$fields[0]] = (
				2 == count($fields) ? $fields[1] : ''
			);
		}
		return $ret;
	}

	private static function array2Query($array){
		$ret = '';
		if(!isset($array) || empty($array)){
			return $ret;
		}

		$tmp = array();
		foreach($array as $k => $v){
			$tmp[] = $k . '=' . $v;
		}
		$ret = implode('&', $tmp);
		return $ret;
	}

}
