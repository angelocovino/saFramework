<?php
    namespace application\controllers;
    use library\kernel\Controller;
    use library\kernel\View;
    // DEFAULT PARAMETERS
    use library\response\Response;
    use library\request\Request;
    use library\plugin\Plugin;
    // MODELS
    use application\models\Item;
    
    class Items extends Controller{
        private $item = false;
        
        function __construct(){
            $this->item = new Item();
            $this->setTags('view', ['angelo']);
            $this->setTags('viewall', ['angelo']);
        }
        
        function view($id = null, $name = null){
            $view = View::build('items:view.php')
                ->setVariables('title', $name)
                ->setVariables('pippo', 'SONO ITEMS')
                ->setVariables('pluto', 'dsa')
                ->setVariables('todo', $this->item->where('id', '=', $id)->getItemArray('Item'));
            return ($view);
        }
        
        function viewall(Request $req, $a = null, Plugin $visuale, $b = null, Response $res){
            $view = View::build('items:viewall1.php')
                ->setVariables('title', 'titolo')
                ->setVariables('pippo', 'SONO ITEMS')
                ->setVariables('pluto', 'dsa')
                ->setVariables('todo', $this->item->getItemsArray('Item'));
            return ($view);
        }
        
        function add(){
            $todo = $_POST['todo'];
            $view = View::build('items:add.php')
                ->setVariables('title', 'titolo')
                ->setVariables('todo', $this->item->insert(['item_name' => $todo]));
            return ($view);
        }
        
        function delete($id = null){
            $view = View::build('items:delete.php')
                ->setVariables('title', 'titolo')
                ->setVariables('todo', $this->item->where('id','=',$id)->delete());
            return ($view);
        }
    }