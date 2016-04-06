<?php
    namespace library\kernel;
    
    abstract class Controller{
        protected $controllerName   = false;
        protected $actionName       = false;
        
        // INITIALIZE SUBCONTROLLER
        public function initialize($controller, $action){
            $this->controllerName = $controller;
            $this->actionName = $action;
        }
    }