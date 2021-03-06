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
        $this->bNoTemplate = false;

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

    public function isNoTemplate(){
        return $this->bNoTemplate;
    }

    public function enableNoTemplate(){
        $this->bNoTemplate = true;
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
        /*
		$queryString = $_SERVER['QUERY_STRING'];
		$this->requestParams = self::query2Array($queryString);
        */
		$this->requestParams = $_GET;
	}

	private function _getRequestData(){
		$this->requestData = array();
	}

	private function _getLogicParamsConfig(){
		$this->logicParamsConfig = RequestConfig::$logicParams;
	}

	private function _getLogicParams(){
		$config = $this->logicParamsConfig;
		foreach($config as $k => $v){
            // tn-level logicparams
            if(preg_match('/tn:(.+)/', $k, $matches)){
                if($this->logicParams['tn'] == $matches[1]){
                    foreach($v as $k1 => $v1){
                        $this->logicParams[$k1] 
                            = $this->_getParamFromSpecifiedSource($k1, $v1);
                    }
                }
            }
            // common logicparams
            else{
                $this->logicParams[$k] 
                    = $this->_getParamFromSpecifiedSource($k, $v);
            }
		}
	}

	private function _getParamFromSpecifiedSource($name, $config){

        if(isset($config) && isset($config['source'])){
            $source = $config['source'];
        }
        else{
            return false;
        }

        // 默认值
        $default = false;
        if(isset($config['default'])){
            $default = $config['default'];
        }


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

            // 取到值
			if(isset($params)){
                // 有匹配模式则进行验证
                if(isset($config['pattern'])){
                    $pattern = $config['pattern'];
                    if(is_string($pattern)){
                        $rslt = preg_match($pattern, $params);
                        // 验证通过
                        if($rslt){
                            return $params;
                        }

                        // 验证未通过
                        if(false === $rslt){
                            // match error
                        }

                        if(0 === $rslt){
                            // no match
                        }

                    }

                }
                // 无匹配模式，直接返回获取到的值
                else{
                    return $params;
                }
			}
            // 未取到值
            else{
                // @todo:
            }

		}
        else{
            // @todo: 
        }
	
		return $default;
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
