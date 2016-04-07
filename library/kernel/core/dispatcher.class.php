<?php
    namespace library\kernel\core;
    use \Exception;
    
    class Dispatcher{
        // SINGLETON VARIABLE
        private $singleton              = false;
        // CONTROLLER VARIABLES
        private $controllerDefault      = false;
        private $controllerName         = false;
        private $controller             = false;
        // ACTION VARIABLES
        private $actionDefault          = false;
        private $action             = false;
        // QUERY STRING
        public $queryString            = array();
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        function __construct($url = false){
            $this->controllerDefault = NAMESPACE_CONTROLLERS . ucwords(FRAMEWORK_NAME) . 'Controller';
            $this->actionDefault = 'index';
            if(!class_exists($this->controllerDefault)){
                throw new Exception('Main class not found', ERROR_FW_CONTROLLER_NOT_FOUND);
            }else if(!method_exists($this->controllerDefault, strtolower(FRAMEWORK_NAME))){
                throw new Exception('Non esiste una pagina home', 666);
            }
            if($this->findCorrectParams($url)){
                $this->setSingleton(new $this->controller());
            }else{
                throw new Exception('erroraccio', 666);
            }
        }
        // DISPATCH BUILDER AND ITS SUBFUNCTIONS
        public static function dispatchBuilder($url){
            // INSTANTIATE DISPATCH
            $dispatcher = new Dispatcher($url);
            $dispatch = $dispatcher->getSingleton();
            // IF CONTROLLER INSTANTIATION IS GONE WELL
            if($dispatch !== false){
                // INITIALIZE CONTROLLER
                call_user_func_array(array($dispatch, 'initialize'), array($dispatcher->getController(), $dispatcher->getAction()));
                // CALL CONTROLLER ACTION AND RENDER THE VIEW RESULT IF THERE IS ONE
                $actionView = call_user_func_array(array($dispatch, $dispatcher->getAction()), $dispatcher->getQueryString());
                // IF VIEW IS NOT NULL (CAN BE NULL WHEN THERE IS NO RETURN VALUE) AND RETURN VALUE IS AN OBJECT
                if(!is_null($actionView) && is_object($actionView)){
                    // SET VARIABLES controllerName AND actionName TO USE THEM INTO VIEWS
                    //if(){
                        $actionView->setVariables('form', 'plugin\form\Form');
                        $actionView->setVariables('cookie', 'plugin\cookie\Cookie');
                    //}
                    $actionView->setVariables('controllerName', $dispatcher->getControllerName());
                    $actionView->setVariables('actionName', $dispatcher->getAction());
                    // RENDER THE PAGE
                    $actionView->render();
                }
                return (true);
            }
        }
        private function findCorrectParams($url){
            if($url === false){
                $this->controller = $this->controllerDefault;
                $this->action = strtolower(FRAMEWORK_NAME);
                return (true);
            }
            $url = explode('/', $url);
            $this->controllerName = array_shift($url);
            $controllerCompletePath = NAMESPACE_CONTROLLERS . ucfirst($this->controllerName . 'Controller');
            // DEFAULT CONTROLLER EXISTS
            if(class_exists($controllerCompletePath)){
                // CONTROLLER EXISTS
                $this->controller = $controllerCompletePath;
                $this->action = $this->actionDefault;
                if(count($url)>0){
                    $this->action = array_shift($url);
                    if(count($url)>0){
                        $this->queryString = $url;
                    }
                }
                
                if(method_exists($this->controller, $this->action)){
                    return (true);
                }
            }else{
                // CONTROLLER DOESN'T EXIST
                $this->controller = $this->controllerDefault;
                $this->action = $this->controllerName;
                array_shift($url);
                $this->queryString = $url;
                if(method_exists($this->controller, $this->action)){
                    return (true);
                }
            }
            return (false);
        }
        
        // SET FUNCTIONS
        private function setSingleton($singleton){$this->singleton = $singleton;}
        
        // GET FUNCTIONS
        public function getSingleton(){return ($this->singleton);}
        public function getAction(){return ($this->action);}
        public function getController(){return ($this->controller);}
        public function getControllerName(){return ($this->controllerName);}
        public function getQueryString(){return ($this->queryString);}
    }