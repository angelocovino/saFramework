<?php

use plugin\session\Session;

class Controller{
    protected $_model;
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
    function __construct($model, $controller, $action){
        $this->_model = new $model;
        $this->controllerName = $controller;
        $this->actionName = $action;
        $this->_template = new Template($this->controllerName, $this->actionName);

        // SESSION MANAGEMENT
        $this->sessionManagement();
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
    /**
         * SET TEMPLATE STYLE VARIABLES
         * @param $name String className (with arbitrary extension)
         */
    function setStyle($name){
        $this->_template->setStyle($name);
    }

    // SESSION FUNCTIONS
    function sessionManagement(){
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