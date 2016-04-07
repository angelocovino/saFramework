<?php
    namespace application\controllers;
    use library\kernel\Controller;
    use library\kernel\View;
    use application\models\Item;
    
    class ItemsController extends Controller{
        private $item = false;
        
        function __construct(){
            $this->item = new Item();
        }
        
        function view($id = null, $name = null){
            $view = View::build('items:view.php')
                ->setVariables('title', $name)
                ->setVariables('pippo', 'SONO ITEMS')
                ->setVariables('pluto', 'dsa')
                ->setVariables('todo', $this->item->where('id', '=', $id)->getItemArray('Item'));
            return ($view);
        }
        /*
        function viewall(){
            $this->setTemplate('title', 'All Items - My Todo List App');
            $this->setTemplate('todo', $this->item
                               ->getItemsArray('Item')
                              );
            $this->setStyle('style.css');
        }
        */
        
        function viewall(){
            $view = View::build('items:viewall1.php')
                ->setVariables('title', 'titolo')
                ->setVariables('pippo', 'SONO ITEMS')
                ->setVariables('pluto', 'dsa')
                ->setVariables('todo', $this->item->getItemsArray('Item'));
            return ($view);
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
    }