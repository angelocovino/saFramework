<?php
    namespace library\kernel\core;
    use library\kernel\core\Dispatch;
    use library\kernel\core\ActionParams;
    use library\kernel\config\Config;
    use library\kernel\View;
    use \Exception;
    
    abstract class Dispatcher{
        // DISPATCHER VARIABLES
        private static $dispatch                = false;
        // DISPATCHER METHOD VARIABLES
        private static $actionParams            = false;
        // VIEW VARIABLES
        private static $defaultParams           = false;
        private static $defaultIndexes          = false;
        private static $view                    = false;
        
        // SET DISPATCH FUNCTIONS
        public static function setDispatch(Dispatch $dispatch){
            if(!self::checkDispatch()){
                self::$dispatch = $dispatch;
                return (true);
            }
            return (false);
        }
        
        // CHECK DISPATCH FUNCTIONS
        private static function checkDispatch(){
            if((self::$dispatch !== false) && (self::$dispatch instanceof Dispatch)){
                return (true);
            }
            return (false);
        }
        
        // CHECK DISPATCH TAGS FUNCTIONS
        private static function getTags(){
            $dispatch = self::$dispatch;
            // RETRIEVE CHOOSEN ACTION TAGS
            return ($dispatch->getSingleton()->getTags($dispatch->getAction()));
        }
        
        // GET DISPATCH ACTION PLUGINS
        private static function getPlugins($tags){
            // IF ACTION HAS TAGS
            if($tags !== false){
                // PARSE INI TAGS LIST
                $settedTags = Config::parseINIFile(PATH_CONFIG . 'tag.ini', true)->getConfigs();
                // PARSE INI PLUGINS LIST
                $plugins = Config::parseINIFile(PATH_KERNEL_CONFIG . 'plugins.ini', true)->getConfigs('PLUGINS');
                // CYCLE TAGS TO RETRIEVE ACTIVE PLUGIN LIST
                $activePlugins = array();
                foreach($tags as $tag){
                    foreach($settedTags[strtoupper($tag)] as $k => $v){
                        $activePlugins[strtolower($k)] = $plugins[strtoupper($k)];
                    }
                }
                // IF PLUGINS WERE FOUND
                if(count($activePlugins)>0){
                    return ($activePlugins);
                }
                // NO PLUGINS FOUND
            }
            // ACTION HAS NO TAGS
            return (false);
        }
        
        // CHECK DISPATCH ACTION PARAMETERS
        private static function checkAndSetDefaultParameters($class, $tags, $isPlugin = false){
            $dispatch = self::$dispatch;
            
            if(self::$actionParams->getClassNameCount($class)>1){
                throw new Exception('Only one instance of ' . $class . ' is allowed', 666);
            }
            // SETTING PARAM POS
            $paramPos = self::$actionParams->getClassNameIndex($class);
            $paramName = self::$actionParams->getIndexName($paramPos);
            if($paramPos !== false){
                // SETTING PARAM INSTANCE
                $classInstance = 'library\\' . strtolower($class) . '\\' . $class;
                // 
                if($isPlugin === true){
                    // CHECKING IF PLUGIN IS AMONG ACTION PARAMETERS
                    if($paramPos !== false){
                        // CHECK THERE IS NO PLUGIN PARAMS IF NO TAGS ARE SPECIFIED
                        if($tags === false){
                            throw new Exception('Action can not be called, no parameters instance of ' . $class . ' allowed, it is allowed only after setting valid Tags, using \'setTag\' controller function', 666);
                        }
                        // GET PLUGINS
                        $activePlugins = self::getPlugins($tags);
                        // IF PLUGINS NEED TO BE INCLUDED AND PLUGIN PARAMETER IS PRESENT
                        if($activePlugins !== false){
                            // ACTION HAS SUFFICIENT PARAMETERS
                            // ADD PLUGIN AT THE CORRECT POSITION IN ACTION PARAMETERS LIST
                            $classInstance = new $classInstance($activePlugins);
                            self::$defaultParams[$paramName] = $classInstance;
                            self::$defaultIndexes[$paramPos] = $classInstance;
                        }
                    }
                }else{
                    $classInstance = new $classInstance();
                    self::$defaultParams[$paramName] = $classInstance;
                    self::$defaultIndexes[$paramPos] = $classInstance;
                }
            }
        }
        private static function checkParameters($tags){
            $dispatch = self::$dispatch;
            
            // SETTING UP DEFAULT PARAMETERS
            $defaultParams = array('Plugin', 'Response', 'Request');
            // CHECKING EACH DEFAULT PARAMETER
            foreach(self::$actionParams->getClassNames() as $index => $class){
                if(in_array($class, $defaultParams)){
                    if(strcmp($class, $defaultParams[0])==0){
                        self::checkAndSetDefaultParameters($class, $tags, true);
                    }else{
                        self::checkAndSetDefaultParameters($class, $tags);
                    }
                }
            }
            
            // REMOVE DEFAULT PARAMS IN ORDER TO CHECK REMAING PARAMETERS
            self::$actionParams->removeParams($defaultParams);
            
            // CHECK DEFAULT ACTION HAS NO PARAMETERS INSIDE EXCEPT FOR DEFAULT PARAMETERS
            if($dispatch->getIsActionDefault()){
                // CHECK IT USING NUMBER OF DEFAULT ACTION PARAMETERS
                if(self::$actionParams->getCount()>0){
                    throw new Exception('Default Action can not be called, no parameters allowed except for ' . implode(', ', $defaultParams), 666);
                }
            }
            
            // CHECK FOR NECESSARY PARAMS IN VERY FIRST POSITIONS
            if(!self::$actionParams->checkNecessaryParamsInVeryFirstPositions()){
                throw new Exception('Action can not be called, parameters required in very first positions', 666);
            }
            
            // CHECK NUMBER OF NECESSARY ARGUMENTS REQUIRED
            if(self::$actionParams->getCountNecessary() > (count($dispatch->getQueryString()))){
                // LESS NECESSARY ARGUMENTS THAN FUNCTION NEEDS
                throw new Exception('Action can not be called, parameters required', 666);
            }
            
            // ADDING DEFAULT PARAMS TO QUERY STRING
            if(self::$defaultIndexes !== false){
                foreach(self::$defaultIndexes as $index => $class){
                    $dispatch->addQueryStringByPos($class, $index, self::$actionParams->getDefaultValues());
                }
            }
        }
        
        // DISPATCHER START
        public static function start(){
            if(!self::checkDispatch()){
                throw new Exception('Dispatch not found', 666);
            }
            // RETRIEVE DISPATCH
            $dispatch = self::$dispatch;
            
            // INITIALIZE CONTROLLER
            call_user_func_array(
                // INVOKE initialize METHOD IN CHOOSEN CONTROLLER
                array($dispatch->getSingleton(), 'initialize'),
                // PASSING AS ARGUMENT ITS NAME AND CHOOSEN ACTION
                array($dispatch->getController(), $dispatch->getAction())
            );
            
            // CHECK TAGS
            $tags = self::getTags();
            
            // INITIALIZE ACTION PARAMS
            self::$actionParams = ActionParams::build($dispatch->getSingleton(), $dispatch->getAction());
            
            // CHECK DISPATCH ACTION PARAMETERS POSITION AND QUANTITY
            self::checkParameters($tags);
            
            // RETRIEVE VIEW FROM CHOOSEN METHOD IN CHOOSEN CONTROLLER
            self::$view = call_user_func_array(
                // INVOKE CHOOSEN METHOD IN CHOOSEN CONTROLLER
                array($dispatch->getSingleton(), $dispatch->getAction()),
                // PASSING AS ARGUMENT ITS QUERY STRING (WHICH IS ALREADY AN ARRAY)
                $dispatch->getQueryString()
            );
            
            // IF VIEW IS NOT NULL (CAN BE NULL WHEN THERE IS NO RETURN VALUE) AND IT'S A View INSTANCE
            if(!is_null(self::$view) && (self::$view instanceof View)){
                if(is_array(self::$defaultParams) && (count(self::$defaultParams)>0)){
                    foreach(self::$defaultParams as $name => $object){
                        self::$view->setVariables($name, $object);
                    }
                }
                // SET VARIABLES controllerName AND actionName TO USE THEM INTO VIEWS
                self::$view->setVariables('controllerName', $dispatch->getControllerName());
                self::$view->setVariables('actionName', $dispatch->getAction());
                // RENDER THE PAGE
                self::$view->render();
            }
        }
    }