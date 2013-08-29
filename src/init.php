<?php

if(!defined('MC_ENGINE_ROOT')){
    define('MC_ENGINE_ROOT', dirname(__FILE__));
}

define('MC_CORELIBS_ROOT', MC_ENGINE_ROOT . '/libs/');
define('MC_CORECONF_ROOT', MC_ENGINE_ROOT . '/conf/');
define('MC_COREUTILS_ROOT', MC_ENGINE_ROOT . '/utils/');

// define('MC_HANDLERS_ROOT', MC_ENGINE_ROOT . '/handlers');
// define('MC_MODULE_ROOT', MC_ENGINE_ROOT . '/module');

if(!defined('MC_SMARTY_DIR')){
    define('MC_SMARTY_DIR', MC_ENGINE_ROOT . '/third/Smarty-3.0.7/libs/');
}

// define('MC_TEMPLATE_DIR', MC_ENGINE_ROOT . '/tpl/doc258i');
// if(!defined('MC_DEFAULT_TN')){
//     define('MC_DEFAULT_TN', 'index');
// }

if(!defined('MC_TMP_ROOT')){
    define('MC_TMP_ROOT', '/tmp');
    if(!file_exists(MC_TMP_ROOT . '/cache')){
        mkdir(MC_TMP_ROOT . '/cache');
    }

    if(!file_exists(MC_TMP_ROOT . '/templates_c')){
        mkdir(MC_TMP_ROOT . '/templates_c');
    }
}

define('MC_INNER_PARAM_PREFIX', '_@_');

// load interface definition files
require_once(MC_CORELIBS_ROOT . '/interfaces/Handler.interface.php');

// auto search paths
$AUTOLOADDIRS = array_merge(
    array(
        MC_CORELIBS_ROOT,
        MC_CORECONF_ROOT,
        MC_COREUTILS_ROOT,
    ),
    $GLOBALS['MC_AUTOLOAD_DIRS']
);

function my_auto_load($className){
	global $AUTOLOADDIRS;
    // @note: classname must be unique
	foreach($AUTOLOADDIRS as $dir){
		$file = $dir . '/' . $className . '.class.php';
		if(file_exists($file)){
			require_once($file);	
			break;
		}
	}
}

spl_autoload_register('my_auto_load');

// involve configure files
if(defined('MC_CONF_ROOT')){
    foreach(new DirectoryIterator(MC_CONF_ROOT) as $entry){
        if($entry->isFile()){
            require_once($entry->getPathname());
        }
    } 
}

// log config
if(!isset($GLOBALS['MC_LOG'])){
    $GLOBALS['MC_LOG'] = array(
        // log level，0x07 = LOG_LEVEL_FATAL|LOG_LEVEL_WARNING|LOG_LEVEL_NOTICE
        // 'intLevel' => 0x1F, // DEBUG
        'intLevel' => 0x07,
        // log file name, wf: niportal.log.wf
        'strLogFile' => MC_ENGINE_ROOT . '/log/mcphp.log',
        // self log files
        'arrSelfLogFiles' => array(),
        // 0: no limit
        'intMaxFileSize' => 0,
        /**
         * log split config
         *   kind: day/hour/min
         *   interval: number
         */
        'arrSplitFile' => array(
            'kind' => 'day',
            'interval' => '1',
        ),
        // log string format: #{KEY}
        'strLogFormat' => '',
    );
}

