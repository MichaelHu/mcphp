<?php

class PageHandler implements Handler{
	protected $request;
	protected $response;
	protected $iniConfig;
	protected $commonIniConfig;

	protected $pageData;

	public function __construct(&$request, &$response){
		$this->request = $request;
		$this->response = $response;

		$this->iniConfig = array();

        if($this->request->isNoTemplate()){
            $configPath = dirname(TemplateProvider::getTN($request));
            $configFile = $configPath . '/config.ini';
            if(file_exists($configFile)){
                $this->iniConfig = parse_ini_file($configFile, true);
            }
        }

		$this->commonIniConfig = array();
		$commonConfigFile
            = SmartyConfig::$configs['config_dir'] . '/config.ini';
		if(file_exists($commonConfigFile)){
			$this->commonIniConfig = parse_ini_file($commonConfigFile, true);
		}

		$this->pageData = array();

		MCLogger::debug('INI Config: ' . var_export($this->iniConfig, true));
		MCLogger::debug('Common INI Config: ' . var_export($this->commonIniConfig, true));
	}

	public function process(){
        $this->prepareData();

        if(!$this->request->isNoTemplate()){
            $this->prepareCommonData();

            $this->flushPageData();
            $this->showPage();
        }

		$this->response->flush();
	}

	protected function flushPageData(){
		foreach($this->pageData as $k => $v){
			TemplateProvider::assign($k, $v);
		}
	}

	protected function setPageData($key, $value){
		$this->pageData[$key] = $value;
	}

	protected function prepareCommonData(){
		$params = $this->request->getParams();
		$this->setPageData('PARAMS', $params);

		$cookie = $this->request->getCookie();
		$this->setPageData('COOKIE', $cookie);

		$logicString = $this->request->getLogicString();
		$this->setPageData('LOGICSTRING', $logicString);
	}

	protected function prepareData(){
		//
	}

	protected function showPage(){
        $this->response->appendContent(
            TemplateProvider::fetch($this->request)
        );
	}
}

