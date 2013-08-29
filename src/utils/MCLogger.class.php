<?php

class MCLogger{

	private static function _getPrepareInfo($format, $json){
		$ret = array(
			'log_str' => '',
			'errno' => 0,
		);
		$ret['log_str'] = StringFormat::format($format, $json); 
		$ret['errno'] = (
			isset($json) && isset($json['errno']) 
			? $json['errno'] : 0
		);
		return $ret;
	}

	public static function debug($format, $json = null){
		$logInfo = self::_getPrepareInfo($format, $json);
		CLogger::debug($logInfo['log_str'], $logInfo['errno']);
	}

	public static function trace($format, $json = null){
		$logInfo = self::_getPrepareInfo($format, $json);
		CLogger::trace($logInfo['log_str'], $logInfo['errno']);
	}

	public static function notice($format, $json = null){
		$logInfo = self::_getPrepareInfo($format, $json);
		CLogger::notice($logInfo['log_str'], $logInfo['errno']);
	}

	public static function warning($format, $json = null){
		$logInfo = self::_getPrepareInfo($format, $json);
		CLogger::warning($logInfo['log_str'], $logInfo['errno']);
	}

	public static function fatal($format, $json = null){
		$logInfo = self::_getPrepareInfo($format, $json);
		CLogger::fatal($logInfo['log_str'], $logInfo['errno']);
	}
}
