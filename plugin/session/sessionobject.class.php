<?php
    namespace plugin\session;
    
    class SessionObject{
                // SESSION CONSTANTS
        const DEFAULT_FWSESS_NAME = SESSION_DEFAULT_NAME;
        const DEFAULT_FWSESS_OBJ = SESSION_DEFAULT_NAME . '_obj';
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