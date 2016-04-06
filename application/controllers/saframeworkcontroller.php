<?php
    namespace application\controllers;
    use library\kernel\Controller;
    use library\kernel\View;
    use application\models\Item;
    
    class SaframeworkController extends Controller{
        // HERE YOU WILL DECLARE YOUR MODELS LIKE:
        // private $item;
        
        function __construct(){
            // HERE YOU WILL INSTANTIATE YOUR MODELS LIKE:
            // $this->item = new Item();
        }
        
        function casa(){
            
        }
        // THIS FUNCTION WILL BE THE ONLY ONE WORKING IN THIS CONTROLLER
        function saframework(){
            $view = View::build('items:viewall1.php')
                ->setVariables('title', 'o mej framework into the world for PHP')
                ->setVariables('pippo', 'SONO SAFRAMEWORK')
                ->setVariables('pluto', 'PHYTON CIO MAGNAMM, COMM E COLOMBIAN!');
            return ($view);
        }
    }