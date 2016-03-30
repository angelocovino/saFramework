<?php
    /**
     * DEVELOPMENT ENVIRONMENT AND ERROR REPORTING
     */
    function setReporting(){
        if(DEVELOPMENT_ENVIRONMENT == true){
            //error_reporting(E_ALL);
            ini_set('error_reporting', E_ALL);
            ini_set('display_errors', 'On');
        }else{
            //error_reporting(0);
            ini_set('error_reporting', 0);
            ini_set('display_errors', 'Off');
        }
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
    }
    
    /**
     * PREVENT SESSIONS FROM HIJACKING
     */
    function preventHijacking(){
        ini_set('session.use_only_cookies', true);				
        ini_set('session.use_trans_sid', false);
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
            $array = array(
                '_SESSION',
                '_POST',
                '_GET',
                '_COOKIE',
                '_REQUEST',
                '_SERVER',
                '_ENV',
                '_FILES'
            );
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
        if($url !== false){
            $controllerName = $urlArray = $url;
            $actionCheck = 1;
            if(strpos($url, "/") !== false){
                $urlArray = explode("/", $url);
                $controllerName = array_shift($urlArray);
                $actionCheck = 0;
            }
            if(is_array($urlArray) && count($urlArray>1) && !empty($urlArray[$actionCheck])){
                $action = array_shift($urlArray);
                $queryString = $urlArray;
            }else{
                $action = "index";
                $queryString = array();
            }
            // MAKE UPPER CASE FIRST LETTER OF CONTROLLER NAME
            $controller = ucwords($controllerName);
            // TRIM THE LAST S FROM CONTROLLER NAME IN ORDER TO GET THE MODEL NAME
            $model = rtrim($controller, 's');
            // CONTROLLER NAME CONCATENATION
            $controller .= 'Controller';
            
            if(class_exists($controller)){
                $dispatch = new $controller($model, $controllerName, $action);
                if((int)method_exists($controller, $action)){
                    call_user_func_array(array($dispatch, $action), $queryString);
                    return (BUILDER_OK);
                }else{
                    // ACTION NOT FOUND IS $action IN CONTROLLER $controller
                    return (BUILDER_ACTION_ERROR);
                }
            }
            return (BUILDER_CONTROLLER_ERROR);
        }
        return (BUILDER_URL_ERROR);
    }
    
    /**
     * AUTOLOAD CLASS FUNCTIONS
     * spl_autoload_register (PHP 5 >= 5.1.2)
     * @param $className NAME OF THE CLASS TO REQUIRE
     */
    function requireFileIfExists($path){
        if(file_exists($path)){
            require_once($path);
        }
    }
    function autoloadLibrary($className){
        $pathLibrary = PATH_LIBRARY . $className . '.class.php';
        requireFileIfExists($pathLibrary);
    }
    function autoloadController($className){
        $pathController = PATH_CONTROLLERS . $className . '.php';
        requireFileIfExists($pathController);
    }
    function autoloadModel($className){
        $pathModel = PATH_MODELS . $className . '.php';
        requireFileIfExists($pathModel);
    }
    function autoloadNamespace($className){
        $pathRoot = PATH_ROOT . strtolower($className) . '.class.php';
        requireFileIfExists($pathRoot);
    }
    
    spl_autoload_register(__NAMESPACE__ . '\\autoloadLibrary');
    spl_autoload_register(__NAMESPACE__ . '\\autoloadController');
    spl_autoload_register(__NAMESPACE__ . '\\autoloadModel');
    spl_autoload_register(__NAMESPACE__ . '\\autoloadNamespace');
    
    // FUNCTION CALLS
    setReporting();
    preventHijacking();
    removeMagicQuotes();
    unsetRegisterGlobals();
    $callRes = callBuilder($url);
    
    function var_dump2($var){
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
        echo "<br />";
    }