<?php
    namespace library;
    use library\Template;
    use plugin\session\Session;
    
    abstract class Controller{
        protected $controllerName;
        protected $actionName;
        protected $_template;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        /**
             * CONSTRUCT FUNCTION
             * @param $model      Name of the model class
             * @param $controller Name of the controller class
             * @param $action     Name of the action function
             */
        /*
        function __construct($controller, $action){
            $this->controllerName = $controller;
            $this->actionName = $action;
            //$this->controllerName = strtolower(getClassFromNamespace(substr(get_class($this), 0, strlen(get_class($this))-strlen('controller'))));
            $this->_template = new Template($this->controllerName, $this->actionName);

            // SESSION MANAGEMENT
            $this->sessionManagement();
        }
        */
        /**
         * DESTRUCT FUNCTION
         */
        function __destruct(){
            $this->_template->render();
        }
        
        public function initialize($controller, $action){
            $this->controllerName = $controller;
            $this->actionName = $action;
            //$this->controllerName = strtolower(getClassFromNamespace(substr(get_class($this), 0, strlen(get_class($this))-strlen('controller'))));
            $this->_template = new Template($this->controllerName, $this->actionName);

            // SESSION MANAGEMENT
            $this->sessionManagement();
            
            //self::__construct($controller, $action);
        }
        
        // TEMPLATE FUNCTIONS
        /**
             * SET TEMPLATE VARIABLES
             * @param $key   Array key
             * @param $value Array value
             */
        protected function setTemplate($key, $value){
            $this->_template->setVariable($key, $value);
        }
        /**
             * SET TEMPLATE STYLE VARIABLES
             * @param $name String className (with arbitrary extension)
             */
        protected function setStyle($name){
            $this->_template->setStyle($name);
        }
        
        // SESSION FUNCTIONS
        private function sessionManagement(){
            /*
                //$session->setDBSession($session->generateUniqueSessionID());
                //$session->getDBSession(17);
                if(!$session->checkSessionSet()){
                    $session->setSession(SESSION_DEFAULT_NAME, $this->controllerName);
                }
                echo $session->getSession(SESSION_DEFAULT_NAME);
                */
            // CREATE AN ISTANCE OF SESSION
            Session::open();
        }
    }