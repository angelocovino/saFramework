<?php

    class Auth{
        // DB VARIABLES
        private $dbLink = false;
        
        function __construct(){
            // LINKING DATABASE RESOURCE
            $this->dbLink = DB::open(DBMODEL_USER);
        }
        
        public static function attempt($arr){
            if(!is_array($arr)){
                return false;
            }
            $auth = new Auth();
        }
        
        public static function authPage(){
            
        }
    }