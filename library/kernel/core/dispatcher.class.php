<?php
    namespace library\kernel\core;
    use library\kernel\core\Dispatch;
    use library\kernel\config\Config;
    use library\kernel\core\MethodParams;
    use library\kernel\View;
    use \Exception;
    
    abstract class Dispatcher{
        // DISPATCHER VARIABLES
        private static $dispatch                = false;
        // DISPATCHER METHOD VARIABLES
        private static $methodParams            = false;
        private static $methodPluginParamPos    = false;
        // VIEW VARIABLES
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
        private static function checkTags(){
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
        
        // SET DISPATCH ACTION PLUGINS
        private static function setPlugins($plugins){
            $dispatch = self::$dispatch;
            // IF PLUGINS NEED TO BE INCLUDED
            if($plugins !== false){
                // CHECK PLUGINS PARAMETER POSITION
                if(self::$methodPluginParamPos !== false){
                    // IF ACTION HAS NO PARAMETERS DO NOT PROCEED
                    if(count($dispatch->getQueryString()) < (self::$methodParams->getCountNecessary()-1)){
                        throw new Exception('Action can not be called, parameters required', 666);
                    }
                    // ACTION HAS SUFFICIENT PARAMETERS
                    // ADD PLUGIN AT THE CORRECT POSITION IN ACTION PARAMETERS LIST
                    $dispatch->addQueryStringByPos($plugins, self::$methodPluginParamPos, self::$methodParams->getDefaultValues());
                }
            }
        }
        
        // CHECK DISPATCH ACTION PARAMETERS
        private static function checkParameters($tags){
            $dispatch = self::$dispatch;
            
            // CHECK NO PLUGINS_CONTROLLER_PARAM_NAME PARAMS IF NO TAGS ARE SPECIFIED
            if(($tags === false) && (self::$methodPluginParamPos !== false)){
                throw new Exception('Action can not be called, no parameters called ' . PLUGINS_CONTROLLER_PARAM_NAME . ' allowed, it is allowed only after setting valid Tags, using setTag controller function', 666);
            }
            
            // CHECK DEFAULT ACTION HAS NO PARAMETERS INSIDE EXCEPT FOR PLUGIN PARAMETER (IF TAG ARE SETTED)
            if($dispatch->getIsActionDefault()){
                // CHECK IT USING NUMBER OF DEFAULT ACTION PARAMETERS
                switch(self::$methodParams->getCount()){
                    default:
                        throw new Exception('Default Action can not be called, no parameters allowed except for Plugins', 666);
                        break;
                    case 1:
                        if(!(($tags !== false) && (self::$methodPluginParamPos !== false))){
                            throw new Exception('Default Action can not be called, no parameters allowed except for Plugins', 666);
                        }
                    case 0:
                        break;
                }
            }
            
            // CHECK NECESSARY PARAMETERS NUMBER AND OPTIONAL PARAMETERS POSITION
            // SETTING UP REAL NUMBER OF NECESSARY PARAMS
            $necessaryParams = self::$methodParams->getCountNecessary() + ((self::$methodPluginParamPos !== false) ? (-1) : 0);
            // CHECK NUMBER OF NECESSARY ARGUMENTS REQUIRED
            if($necessaryParams > count($dispatch->getQueryString())){
                // LESS NECESSARY ARGUMENTS THAN FUNCTION NEEDS
                throw new Exception('Action can not be called, parameters required', 666);
            }else{
                // CHECK FOR NECESSARY PARAMS IN VERY FIRST POSITIONS
                $i = 0;
                // SETTING UP HOW MANY POSITION CHECK FOR NECESSARY PARAMS
                // IF PLUGIN VARIABLE IS A PARAMETER CHECK ITS POSITION
                if((self::$methodPluginParamPos !== false) && (self::$methodPluginParamPos < $necessaryParams)){
                    // PLUGIN VARIABLE IS IN AMONG VERY FIRST POSITIONS
                    $necessaryParams = self::$methodParams->getCountNecessary();
                }
                // CHECK IF VERY FIRST PARAMETERS ARE OPTIONAL
                while($i<$necessaryParams){
                    if((self::$methodParams->isOptional($i)) && ($i != self::$methodPluginParamPos)){
                        throw new Exception('Action can not be called, parameters required in very first positions', 666);
                    }
                    $i++;
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
            $tags = self::checkTags();
            
            // INITIALIZE METHOD PARAMS
            self::$methodParams = MethodParams::build($dispatch->getSingleton(), $dispatch->getAction());
            // RETRIEVE PLUGINS PARAMETER POSITION
            
            self::$methodPluginParamPos = self::$methodParams->getNameIndex(PLUGINS_CONTROLLER_PARAM_NAME);
            
            // CHECK DISPATCH ACTION PARAMETERS POSITION AND QUANTITY
            self::checkParameters($tags);
            
            // GET PLUGINS
            $activePlugins = self::getPlugins($tags);
            
            // SET PLUGINS
            self::setPlugins($activePlugins);
            
            // RETRIEVE VIEW FROM CHOOSEN METHOD IN CHOOSEN CONTROLLER
            self::$view = call_user_func_array(
                // INVOKE CHOOSEN METHOD IN CHOOSEN CONTROLLER
                array($dispatch->getSingleton(), $dispatch->getAction()),
                // PASSING AS ARGUMENT ITS QUERY STRING (WHICH IS ALREADY AN ARRAY)
                $dispatch->getQueryString()
            );
            
            // IF VIEW IS NOT NULL (CAN BE NULL WHEN THERE IS NO RETURN VALUE) AND IT'S A View INSTANCE
            if(!is_null(self::$view) && (self::$view instanceof View)){
                if($activePlugins !== false){
                    self::$view->setVariables('plugins', $activePlugins);
                }
                // SET VARIABLES controllerName AND actionName TO USE THEM INTO VIEWS
                self::$view->setVariables('controllerName', $dispatch->getControllerName());
                self::$view->setVariables('actionName', $dispatch->getAction());
                // RENDER THE PAGE
                self::$view->render();
            }
        }
    }