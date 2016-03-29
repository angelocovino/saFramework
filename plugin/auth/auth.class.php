<?php
    namespace plugin\auth;
    use plugin\db\DB;

    class Auth{
        // DB VARIABLES
        private $modelName = DBMODEL_USER;
        private $dbLink = false;
        // AUTH VARIABLES
        private $requestType = false;
        private $parameters = false;
        
        // COSTRUCT AND DESTRUCT FUNCTIONS
        function __construct(){
            // LINKING DATABASE RESOURCE
            $this->dbLink = DB::open($this->getModelName());
        }
        
        // SET AND GET FUNCTIONS
        public function setRequestType($requestType){$this->requestType = $requestType;}
        public function getRequestType(){return ($this->requestType);}
        public function setParameters($parameters){$this->parameters = $parameters;}
        public function getParameters(){return ($this->parameters);}
        public function setModelName($modelName){$this->modelName = $modelName;}
        public function getModelName(){return ($this->modelName);}
        
        
        private function getRequest(){
            switch($_SERVER['REQUEST_METHOD']){
                case 'GET':
                    if(isset($_GET['url'])){
                        unset($_GET['url']);
                    }
                    if(count($_GET)>0){
                        $this->parameters = $_GET;
                    }
                    break;
                case 'POST':
                    $this->parameters = $_POST;
                    break;
            }
            if($this->getParameters() !== false){
                $this->setRequestType($_SERVER['REQUEST_METHOD']);
            }
            
            echo "requestType: ";
            var_dump($this->getRequestType());
            echo "<br />params: ";
            var_dump($this->getParameters());
        }
        
        public static function attempt($params = false){
            $auth = new Auth();
            if($params !== false && is_array($params)){
                $auth->setParameters($params);
            }else{
                $auth->getRequest();
            }
            return (false);
        }
    }