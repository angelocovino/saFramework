<?php
    namespace library;
    
    /*
        // SESSION FUNCTIONS
        private function sessionManagement(){
                //$session->setDBSession($session->generateUniqueSessionID());
                //$session->getDBSession(17);
                //if(!$session->checkSessionSet()){
                //    $session->setSession(SESSION_DEFAULT_NAME, $this->controllerName);
                //}
                //echo $session->getSession(SESSION_DEFAULT_NAME);
            // CREATE AN ISTANCE OF SESSION
            Session::open();
        }
    */
    
    class Template{
        // TEMPLATE MVC LINKS
        protected $controllerName   = false;
        protected $actionName       = false;
        
        // TEMPLATE VARIABLES
        protected $variables        = false;
        
        // TEMPLATE PATH VARIABLES
        protected $pathViewLocal    = false;
        protected $pathViewStorage  = false;
        
        function __construct($controller, $action){
            // CONSTRUCT PROCEDURE
            $this->controllerName = $controller;
            $this->actionName = $action;

            // INITIALIZATION
            $this->variables = array();
            $this->pathViewLocal = PATH_VIEW . $this->controllerName . DS;
            $this->pathViewStorage = ROOT . DS . 'storage' . DS . 'views' . DS;
        }
        
        // STYLES SET
        public function setStyle($name){
            if(!isset($this->variables['styles'])){
                $this->variables['styles'] = array();
            }
            if(file_exists($this->pathViewLocal . $name)){
                array_push($this->variables['styles'], $this->pathViewLocal . $name);
            }else if(file_exists($name)){
                array_push($this->variables['styles'], $name);
            }
        }
        
        // VARIABLES SET
        public function setVariable($name, $value){
            $this->variables[$name] = $value;
        }
        
        // TEMPLATE DISPLAY
        public function render(){
            // EXTACT VARIABLES TO USE THEM WITHOUT ARRAY
            extract($this->variables);
            // HEADER INCLUDE
                // STYLE INCLUDE
                if(!isset($this->variables['styles'])){
                    if(file_exists(PATH_VIEW . "style.css")){
                        array_push($this->variables['styles'], PATH_VIEW . "style.css");
                    }
                }
            if(file_exists($this->pathViewLocal . 'header.php')){
                include($this->pathViewLocal . 'header.php');
            }else{
                include(PATH_VIEW . 'header.php');
            }
            // ACTION INCLUDE
            if(file_exists($this->pathViewStorage . $this->actionName . '.php')){
                include($this->pathViewStorage . $this->actionName . '.php');
            }else if(file_exists($this->pathViewLocal . $this->actionName . '.php')){
                include($this->pathViewLocal . $this->actionName . '.php');
            }
            // FOOTER INCLUDE
            if(file_exists($this->pathViewLocal . 'footer.php')){
                include($this->pathViewLocal . 'footer.php');
            }else{
                include(PATH_VIEW . 'footer.php');
            }
        }
    }