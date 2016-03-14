<?php
// @todo not used now
$originalConfigPath = PROJECT_DIR . '/vendor/view-components/view-components/resources/config.php';
$config = require $originalConfigPath;
$config['js_aliases'] = array_merge($config['js_aliases'], [
    'jquery' =>'/assets/jquery/jquery.min.js',
    'bootstrap' => '/assets/bootstrap/dist/js/bootstrap.min.js',
    'google_material' => '/assets/material-design-lite/material.min.js',
]);
$config['css_aliases'] = array_merge($config['js_aliases'], [
    'jquery' =>'/assets/jquery/jquery.min.js',
    'bootstrap' => '/assets/bootstrap/dist/css/bootstrap.min.css',
    'google_material' => '/assets/material-design-lite/material.min.css',
]);
return $config;