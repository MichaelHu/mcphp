<?php

class Router{
	private static $req;
	private static $res;

	public static function dispatch(){
		self::$req = new Request();
		self::$res = new Response();

		self::_dispatch();
	}

	private static function _dispatch(){
		$pat = RouterConfig::$patterns;
		$logicStr = self::$req->getLogicString();

		MCLogger::debug('LOGIC_PARAMS: ' . var_export(self::$req->getParams(), true));
		MCLogger::debug('LOGIC_STRING: ' . $logicStr);

		$handlerName = '';

		foreach($pat as $k => $v){
			$count = preg_match($k, $logicStr);
			
			if(false === $count){
				continue;
			}

			if(0 === $count){
			    // echo "<h1>" . $k . "</h1>";
				continue;
			}

			if(0 < $count){
				$handlerName = $v['handler'];
				$handler = new $handlerName(self::$req, self::$res);
				$handler->process();
				break;
			}
		}

		MCLogger::notice('[LOGIC_STRING:#{logic_string}] [HANDLER:#{handler}] [COOKIE:#{cookie}]', array(
			'logic_string' => $logicStr,
			'handler' => $handlerName,
			'cookie' => self::$req->getCookieString(),
		));
	}

}
