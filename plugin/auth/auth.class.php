<?php
    namespace plugin\auth;
    use library\request\Request;
    use plugin\db\DB;
    use \Exception;

    class Auth{
        // VARIABLES
        private $parameters  = false;
        // DB VARIABLES
        private $dbLink      = false;
        private $modelName   = false;
        //CREDENTIAL VARIABLES
        private $credentials = false;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        private function __construct($modelName){
            $this->setModelName($modelName);
            $this->dbLinkOpen();
        }
        
        // DATABASE CONNECTION
        private function dbLinkOpen(){$this->dbLink = DB::open($this->modelName);}
        
        // SET FUNCTIONS
        private function setModelName($modelName){$this->modelName = $modelName;}
        private function setParameters($parameters){$this->parameters = $parameters;}
        
        // GET FUNCTIONS
        private function getModelName(){return ($this->modelName);}
        private function getParameters(){return ($this->parameters);}
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
// ##############################################################################
                $db = $this->dbLink
                    ->select(implode(', ', $array_keys))
                    ->whereArray($this->getParameters())
                    ->get()
                    ;
                if(is_array($db) && (count($db)==1)){
                    $this->credentials = $db;
                    return (true);
                }
            }
            return (false);
        }
        public static function attempt($params = false, $modelName = DBMODEL_USER, Auth $auth = null){
            if($auth === null){
                $auth = new Auth($modelName);
            }else if(!($auth instanceof Auth)){
                throw new Exception('Wrong parameters, Auth instance required or less parameters', 666);
            }
            if($params === false){
                $auth->setParameters(Request::getParameters());
            }else if(is_array($params) && (count($params)>0)){
                $auth->setParameters($params);
            }else{
                throw new Exception('Auth needs an Array Key/Value as Parameters, or no parameters', 666);
            }
            return ($auth->checkAuth());
        }
        public static function login($params = false, $modelName = DBMODEL_USER){
            $auth = new Auth($modelName);
            if(self::attempt($params, $modelName, $auth)){
                $auth->doLogin();
            }else{
                // LOGIN FAILED, WHAT REDIRECT PAGE??
            }
        }
        private function doLogin(){
            foreach($this->credentials[0] as $name => $value){
                Session::set($value, $name);
            }
        }
        public static function logout(){
            Session::destroy();
        }
    }