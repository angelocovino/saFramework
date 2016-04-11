<?php
    // PHP VERSION EXTENSIONS
    defined('PHP_VERSION') or define('PHP_VERSION', phpversion());
    /**
     * [[Description]]
     * @param  [[Type]] $version [[Description]]
     * @return boolean  [[Description]]
     */
    function phpIsVersion($version){
        if(version_compare(PHP_VERSION, $version) >= 0){
            return true;
        }
        return false;
    }
    
    public function invokeWithParam($func, $params){
        if(method_exists($this, $func)){
            if(!is_array($params)){$params = array($params);}
            return (call_user_func_array(array($this, $func), $params));
        }
        return (false);
    }
    
    /*
        $str = 'class asd{public $dsa;function __construct($dsa){$this->dsa=$dsa;}}';
        eval($str);
        $aa = new asd("ciao");
        echo $aa->dsa;
    */
    
    /*
    if(phpIsVersion('5.1.2')){
        spl_autoload_register(function($className){
            $pathLibrary = PATH_LIBRARY . $className . '.class.php';
            $pathController = PATH_CONTROLLERS . $className . '.php';
            $pathModel = PATH_MODELS . $className . '.php';
            if(file_exists($pathLibrary)){
                require_once($pathLibrary);
            }else if(file_exists($pathController)){
                require_once($pathController);
            }else if(file_exists($pathModel)){
                require_once($pathModel);
            }
        });
    }else{
        function __autoload($className){
            $pathLibrary = PATH_LIBRARY . $className . '.class.php';
            $pathController = PATH_CONTROLLERS . $className . '.php';
            $pathModel = PATH_MODELS . $className . '.php';
            if(file_exists($pathLibrary)){
                require_once($pathLibrary);
            }else if(file_exists($pathController)){
                require_once($pathController);
            }else if(file_exists($pathModel)){
                require_once($pathModel);
            }
        }
    }
    */