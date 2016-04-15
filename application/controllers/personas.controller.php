<?php
    namespace application\controllers;
    use library\kernel\Controller;
    use library\kernel\View;
    use library\plugin\Plugin;
    use application\models\Persona;
    
    class Personas extends Controller{
        private $persona = false;
        
        function __construct(){
            $this->persona = new Persona();
            $this->setTags('index', array('ANGELO','WORLD'));
        }
        
        function index(Plugin $plugin){
            $view = View::build('personas:index.php')
                ->setVariables('title', 'titolo')
                ->setVariables('pippo', 'SONO PERSONAS')
                ->setVariables('pluto', 'dsa');
            return ($view);
        }
    }