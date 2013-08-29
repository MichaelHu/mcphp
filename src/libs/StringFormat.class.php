<?php

class StringFormat{
	public static $ldelim = '{';
	public static $rdelim = '}';
	public static $_json = null;

	public static function format($format_str, $json){
		//echo $format_str . "\n";
		$format_str = preg_replace(
			'/#' . self::$ldelim . '(\w+)' . self::$rdelim . '/', 
			'#@_@$1@_@', $format_str);

		self::$_json = $json;

		$format_str = preg_replace_callback(
			'/#@_@(\w+)@_@/', 
			/**
			 * 'self::replacecallback', $format_str);
			 * 以上方式可能导致找不到replacecallback方法
			 */
			'StringFormat::replacecallback', $format_str);

		$format_str = preg_replace(
			'/#@_@(\w+)@_@/', 
			'#' . self::$ldelim . '$1' . self::$rdelim, $format_str);

		return $format_str;
	}

	// 默认内部交换编码为UTF8
	public static function format_encode($format_str, $json){
		foreach($json as $k => $v){
			$json[$k] = urlencode($v);
		}	
		return self::format($format_str, $json);
	}

	public static function format_gbk_encode($format_str, $json){
		foreach($json as $k => $v){
			$json[$k] = iconv('utf-8', 'gbk', $v);
			$json[$k] = urlencode($json[$k]);
			
		}	
		return self::format($format_str, $json);
	}

	public static function replacecallback($matches){
		$name = $matches[1];
		if(array_key_exists($name, self::$_json)){
			return (string)self::$_json[$name];
		}
		return $matches[0];
	}
}


