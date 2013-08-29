<?php
/**
 * Created by JetBrains PhpStorm.
 * User: danghongyang
 * Date: 12-2-22
 * Time: 下午3:43
 * To change this template use File | Settings | File Templates.
 */

function smarty_compiler_pagelet_title($params,  $smarty){
    $title = $params["title"];
    return '<?php $controller->titleStart('.$title.'); ?>';
}
function smarty_compiler_pagelet_titleclose($params,  $smarty){
    return '';
}