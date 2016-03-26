<?php
    namespace plugin\session;
    use plugin\db\DB;
    
    class SessionObject{
        // SESSION OBJECT UNDEFINED CONSTANTS
        const USERID_UNDEFINED = -1;
        const SID_UNDEFINED = -1;
        // SESSION OBJECT VARIABLES
        private $id = false;
        private $idUser = false;
        //private $token = false;
        
        // CONSTRUCTOR FUNCTION
        function __construct($sid = SessionObject::USERID_UNDEFINED, $uid = SessionObject::SID_UNDEFINED){
            $this->id = $sid;
            $this->idUser = $uid;
            //$token = hash("sha256", uniqid(mt_rand() . mt_rand(), true), false);
        }
        
        // GET FUNCTIONS
        public function getID(){
            return ($this->id);
        }
        public function getUserID(){
            return ($this->idUser);
        }
        
        // SET FUNCTIONS
        public function setID($id){
            $this->id = $id;
        }
        public function setUserID($id){
            $this->idUser = $id;
        }
        
        // LOAD AN OBJECT USING AN ARRAY
        public static function makeFromArray($arr){
            return (
                    new SessionObject(
                        $arr['id'],
                        $arr['idUser']
                    )
            );
        }
        // GENERATE AN ARRAY FROM THE OBJECT
        public function toArray(){
            return (
                    array(
                        'id' => $this->id,
                        'idUser' => $this->idUser
                    )
            );
        }
    }
    
    class Session{
        // SESSION CONSTANTS
        const DEFAULT_FWSESS_NAME = SESSION_DEFAULT_NAME;
        const DEFAULT_FWSESS_OBJ = SESSION_DEFAULT_NAME . '_obj';
        // DB VARIABLES
        private $dbLink = false;
        // SESSION VARIABLES
        private $sessionID = false;
        private $loggedUserID = false;
        
        function __construct(){
            // LINKING DATABASE RESOURCE
            $this->dbLink = DB::open(DBMODEL_SESSION);
        }
        function __destruct(){
            // CLOSE WRITING ON SESSION
            session_write_close();
        }
        
        public static function open(){
            if(SESSION_NEEDED){
                $session = (new Session())->start();
                
                var_dump2($_SESSION);
                var_dump2($_POST);
                
                /*
                $asd = $session->getDBSessionByUserID(1);
                var_dump2($asd);
                $session->setSession(SESSION_DEFAULT_NAME, $asd);
                $dsa = $session->getSession();
                var_dump2($dsa);
                $dsa2 = $dsa->toArray();
                var_dump2($dsa2);
                
                // VATTI A PRENDERE ID SESSIONE NEL DATABASE IN BASE ALL'ID UTENTE
                
                //$session->getDBSessionByUserID($session->getSession(SESSION_DEFAULT_NAME));
                
                //unset($session);
                //var_dump($session->setDBSession(17));
                //$this->setTemplate('todo',$session->getDBSession(17));
                */
                return ($session);
            }
            return (false);
        }
        
        // START SESSION
        private function start(){
            // START SESSION
            session_start();
            /*
            // CHECK LOGGED USER
            $this->checkLoggedUser();
            */
            return ($this);
        }
        
        
        // GET SESSION FROM DATABASE
        private function getDBSession($arr){
            if(count($arr)==1){
                return (SessionObject::makeFromArray($arr[0]));
            }
            return (false);
        }
        private function getDBSessionByID($id){
            $session = $this->dbLink
                            ->where('id', '=', $id)
                            ->get();
            return ($this->getDBSession($session));
        }
        private function getDBSessionByUserID($id){
            $session = $this->dbLink
                            ->where('idUser', '=', $id)
                            ->get();
            return ($this->getDBSession($session));
        }
        
        
        
        // SET SESSION INTO DATABASE
        private function setDBSession(SessionObject $obj, $isUserID = true){
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
        private function setDBSessionByID(SessionObject $obj){
            return ($this->dbLink
                    ->where('id', '=', $obj->getID())
                    ->insert($obj->arrayImplode()));
        }
        private function setDBSessionByUserID(SessionObject $obj){
            return ($this->dbLink
                    ->where('idUser', '=', $obj->getUserID())
                    ->insert($obj->arrayImplode()));
        }
        /*
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
        public function checkSession(){
            if(isset($_SESSION[DEFAULT_FWSESS_OBJ])){
                return true;
            }
            return false;
        }
        public function generateUniqueSessionID(){
            return (hash("sha256", uniqid(), false));
        }

        // SESSION ID FUNCTIONS
        public function setSessionID($sid){
            $this->sessionID = $sid;
            session_id($this->sessionID);
        }
        public function getSessionID($local = true){
            return ($local?$this->sessionID:session_id());
        }
        */
        
        // GET/SET SESSION
        public static function setSession($value, $key = Session::DEFAULT_FWSESS_OBJ){
            $_SESSION[$key] = $value;
        }
        public function getSession($key = Session::DEFAULT_FWSESS_OBJ){
            return ($this->isSessionSetted($key)?$_SESSION[$key]:false);
        }
        
        // GET/SET SESSION OBJECT
        public function setSessionObject($obj, $key = Session::DEFAULT_FWSESS_OBJ){
            if(is_array($obj)){
                $obj = SessionObject::makeFromArray($obj);
            }else if(!is_a($obj, 'SessionObject')){
                return false;
            }
            $this->setSession($obj, $key);
            return true;
        }
        public function getSessionObject($key = Session::DEFAULT_FWSESS_OBJ){
            return ($this->getSession($key));
        }
        
        // CHECK FUNCTIONS
        public function isSessionSetted($key = Session::DEFAULT_FWSESS_OBJ){
            return (array_key_exists($key, $_SESSION));
        }
        /*public function setNewSession($brute = false){
            if($this->isSessionSetted() && !$brute){
                return false;
            }
            $this->setSession(array());
            return true;
        }*/
        public function checkLoggedUser(){
            $session = $this->getSession();
            if($session !== false && is_a($session, 'SessionObject')){
                $userID = $session->getUserID();
                if($userID!=SessionObject::USERID_UNDEFINED){
                    // USER LOGGED IN
//echo "loggato<br />";
                    $res = $this->dbLink
                                ->setTable(SESSION_DATABASE_NAME . ' se')
                                ->join(USER_DATABASE_NAME . ' us', 'us.id', '=', 'se.idUser')
                                ->where('us.id', '=', $userID)
                                ->get();
                    switch(count($res)){
                        case 0:
                            // TIMEOUT
                        break;
                        case 1:
                            // UPDATE SESSION
                            $res = $res[0];
                            if(strcmp($session->getID(), $res['id'])==0){
//echo "loggato bene<br />";
                            }else{
//echo "loggato con errore<br />";
                            }
                        break;
                    }
var_dump2($res);
                    // CHECK IF SESSION IS EQUAL TO THE DATABASE ONE
                }else{
                    // USER NOT LOGGED IN
echo "non loggato<br />";
                }
            }else{
echo "sessione non esistente<br />";
                //$this->setNewSession();
                session_regenerate_id();
                $session = new SessionObject(session_id());
                $this->setSessionObject($session);
            }
var_dump2($_SESSION);
            //$this->closeSession();
        }
        
        
        // LOGIN FUNCTIONS
        public static function logout(){
            session_unset();
            session_destroy();
        }
        public function login(){
            // CHECK CREDENZIALI RESIDENTI NELLA CLASSE
        }
    }