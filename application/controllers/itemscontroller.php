<?php
    namespace application\controllers;
    use library\Controller;
    use application\models\Item;
    
    class ItemsController extends Controller{
        private $item = false;
        
        function __construct(){
            $this->item = new Item();
        }
        
        function view($id = null, $name = null){
            $this->setTemplate('title', $name . ' - My Todo List App');
            $this->setTemplate('todo', $this->item
                               ->where('id', '=', $id)
                               ->getItemArray('Item')
                              );
        }
        
        function viewall(){
            $this->setTemplate('title', 'All Items - My Todo List App');
            $this->setTemplate('todo', $this->item
                               ->getItemsArray('Item')
                              );
            $this->setStyle('style.css');
        }
        
        function add(){
            $todo = $_POST['todo'];
            $this->setTemplate('title', 'Success - My Todo List App');
            $this->setTemplate('todo', $this->item
                               ->insert(['item_name' => $todo])
                              );	
        }
        
        function delete($id = null){
            $this->setTemplate('title', 'Success - My Todo List App');
            $this->setTemplate('todo', $this->item
                               ->where('id','=',$id)
                               ->delete()
                              );	
        }
        
        function index(){
            $this->setTemplate('title', 'Success - My Todo List App');
        }
    }