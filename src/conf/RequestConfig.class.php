<?php

class RequestConfig{
	public static $logicParams = array();
}

/*
 * 逻辑选择参数配置
 * key: 两种格式，一种为参数名，另一种为tn:模板名，前一种为公共逻辑参数，后一种为模板特定参数
 * default: 默认值，当前上下文获取不到的时候，使用默认值
 * source: 参数来源，例子如下：
 *         requestParams|tn 表示来自请求参数, request->requestParams['tn']
 *         cookie|baiduid 表示来自Cookie, request->cookie['baiduid']
 *         requestData|fname 表示来自请求数据, request->requestData['fname']
 * pattern: 正则表达式，用于参数有效性检查
 * @note: tn参数为必选配置项，且必须作为第一个字段进行配置
 */

/*
RequestConfig::$logicParams = array(

    // tn为必选配置项，且必须为第一个字段
	'tn' => array(
		'default'=>'index', 
		'source'=>'requestParams|tn',
		// 'pattern'=>'/^[a-zA-Z_]\w*$/',
		'pattern'=>'/^(?:index|markdown)$/',
	),

    // 其他公共参数
	'class' => array(
		'default'=>'', 
		'source'=>'requestParams|class',
		'pattern'=>'/^[\w\-]+$/',
	),

    // tn=markdown，模板特定参数
    'tn:markdown' => array(
        'act' => array(
            'default'=>'get_article', 
            'source'=>'requestParams|act',
            'pattern'=>'/^(?:list_articles|get_article)$/',
        ),  

        'title' => array(
            'default'=>'', 
            'source'=>'requestParams|title',
            'pattern'=>'/^.+$/',
        ),  

        'tag' => array(
            'default'=>'', 
            'source'=>'requestParams|tag',
            'pattern'=>'/^.+$/',
        ),  
    ),  

);
*/

