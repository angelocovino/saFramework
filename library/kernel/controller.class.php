<?php
    namespace library\kernel;
    
    abstract class Controller{
        private $controllerName = false;
        private $actionName     = false;
        private $tags           = false;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        public function __construct(){}
        public function __destruct(){}
        
        // INITIALIZE SUBCONTROLLER
        public function initialize($controller, $action){
            $this->controllerName = $controller;
            $this->actionName = $action;
        }
        
        // TAG FUNCTIONS
        protected function setTags($action, $tags){
            if(method_exists($this, $action)){
                if(!is_array($tags)){$this->tags = array();}
                $this->tags[$action] = $tags;
            }
        }
        public function getTags($action){
            if(is_array($this->tags) && array_key_exists($action, $this->tags)){
                return ($this->tags[$action]);
            }
            return false;
        }
        /*
        public function removeActions(){
            //$this->actionName;
            if(\runkit_function_remove('asd')){
                echo "non chiamarmi annarella";
            }
        }
        */
    }