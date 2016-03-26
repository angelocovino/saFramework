<?php


    class Controller{
        protected $_model;
        protected $_controller;
        protected $_action;
        protected $_template;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        /**
         * CONSTRUCT FUNCTION
         * @param $model      Name of the model class
         * @param $controller Name of the controller class
         * @param $action     Name of the action function
         */
        function __construct($model, $controller, $action){
            $this->_model = new $model;
            $this->_controller = $controller;
            $this->_action = $action;
            $this->_template = new Template($controller,$action);
        }
        /**
         * DESTRUCT FUNCTION
         */
        function __destruct(){
            $this->_template->render();
        }
        
        // TEMPLATE FUNCTIONS
        /**
         * SET TEMPLATE VARIABLES
         * @param $key   Array key
         * @param $value Array value
         */
        function setTemplate($key, $value){
            $this->_template->setVariable($key, $value);
        }
    }