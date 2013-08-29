<?php
/***************************************************************************
 * 
 * Copyright (c) 2009 Baidu.com, Inc. All Rights Reserved
 * $Id: CLogger.class.php,v 1.4 2010/01/06 04:05:17 duchuanying Exp $ 
 * 
 **************************************************************************/

/**
 * @file CLogger.class.php
 * @author zhujt(zhujianting@baidu.com)
 * @date 2009/08/04 10:31:44
 * @version $Revision: 1.4 $ 
 * @brief class for logging
 *  
 **/


class CLogger
{
	const LOG_LEVEL_NONE    = 0x00;
	const LOG_LEVEL_FATAL   = 0x01;
	const LOG_LEVEL_WARNING = 0x02;
	const LOG_LEVEL_NOTICE  = 0x04;
	const LOG_LEVEL_TRACE   = 0x08;
	const LOG_LEVEL_DEBUG   = 0x10;
	const LOG_LEVEL_ALL     = 0xFF;

	public static $arrLogLevels = array(
		self::LOG_LEVEL_NONE    => 'NONE',
		self::LOG_LEVEL_FATAL   => 'FATAL',
		self::LOG_LEVEL_WARNING => 'WARNING',
		self::LOG_LEVEL_NOTICE  => 'NOTICE',
		self::LOG_LEVEL_TRACE	=> 'TRACE',
		self::LOG_LEVEL_DEBUG   => 'DEBUG',
		self::LOG_LEVEL_ALL     => 'ALL',
	);

	protected $intLevel;
	protected $strLogFile;
	protected $arrSelfLogFiles;
	protected $intLogId;
	protected $intMaxFileSize;
	protected $arrSplitFile;

	private static $instance = null;

	private function __construct($arrLogConfig)
	{
		$this->intLevel         = intval($arrLogConfig['intLevel']);
		$this->strLogFile		= $arrLogConfig['strLogFile'];
		$this->arrSelfLogFiles  = $arrLogConfig['arrSelfLogFiles'];
		// use framework logid as default
		$this->intLogId			= 0;
		$this->intMaxFileSize  = $arrLogConfig['intMaxFileSize'];
		$this->arrSplitFile  = $arrLogConfig['arrSplitFile'];
	}

	public static function getInstance()
	{
		if( self::$instance === null )
		{
			self::$instance = new CLogger($GLOBALS['MC_LOG']);
		}

		return self::$instance;
	}

	public function writeLog($intLevel, $str, $errno = 0, $arrArgs = null, $depth = 0)
	{
		if( !($this->intLevel & $intLevel) || !isset(self::$arrLogLevels[$intLevel]) )
		{
			return;
		}

		$strLevel = self::$arrLogLevels[$intLevel];

		$strLogFile = $this->strLogFile;
		if( ($intLevel & self::LOG_LEVEL_WARNING) || ($intLevel & self::LOG_LEVEL_FATAL) )
		{
			$strLogFile .= '.wf';
		}
		$strLogFile .= $this->getTimeSuffix();
		
		$trace = debug_backtrace();
		if( $depth >= count($trace) )
		{
			$depth = count($trace) - 1;
		}
		$file = basename($trace[$depth]['file']);
		$line = $trace[$depth]['line'];

		$strArgs = '';
		if( is_array($arrArgs) && count($arrArgs) > 0 )
		{
			foreach( $arrArgs as $key => $value )
			{
				$strArgs .= "{$key}[$value] ";
			}
		}

		$str = sprintf( "%s: %s [%s:%d] errno[%d] ip[%s] logId[%u] uri[%s] %s%s\n",
			$strLevel,
			date('m-d H:i:s:', time()),
			$file, $line, $errno,
			self::getClientIP(),
			$this->intLogId,
			isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
			$strArgs, $str);

		if($this->intMaxFileSize > 0)
		{
			clearstatcache();
			$arrFileStats = stat($strLogFile);
			if( is_array($arrFileStats) && floatval($arrFileStats['size']) > $this->intMaxFileSize )
			{
				unlink($strLogFile);
			}
		}

		return file_put_contents($strLogFile, $str, FILE_APPEND);
	}

	public function writeSelfLog($strKey, $str, $arrArgs = null)
	{
		if( isset($this->arrSelfLogFiles[$strKey]) )
		{
			$strLogFile = $this->arrSelfLogFiles[$strKey];
		}
		else
		{
			return;
		}
		$strLogFile .= $this->getTimeSuffix();
		
		$strArgs = '';
		if( is_array($arrArgs) && count($arrArgs) > 0 )
		{
			foreach( $arrArgs as $key => $value )
			{
				$strArgs .= "{$key}[$value] ";
			}
		}

		$str = sprintf( "%s: %s ip[%s] logId[%u] uri[%s] %s%s\n",
			$strKey,
			date('m-d H:i:s:', time()),
			self::getClientIP(),
			$this->intLogId,
			isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
			$strArgs, $str);

		if($this->intMaxFileSize > 0)
		{
			clearstatcache();
			$arrFileStats = stat($strLogFile);
			if( is_array($arrFileStats) && floatval($arrFileStats['size']) > $this->intMaxFileSize )
			{
				unlink($strLogFile);
			}
		}
		return file_put_contents($strLogFile, $str, FILE_APPEND);
	}

	public static function selflog($strKey, $str, $arrArgs = null)
	{
		$log = CLogger::getInstance();
		return $log->writeSelfLog($strKey, $str, $arrArgs);
	}

	public static function debug($str, $errno = 0, $arrArgs = null, $depth = 0)
	{
		$log = CLogger::getInstance();
		return $log->writeLog(self::LOG_LEVEL_DEBUG, $str, $errno, $arrArgs, $depth + 1);
	}

	public static function trace($str, $errno = 0, $arrArgs = null, $depth = 0)
	{
		$log = CLogger::getInstance();
		return $log->writeLog(self::LOG_LEVEL_TRACE, $str, $errno, $arrArgs, $depth + 1);
	}

	public static function notice($str, $errno = 0, $arrArgs = null, $depth = 0)
	{
		$log = CLogger::getInstance();
		return $log->writeLog(self::LOG_LEVEL_NOTICE, $str, $errno, $arrArgs, $depth + 1);
	}

	public static function warning($str, $errno = 0, $arrArgs = null, $depth = 0)
	{
		$log = CLogger::getInstance();
		return $log->writeLog(self::LOG_LEVEL_WARNING, $str, $errno, $arrArgs, $depth + 1);
	}

	public static function fatal($str, $errno = 0, $arrArgs = null, $depth = 0)
	{
		$log = CLogger::getInstance();
		return $log->writeLog(self::LOG_LEVEL_FATAL, $str, $errno, $arrArgs, $depth + 1);
	}

	public static function setLogId($intLogId)
	{
		CLogger::getInstance()->intLogId = $intLogId;
	}

	public static function getClientIP()
	{
		if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) )
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		elseif( isset($_SERVER['HTTP_CLIENTIP']) )
		{
			$ip = $_SERVER['HTTP_CLIENTIP'];
		}
		elseif( isset($_SERVER['REMOTE_ADDR']) )
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		elseif( getenv('HTTP_X_FORWARDED_FOR') )
		{
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif( getenv('HTTP_CLIENTIP') )
		{
			$ip = getenv('HTTP_CLIENTIP');
		}
		elseif( getenv('REMOTE_ADDR') )
		{
			$ip = getenv('REMOTE_ADDR');
		}
		else
		{
			$ip = '127.0.0.1';
		}

		$pos = strpos($ip, ',');
		if( $pos > 0 )
		{
			$ip = substr($ip, 0, $pos);
		}

		return trim($ip);
	}
	
	public function getTimeSuffix(){
		
		$arrKind = array(
			'day'=>array('sec'=>86400,'format'=>'Ymd'),
			'hour'=>array('sec'=>3600,'format'=>'YmdH'),
			'min'=>array('sec'=>60,'format'=>'YmdHi'),
		);
		
		if(empty($this->arrSplitFile) || !isset($this->arrSplitFile['interval']) || !isset($this->arrSplitFile['kind']) || empty($this->arrSplitFile['interval']) || empty($this->arrSplitFile['kind']) || !preg_match("/^\d+$/",$this->arrSplitFile['interval']) || !isset($arrKind[$this->arrSplitFile['kind']]))
		return '';
		
		$intvalSec = $arrKind[$this->arrSplitFile['kind']]['sec'] * $this->arrSplitFile['interval'];
		return '.' . date($arrKind[$this->arrSplitFile['kind']]['format'],floor(time()/$intvalSec)*$intvalSec);
		
	}
	
}

/* vim: set ts=4 sw=4 sts=4 tw=90 noet: */

