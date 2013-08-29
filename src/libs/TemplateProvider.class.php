<?php

// Template Function Wrapper
class TemplateProvider{
	protected static $smarty = null;

	public static function getSmarty(){
		if(is_null(self::$smarty)){
			require_once( MC_SMARTY_DIR . '/Smarty.class.php' );
			self::$smarty = new Smarty();
			self::config(self::$smarty, SmartyConfig::$configs);
		}
		return self::$smarty;
	}

	protected static function getNewSmarty(){
        require_once( MC_SMARTY_DIR . '/Smarty.class.php' );
        return new Smarty();
	}

    protected static function config(&$smarty, $config){
		$smarty->setTemplateDir($config['template_dir']);
        $smarty->setCompileDir($config['compile_dir']);
        $smarty->setCacheDir($config['cache_dir']);
        $smarty->setConfigDir($config['config_dir']);
        $smarty->left_delimiter = $config['left_delim'];
        $smarty->right_delimiter = $config['right_delim'];
    }

    public static function getConfigDir(){
		$smarty = self::getSmarty();
        return $smarty->getConfigDir();
    }

	public static function assign($key, $value){
		$smarty = self::getSmarty();
		$smarty->assign($key, $value);
	}

	public static function assignJson($json){
		foreach($json as $k => $v){
			self::assign($k, $v);
		}
	}

	public static function fetch(&$request){
		return self::getSmarty()->fetch(self::getTN($request));
	}

	public static function render($template, $config, $json){
        $smarty = self::getNewSmarty();

        self::config($smarty, $config);
        if(!is_null($json)){
            foreach($json as $k => $v){
                $smarty->assign($k, $v);
            }
        }
		$content = $smarty->fetch($template);
        unset($smarty);

        return $content;
	}

	public static function getTN(&$request){
		$tn = $request->getParam('tn');
		if(!isset($tn) || empty($tn)){
			$tn = MC_DEFAULT_TN;
		}

		$ret = MC_TEMPLATE_DIR . '/' . $tn . '/page.tpl';
		if(!file_exists($ret)){
			$request->setParam(MC_INNER_PARAM_PREFIX . 'tpl_not_exists', 1);	
			$tn = MC_DEFAULT_TN;
			$ret = MC_TEMPLATE_DIR . '/' . $tn . '/page.tpl';
		}
		MCLogger::debug('TN: ' . $ret);
		return $ret;
	}

}

