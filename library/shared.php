<?php
    /**
     * DEVELOPMENT ENVIRONMENT AND ERROR REPORTING
     */
    function setReporting(){
        if(DEVELOPMENT_ENVIRONMENT == true){
            //error_reporting(E_ALL);
            ini_set('error_reporting', E_ALL);
            ini_set('display_errors','On');
        }else{
            //error_reporting(0);
            ini_set('error_reporting', 0);
            ini_set('display_errors','Off');
        }
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
    }
    
    /** 
     * REMOVE SLASHES
     * @param $value BEFORE STRIP SLASHES
     * @return $value AFTER STRIP SLASHES
     */
    function stripSlashesDeep($value){
        $value = is_array($value)?array_map('stripSlashesDeep', $value): stripslashes($value);
        return $value;
    }
    
    /**
     * CHECK MAGIC QUOTES AND THEN REMOVE THEM
     */
    function removeMagicQuotes(){
        if(get_magic_quotes_gpc()){
            $_GET = stripSlashesDeep($_GET);
            $_POST = stripSlashesDeep($_POST);
            $_COOKIE = stripSlashesDeep($_COOKIE);
        }
    }
    
    /**
     * UNSET REGISTER GLOBALS CHECKING PHP.INI
     * FROM DOCUMENTATION:
     * Please note that register_globals cannot be set at runtime (ini_set()).
     */
    function unsetRegisterGlobals(){
        if(ini_get('register_globals')){
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach($array as $value){
                foreach($GLOBALS[$value] as $key => $var){
                    if($var === $GLOBALS[$key]){
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }
    
    /**
     * BUILD THE CALL USING URL PARAMETERS
     * @param $url PATH TAKEN BY GET
     */
    function callBuilder($url){
        if($url){
            $urlArray = array();
            $urlArray = explode("/",$url);

            $controller = $urlArray[0];
            array_shift($urlArray);
            $action = $urlArray[0];
            array_shift($urlArray);
            $queryString = $urlArray;

            $controllerName = $controller;
            $controller = ucwords($controller);
            $model = rtrim($controller, 's');
            $controller .= 'Controller';
            $dispatch = new $controller($model,$controllerName,$action);

            if((int)method_exists($controller, $action)){
                call_user_func_array(array($dispatch,$action),$queryString);
            }else{
                echo "non esiste la funzione controller: {$controller} con action: {$action}";
            }
        }
    }

    /**
     * AUTOLOAD CLASS FUNCTIONS
     * spl_autoload_register (PHP 5 >= 5.1.2)
     * @param $className NAME OF THE CLASS TO REQUIRE
     */
    function autoloadLibrary($className){
        $pathLibrary = PATH_LIBRARY . $className . '.class.php';
        if(file_exists($pathLibrary)){
            require_once($pathLibrary);
        }
    }
    function autoloadController($className){
        $pathController = PATH_CONTROLLERS . $className . '.php';
        if(file_exists($pathController)){
            require_once($pathController);
        }
    }
    function autoloadModel($className){
        $pathModel = PATH_MODELS . $className . '.php';
        if(file_exists($pathModel)){
            require_once($pathModel);
        }
    }
    
    spl_autoload_register('autoloadLibrary');
    spl_autoload_register('autoloadController');
    spl_autoload_register('autoloadModel');
    
    // FUNCTION CALLS
    setReporting();
    removeMagicQuotes();
    unsetRegisterGlobals();
    callBuilder($url);