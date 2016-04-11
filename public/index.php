<?php
    // ABSOLUTE PATH VARS
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(dirname(__FILE__)));
    
    // URL GETTER
    $url = isset($_GET['url'])?$_GET['url']:false;
    
    // BOOTSTRAP LOADER
    require_once(ROOT . DS . 'library' . DS . 'kernel' . DS . 'bootstrap' . DS . 'bootstrap.php');