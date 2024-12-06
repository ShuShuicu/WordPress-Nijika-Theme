<?php
if (!defined('ABSPATH')) exit;

$ConfigFiles = [
    'Get', 
    'Vue',
    'MyGO',
    'Options',
    'Functions',
];
foreach ($ConfigFiles as $file) {
    require_once dirname(__FILE__) . '/Config/' . $file . '.php';
}
