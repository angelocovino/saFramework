<?php
    namespace application\controllers;
    use library\kernel\Controller;
    use library\kernel\View;
    use application\models\Persona;
    
    class PersonasController extends Controller{
        private $persona = false;
        
        function __construct(){
            $this->persona = new Persona();
        }
        
        function index(){
            $view = View::build('items:viewall.php')
                ->setVariables('title', 'titolo')
                ->setVariables('pippo', 'SONO PERSONAS')
                ->setVariables('pluto', 'dsa');
            return ($view);
        }
        
        function viewall(){
            $this->setTemplate('title', 'All Items - My Todo List App');
            $this->setTemplate('todo', $this->_model
                               ->getItemsArray('Item')
                              );
        }
        
        function provola(){
            
        }
    }