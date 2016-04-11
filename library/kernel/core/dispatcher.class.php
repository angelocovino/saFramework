<?php
    namespace library\kernel\core;
    use library\kernel\core\Dispatch;
    use library\kernel\config\Config;
    use library\kernel\core\MethodParams;
    use library\kernel\View;
    use \Exception;
    
    abstract class Dispatcher{
        // DISPATCHER VARIABLES
        private static $dispatch        = false;
        private static $dispatchAction  = false;
        // VIEW VARIABLES
        private static $view            = false;
        
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
        private static function checkDispatchTags(){
            $dispatch = self::$dispatch;
            // RETRIEVE CHOOSEN ACTION TAGS
            $tags = $dispatch->getSingleton()->getTags($dispatch->getAction());
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
        private static function setDispatchPlugins($plugins){
            $dispatch = self::$dispatch;
            // IF PLUGINS NEED TO BE INCLUDED
            if($plugins !== false){
                // GET ACTION PARAMETERS
                $cmp = MethodParams::build($dispatch->getSingleton(), $dispatch->getAction());
                // RETRIEVE PLUGINS PARAMETER POSITION
                $pluginParamPos = $cmp->getNameIndex(PLUGINS_CONTROLLER_PARAM_NAME);
                // CHECK PLUGINS PARAMETER POSITION
                if($pluginParamPos !== false){
                //var_dump2($pluginParamPos, $dispatch->getQueryString());
                var_dump2(count($dispatch->getQueryString()), ($cmp->getCountNecessary()-1));
                    // IF ACTION HAS NO PARAMETERS DO NOT PROCEED
                    if(count($dispatch->getQueryString()) < ($cmp->getCountNecessary()-1)){
                        throw new Exception('Action can not be called, parameters required', 666);
                        /*
                    }else if(count($dispatch->getQueryString()) < $pluginParamPos){
                        throw new Exception('Can not pass action plugins without preceding parameters', 666);
                        */
                    }
                    // ACTION HAS SUFFICIENT PARAMETERS
                    // ADD PLUGIN AT THE CORRECT POSITION IN ACTION PARAMETERS LIST
                    $dispatch->addQueryStringByPos($plugins, $pluginParamPos);
                }
                var_dump2($dispatch->getQueryString());
            }
        }
        
        // DISPATCHER START
        public static function start(){
            if(!self::checkDispatch()){
                throw new Exception('Dispatch not found', 666);
            }
            $dispatch = self::$dispatch;
            // INITIALIZE CONTROLLER
            call_user_func_array(
                // INVOKE initialize METHOD IN CHOOSEN CONTROLLER
                array($dispatch->getSingleton(), 'initialize'),
                // PASSING AS ARGUMENT ITS NAME AND CHOOSEN ACTION
                array($dispatch->getController(), $dispatch->getAction())
            );
//$dispatch->getSingleton()->{'initialize'}($dispatch->getController(), $dispatch->getAction());
            
            // CHECK TAGS
            $activePlugins = self::checkDispatchTags();
            
            // SET PLUGINS
            self::setDispatchPlugins($activePlugins);
            
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