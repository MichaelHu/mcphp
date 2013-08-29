<?php

class Manifest {

    protected  $manifest_path;

    public function __construct($path) {
        $this->manifest_path = $path;
    }

    public function addManifestAttr($tpl_output, Smarty_Internal_Template $template) {
        //替换<html>标签，添加manifest属性
        $pattern = '/<html([^>]*)>/';
        return preg_replace_callback(
            $pattern,
            create_function('$matches',
                'return "<html" . $matches[1] . \' manifest="' . $this->manifest_path. '">\';'
            ),
            $tpl_output
        );
    }
}

    function smarty_function_fis_manifest($params, Smarty_Internal_Template $template) {
        if(isset($params['path']) && (trim($params['path']) !== '')) {
            $manifest = new Manifest($params['path']);
            $template->smarty->registerFilter('output', array($manifest, 'addManifestAttr'));
        } else {
            trigger_error('This params have no path params!', E_USER_WARNING);
        }
    }

