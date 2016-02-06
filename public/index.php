<?php
    // ABSOLUTE PATH VARS
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(dirname(__FILE__)));
    
    
    //$url = $_GET['url'];
    $url = isset($_GET['url'])?$_GET['url']:false;
    
    if($url){
        echo "url: " . $url . "<br />";
    }

    // BOOTSTRAP LOADER
    require_once(ROOT . DS . 'library' . DS . 'bootstrap.php');
    
/*
    $str = 'class asd{public $dsa;function __construct($dsa){$this->dsa=$dsa;}}';
    eval($str);
    $aa = new asd("ciao");
    echo $aa->dsa;
*/