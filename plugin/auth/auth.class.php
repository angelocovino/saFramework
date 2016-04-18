<?php
    namespace plugin\auth;
    use library\request\Request;
    use plugin\session\Session;
    use plugin\cryptography\Cryptography;
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
        private function dbLinkOpen(){$this->dbLink = DB::_open($this->modelName);}
        
        // SET FUNCTIONS
        private function setModelName($modelName){$this->modelName = $modelName;}
        private function setParameters($parameters){$this->parameters = $parameters;}
        
        // GET FUNCTIONS
        private function getModelName(){return ($this->modelName);}
        private function getParameters(){return ($this->parameters);}
        private function checkAuth(){
            if($this->getParameters() !== false){
// ##############################################################################
                $table = $this->dbLink->_getTableStructure($this->getModelName());
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
                return ($this->checkDB(implode(', ', array_keys($this->getParameters()))));
            }
            return (false);
        }
        private function checkDB($arrayColumns){
            $db = $this->dbLink
                ->_select($arrayColumns)
                ->whereArray($this->getParameters())
                ->get();
            if(is_array($db)){
                if(count($db)==1){
                    $this->credentials = $db;
                    return (true);
                }else{
                    throw new Exception(count($db) . ' occurrences found in Database for these credentials', 666);
                }
            }
            throw new Exception('No occurrences found in Database for these credentials', 666);
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
            $val = array();
            foreach($this->credentials[0] as $name => $value){
                $val[] = $name.':'.$value;
            }
            $val = implode(';', $val);
            $val = Cryptography::encode($val);
            Session::set('fwLGN', $val);
        }
        public static function logout(){
            Session::destroy();
        }
        public static function check($modelName = DBMODEL_USER){
            if(Session::keyExists('fwLGN')){
                $auth = new Auth($modelName);
                $val = Cryptography::decode(Session::get('fwLGN'));
                $val = explode(';', $val);
                $asd = array();
                foreach($val as $valore){
                    $temp = explode(':', $valore);
                    $asd[$temp[0]] = $temp[1];
                }
                $auth->setParameters($asd);
                if($auth->checkDB($auth->checkDB(implode(', ', array_keys($auth->getParameters()))))){
                    return (true);
                }
            }
            self::logout();
            return (false);
        }
    }