<?php
    namespace application\controllers;
    use library\Controller;
    use application\models\Persona;
    
    class PersonasController extends Controller{
        private $persona = false;
        
        function __construct(){
            $this->persona = new Persona();
        }
        
        function index(){
            $this->setTemplate('title', 'pagina di persona');
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