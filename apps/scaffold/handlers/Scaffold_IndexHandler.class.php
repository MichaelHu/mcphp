<?php

class Scaffold_IndexHandler extends Scaffold_PageHandler{

	public function __construct(&$request, &$response){
		parent::__construct($request, $response);
	}

	protected function prepareData(){

		parent::prepareData();

        $this->setPageData('config', $this->iniConfig);
        $this->setPageData('common_config', $this->commonIniConfig);

        $this->setPageData('say', 'Hello, MCPHP!');

	}

}
