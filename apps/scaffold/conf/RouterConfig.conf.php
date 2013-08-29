<?php

RouterConfig::$patterns = array(
	'/tn=index/i' => array(
		'handler' => 'Scaffold_IndexHandler',
	), 

	'/.*/' => array(
		'handler' => 'Scaffold_IndexHandler',
	), 
);
