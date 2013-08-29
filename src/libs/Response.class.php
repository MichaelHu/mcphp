<?php

class Response{
	private $headers;
	private $content;

	public function __construct(){
		$this->headers = array();
		$this->content = '';
	}

	public function setHeader($key, $value){
		$this->headers[$key] = $value;
	}

	public function getHeader($key){
		return $this->headers[$key];
	}

	public function getContent(){
		return $this->content;
	}

	public function setContent($content){
		$this->content = $content;
	}

	public function appendContent($content){
		$this->content .= $content;
	}

	public function flush(){
		$this->flushHeader();
		// $this->appendContent(TemplateProvider::fetch($this));
		$this->flushContent();
	}

	protected function flushHeader(){
		foreach($this->headers as $k => $v){
			$hdLine = $k . ':' . $v;
			header($hdLine);
		}
	}

	protected function flushContent(){
		echo $this->content;
	}
}
