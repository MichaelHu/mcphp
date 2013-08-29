<?php
/**
 * Created by JetBrains PhpStorm.
 * User: danghongyang
 * Date: 12-2-22
 * Time: 下午3:43
 * To change this template use File | Settings | File Templates.
 */

function smarty_compiler_pagelet_page($params,  $smarty){
    return '<?php'.
           ' require_once \'' . dirname(__FILE__) . DIRECTORY_SEPARATOR . 'pagelet' . DIRECTORY_SEPARATOR . 'PageletController.class.php\';'.
           ' $controller = new PageletController();'.
           ' ?>';
}
function smarty_compiler_pagelet_pageclose($params,  $smarty){
    return '<?php $controller->outputPagelets(); ?>';
}