<?php
    namespace plugin\auth;
    use plugin\db\DB;

    class Auth{
        // DB VARIABLES
        private $dbLink = false;
        private $requestType = false;
        private $parameters = false;
        
        function __construct(){
            // LINKING DATABASE RESOURCE
            $this->dbLink = DB::open(DBMODEL_USER);
        }
        
        private function getRequest(){
            $this->requestType = $_SERVER['REQUEST_METHOD'];
            switch($this->requestType){
                case 'GET':
                    if(isset($_GET['url'])){
                        unset($_GET['url']);
                    }
                    if(count($_GET)<1){
                        $this->requestType = false;
                    }else{
                        $this->parameters = $_GET;
                    }
                    break;
                case 'POST':
                    $this->parameters = $_POST;
                    break;
                default:
                    $this->requestType = false;
                    break;
            }
            
            echo "requestType: ";
            var_dump($this->requestType);
            echo "<br />params: ";
            var_dump($this->parameters);
        }
        
        public static function attempt($params = false){
            $auth = new Auth();
            if($params !== false && is_array($params)){
                
            }else{
                $auth->getRequest();
            }
            return (false);
        }
        
        public static function authPage(){
            
        }
    }