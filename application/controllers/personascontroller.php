<?php
    namespace application\controllers;
    use library\kernel\Controller;
    use library\kernel\View;
    use application\models\Persona;
    
    class PersonasController extends Controller{
        private $persona = false;
        
        function __construct(){
            $this->persona = new Persona();
            $this->setTags('index', array('ANGELO','WORLD'));
        }
        
        function index($plugins, $a = false, $b = false){
            $cookie = $plugins['cookie'];
            //$cookie = PLUGIN_COOKIE;
            //$cookie = 'plugin\cookie\Cookie';
            if($cookie::get('prova') === false){
                $cookie::set('prova','valoreprova', time()+5);
            }
            $view = View::build('personas:index.php')
                ->setVariables('title', 'titolo')
                ->setVariables('pippo', 'SONO PERSONAS')
                ->setVariables('pluto', 'dsa');
            return ($view);
        }
    }