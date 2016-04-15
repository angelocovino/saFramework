<?php
    namespace plugin\session;
    use plugin\session\SessionObject;
    use plugin\db\DB;

     class Session{
        // DB VARIABLES
        private $dbLink = false;
        // SESSION VARIABLES
        private $sessionID = false;
        private static $alive=false;
        
         private function __construct(){
             
         }
        function __destruct(){
            // CLOSE WRITING ON SESSION
            session_write_close();
        }
        
        public static function open(){
            if(SESSION_NEEDED){
                $session = (new Session())->start();
                return ($session);
            }
            return (false);
        }
        
        // START SESSION
        private function start(){
            // START SESSION
            if(!(self::$alive)){
                session_start();
                self::$alive=true;
                $this->sessionID=session_id();
                //$this->dbLink=DB::open(session);
            }
            return $this;
        }
        
        // SESSION ID FUNCTIONS
        public function setID($sid){
            $this->sessionID = $sid;
            session_id($this->sessionID);
        }
        public function getID($local = true){
            return ($local?$this->sessionID:session_id());
        }
         
        public function setDbLink($table){
            $this->dbLink=$table;
        }
        
        public function getDblink(){
            return $this->dbLink;
        }
        
        public function display(){
            var_dump2($this);
        }
        
        // GET/SET SESSION
        public static function set($value, $key){
            $_SESSION[$key] = $value;
        }
        public function get($key){
            return ($this->isSetted($key)?$_SESSION[$key]:false);
        }
         
        public static function remove($key){
            if(self::isSetted($key)){
                unset($_SESSION[$key]);
                return true;
            }
            return false;
    
        }
         
        // CHECK FUNCTIONS
        public static function isSetted($key){
            return (array_key_exists($key, $_SESSION));
        }
        
        public function check(){
            return self::$alive;
        }
         
         
        // LOGIN FUNCTIONS
        public static function close(){
            session_unset();
            session_destroy();
        }
        
    }

/*
        // GET SESSION FROM DATABASE
        private function getDB($arr){
            if(count($arr)==1){
                return (SessionObject::makeFromArray($arr[0]));
            }
            return (false);
        }
        
        private function getDBByID($id){
            $session = $this->dbLink
                            ->where('id', '=', $id)
                            ->get();
            return ($this->getDBSession($session));
        }
        private function getDBByUserID($id){
            $session = $this->dbLink
                            ->where('idUser', '=', $id)
                            ->get();
            return ($this->getDBSession($session));
        }
        
        
        
        // SET SESSION INTO DATABASE
        private function setDB(SessionObject $obj, $isUserID = true){
            // CHECK FOR SAME ID
            $session = $this->getDBSessionByID($obj->getID());
            if($session !== false){
                // SAME SESSION ID, SET A NEW SESSION ID AT THE OBJECT
                $obj->setID($this->generateUniqueSessionID());
                // RETURN THE SAME FUNCTION WITH MODIFIED OBJECT
                return $this->setDBSession($obj, $isUserID);
            }
            $session = $this->dbLink
                            ->where('idUser', '=', $obj->getUserID())
                            ->get();
            $resCount = count($session);
            if($isUserID){
                $column = 'idUser';
                $columnValue = $obj->getUserID();
            }else{
                $column = 'id';
                $columnValue = $obj->getID();
            }
            if($resCount==0){
                $this->dbLink
                    ->where($column, '=', $columnValue)
                    ->insert($obj->arrayImplode());
            }else if($resCount==1){
                $this->dbLink
                    ->where($column, '=', $columnValue)
                    ->update($obj->arrayImplode());
            }else{
                $this->dbLink
                    ->where($column, '=', $columnValue)
                    ->update($obj->arrayImplode());
            }
        }
        private function setDBByID(SessionObject $obj){
            return ($this->dbLink
                    ->where('id', '=', $obj->getID())
                    ->insert($obj->arrayImplode()));
        }
        private function setDBByUserID(SessionObject $obj){
            return ($this->dbLink
                    ->where('idUser', '=', $obj->getUserID())
                    ->insert($obj->arrayImplode()));
        }
        
        public function setDBSessionByUserID($id){
            return ($this->dbLink
                    ->insert(['id' => $id, 'dateCreated' => date('Y-m-d H:i:s')]));
        }
        
        
        public function compareSessions($sid1, $sid2){
            if(strcmp($sid1, $sid2)==0){
                return true;
            }
            return false;
        }

        public function generateUniqueSessionID(){
            return (hash("sha256", uniqid(), false));
        }
*/