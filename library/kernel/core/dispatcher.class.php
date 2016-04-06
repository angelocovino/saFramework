<?php
    namespace library\kernel\core;
    use \Exception;
    
    class Dispatcher{
        // SINGLETON VARIABLE
        private $singleton              = false;
        // CONTROLLER VARIABLES
        private $defaultControllerName  = false;
        private $controllerName         = false;
        // ACTION VARIABLES
        private $defaultActionName      = false;
        private $actionName             = false;
        // QUERY STRING
        private $queryString            = array();
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        function __construct($url = false){
            $this->defaultControllerName = NAMESPACE_CONTROLLERS . ucwords(FRAMEWORK_NAME) . 'Controller';
            $this->defaultActionName = 'index';
            if(!class_exists($this->defaultControllerName)){
                throw new Exception('Main class not found', ERROR_FW_CONTROLLER_NOT_FOUND);
            }else if(!method_exists($this->defaultControllerName, strtolower(FRAMEWORK_NAME))){
                throw new Exception('Non esiste una pagina home', 666);
            }
            if($this->findCorrectParams($url)){
                $this->setSingleton(new $this->controllerName());
            }else{
                throw new Exception('erroraccio', 666);
            }
        }
        
        // DISPATCH BUILDER AND ITS SUBFUNCTIONS
        public static function dispatchBuilder($url){
            // INSTANTIATE DISPATCH
            $dispatcher = new Dispatcher($url);
            $dispatch = $dispatcher->getSingleton();
            if($dispatch !== false){
                // INITIALIZE CONTROLLER
                call_user_func_array(array($dispatch, 'initialize'), array($dispatcher->getController(), $dispatcher->getAction()));
                // CALL CONTROLLER ACTION AND RENDER THE VIEW RESULT IF THERE IS ONE
                $actionRes = call_user_func_array(array($dispatch, $dispatcher->getAction()), $dispatcher->getQueryString());
                if(!is_null($actionRes) && is_object($actionRes)){
                    $actionRes->render();
                }
                return (true);
            }
        }
        private function findCorrectParams($url){
            if($url === false){
                $this->controllerName = $this->defaultControllerName;
                $this->actionName = strtolower(FRAMEWORK_NAME);
                return (true);
            }
            $url = explode('/', $url);
            $controllerName = array_shift($url);
            $controllerNameComplete = NAMESPACE_CONTROLLERS . ucfirst($controllerName . 'Controller');
            // DEFAULT CONTROLLER EXISTS
            if(class_exists($controllerNameComplete)){
                // CONTROLLER EXISTS
                $this->controllerName = $controllerNameComplete;
                switch(count($url)){
                    case 0:
                        $this->actionName = $this->defaultActionName;
                        break;
                    case 1:
                        $this->actionName = array_shift($url);
                        break;
                    default:
                        $queryString = $url;
                        break;
                }
                if(method_exists($this->controllerName, $this->actionName)){
                    return (true);
                }
            }else{
                // CONTROLLER DOESN'T EXIST
                $this->controllerName = $this->defaultControllerName;
                $this->actionName = $controllerName;
                $queryString = $url;
                if(method_exists($this->controllerName, $this->actionName)){
                    return (true);
                }
            }
            return (false);
        }
        
        // SET FUNCTIONS
        private function setSingleton($singleton){$this->singleton = $singleton;}
        
        // GET FUNCTIONS
        public function getSingleton(){return ($this->singleton);}
        public function getAction(){return ($this->actionName);}
        public function getController(){return ($this->controllerName);}
        public function getQueryString(){return ($this->queryString);}
    }