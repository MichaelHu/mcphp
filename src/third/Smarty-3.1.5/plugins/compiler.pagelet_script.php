<?php

/**
 * Created by JetBrains PhpStorm.
 * User: danghongyang
 * Date: 12-2-22
 * Time: 下午5:31
 * To change this template use File | Settings | File Templates.
 */
function smarty_compiler_pagelet_script($params,  $smarty){
    return '<?php $controller->scriptsStart()  ?>';
}
function smarty_compiler_pagelet_scriptclose($params,  $smarty){
    return '<?php $controller->scriptsEnd()  ?>';
}