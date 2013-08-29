<?php

/*
 * 逻辑选择参数配置
 * default: 默认值，当前上下文获取不到的时候，使用默认值
 * source: 参数来源，例子如下：
 *         requestParams|tn 表示来自请求参数, request->requestParams['tn']
 *         cookie|baiduid 表示来自Cookie, request->cookie['baiduid']
 *         requestData|fname 表示来自请求数据, request->requestData['fname']
 * pattern: 正则表达式，用于参数有效性检查
 */
RequestConfig::$logicParams = array(
	'tn' => array(
		'default'=>'index', 
		'source'=>'requestParams|tn',
		'pattern'=>'/^(?:index|othertemplate)$/',
	),
);


