<?php
/**
 * Created by JetBrains PhpStorm.
 * User: danghongyang
 * Date: 12-2-22
 * Time: 下午3:43
 * To change this template use File | Settings | File Templates.
 */
function smarty_compiler_pagelet($params,  $smarty){
    $id = $params["id"];
    return '<?php $controller->addPagelet('.$id.');'.
           '$controller->pageletStart();'.
           '?><div id="'.
           '<?php echo $controller->getCurrentPagelet()->getId(); ?>">';
}
function smarty_compiler_pageletclose($params,  $smarty){
    return '<?php $controller->pageletEnd(); ?></div>';
}