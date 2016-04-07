<?php
    namespace application\controllers;
    use library\kernel\Controller;
    use library\kernel\View;
    use application\models\Persona;
    //use plugin\cookie\Cookie;
    
    class PersonasController extends Controller{
        private $persona = false;
        //protected $cookie = 'plugin\cookie\Cookie';
        
        function __construct(){
            $this->persona = new Persona();
        }
        
        function index(){
            $cookie = PLUGIN_COOKIE;
            $asd = new ${cookie}();
            //$cookie = getPlugin();
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