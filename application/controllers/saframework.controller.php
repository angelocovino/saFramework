<?php
    namespace application\controllers;
    use library\kernel\Controller;
    use library\kernel\View;
    // MODELS
    use application\models\Item;
    
    class Saframework extends Controller{
        // HERE YOU WILL DECLARE YOUR MODELS LIKE:
        // private $item;
        
        function __construct(){
            // HERE YOU WILL INSTANTIATE YOUR MODELS LIKE:
            // $this->item = new Item();
        }
        function index(){
            
        }
        function login(){
            $view = View::build('login.php')
                ->setVariables('title', 'o mej framework into the world for PHP');
            return ($view);
        }
        // THIS FUNCTION WILL BE THE ONLY ONE WORKING IN THIS CONTROLLER
        function saframework(){
            $view = View::build('items:viewall.php')
                ->setVariables('title', 'o mej framework into the world for PHP')
                ->setVariables('pippo', 'SONO SAFRAMEWORK')
                ->setVariables('pluto', 'PHYTON CIO MAGNAMM, COMM E COLOMBIAN!');
            return ($view);
        }
    }