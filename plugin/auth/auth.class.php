<?php
    namespace plugin\auth;
    use plugin\db\DB;
    use \Exception;

    class Auth{
        // DB VARIABLES
        private $dbLink = false;
        private $modelName = DBMODEL_USER;
        // AUTH VARIABLES
        private $requestType = false;
        private $parameters = false;
        
        // DATABASE CONNECTION
        private function dbLinkOpen(){
            // LINKING DATABASE RESOURCE
            $this->dbLink = DB::open($this->modelName);
        }
        
        // SET FUNCTIONS
        public function setRequestType($requestType){$this->requestType = $requestType;}
        public function setParameters($parameters){$this->parameters = $parameters;}
        public function setModelName($modelName){$this->modelName = $modelName;}
        
        // GET FUNCTIONS
        public function getRequestType(){return ($this->requestType);}
        public function getParameters(){return ($this->parameters);}
        public function getModelName(){return ($this->modelName);}
        
        private function getRequest(){
            switch($_SERVER['REQUEST_METHOD']){
                case 'GET':
                    if(isset($_GET['url'])){
                        unset($_GET['url']);
                    }
                    if(count($_GET)>0){
                        $this->setParameters((count($_GET)>0)?$_GET:false);
                    }
                    break;
                case 'POST':
                    $this->setParameters((count($_POST)>0)?$_POST:false);
                    break;
            }
            if($this->getParameters() !== false){
                $this->setRequestType($_SERVER['REQUEST_METHOD']);
                return (true);
            }
            return (false);
        }
        
        private function checkAuth(){
            if($this->getParameters() !== false){
                $array_keys = array_keys($this->getParameters());
                $array_values = array_values($this->getParameters());
                $this->dbLinkOpen();
// ##############################################################################
                $table = $this->dbLink->getTableStructure($this->getModelName());
                $columns = array();
                foreach($table as $column){
                    $columns[] = $column['Field'];
                }
                foreach($this->parameters as $column => $value){
                    if(!in_array($column, $columns)){
                        unset($this->parameters[$column]);
                    }
                }
                $array_keys = array_keys($this->getParameters());
// ##############################################################################
                $db = $this->dbLink
                    ->select(implode(', ', $array_keys))
                    ->get()
                    ;
//var_dump2($db);
                return $this->checkParams($db);
            }
            return (false);
        }
        private function checkParams($params){
            $paramsExt = $this->getParameters();
            foreach($params as $line){
                foreach($line as $column => $value){
                    if($line[$column] != $paramsExt[$column]){
                        return (false);
                    }
                }
            }
            return (true);
        }
        public static function attempt($params, $modelName = false){
            $auth = new Auth();
            if($modelName !== false){
                $auth->setModelName($modelName);
            }
            if($params !== false && is_array($params)){
                $auth->setParameters($params);
            }
            /*
            else if(!$auth->getRequest()){
                throw new Exception('Auth needs a Parameters Array or a not empty Request Method', 666);
            }
            */
            return ($auth->checkAuth());
        }
    }