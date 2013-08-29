<?php

SmartyConfig::$configs = array(
	'template_dir' => MC_TEMPLATE_DIR,
	'compile_dir' => MC_TMP_ROOT . '/templates_c', 
	'cache_dir' => MC_TMP_ROOT . '/cache', 
	'config_dir' => MC_CONF_ROOT . '/smarty_config', 
	'left_delim' => '{%', 
	'right_delim' => '%}', 
);
