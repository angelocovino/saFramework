<?php
    namespace plugin\session;
    use plugin\db\DB;
    
    class Session{
        // DB VARIABLES
        private $dbLink         = false;
        // SESSION VARIABLES
        private static $isOpen   = false;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        private function __construct(){}
        public function __destruct(){}
        
        // OPEN/CLOSE/DESTROY SESSION
        public static function open($writing = true){
            if(SESSION_NEEDED){
                return ((new Session())->start());
            }
            if($writing === false){
                self::$close();
            }
            return (false);
        }
        public static function close(){
            // CLOSE WRITING ON SESSION
            session_write_close();
        }
        public static function destroy(){
            session_unset();
            session_destroy();
        }

        // START SESSION
        private function start(){
            // START SESSION
            if(!(self::$isOpen)){
                session_start();
                self::$isOpen=true;
                //$this->dbLink=DB::open(session);
            }
            return ($this);
        }

        // SESSION ID FUNCTIONS
        public function setSID($sid){session_id($sid);}
        public function getSID(){return (session_id());}

        public function setDBLink($dbLink){$this->dbLink = $dbLink;}
        public function getDBLink(){return ($this->dbLink);}

        // SESSION MANIPULATION
        public static function set($key, $value){
            if(func_num_args()>2){
                $args = func_get_args();
                $temp = &$_SESSION[$key];
                for($i=2; $i<func_num_args(); $i++){
                    $temp = &$temp[$args[$i]];
                }
                $temp = $value;
            }else{
                $_SESSION[$key] = $value;
            }
            /*
            preg_match_all("^(.*?)\[(.*?)\]^", $key, $subArrays, PREG_PATTERN_ORDER);
            if(is_array($subArrays) && !empty($subArrays[2])){
                var_dump2($subArrays);
            }
            $_SESSION[$key] = $value;
            {'$_SESSION[' . $key . ']'} = $value;
            */
        }
        public static function get($key){return (self::keyExists($key)?$_SESSION[$key]:false);}
        public static function remove($key){
            if(self::keyExists($key)){
                unset($_SESSION[$key]);
                return true;
            }
            return false;
        }
        public static function keyExists($key){return (array_key_exists($key, $_SESSION));}
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
            return ((strcmp($sid1, $sid2)==0)?true:false);
        }

        public function generateUniqueSessionID(){
            return (hash("sha256", uniqid(), false));
        }*/
