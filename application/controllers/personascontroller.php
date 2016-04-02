<?php
    class PersonasController extends Controller{
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