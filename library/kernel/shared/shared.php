<?php
    /**
     * PREVENT SESSIONS FROM HIJACKING
     */
    function preventHijacking(){
        ini_set('session.use_only_cookies', true);				
        ini_set('session.use_trans_sid', false);
    }
    
    /** 
     * REMOVE SLASHES
     * @param $value BEFORE STRIP SLASHES
     * @return $value AFTER STRIP SLASHES
     */
    function stripSlashesDeep($value){
        $value = is_array($value)?array_map('stripSlashesDeep', $value): stripslashes($value);
        return $value;
    }
    
    /**
     * CHECK MAGIC QUOTES AND THEN REMOVE THEM
     */
    function removeMagicQuotes(){
        if(get_magic_quotes_gpc()){
            $_GET = stripSlashesDeep($_GET);
            $_POST = stripSlashesDeep($_POST);
            $_COOKIE = stripSlashesDeep($_COOKIE);
        }
    }
    
    /**
     * UNSET REGISTER GLOBALS CHECKING PHP.INI
     * FROM DOCUMENTATION:
     * Please note that register_globals cannot be set at runtime (ini_set()).
     */
    function unsetRegisterGlobals(){
        if(ini_get('register_globals')){
            $array = array(
                '_SESSION',
                '_POST',
                '_GET',
                '_COOKIE',
                '_REQUEST',
                '_SERVER',
                '_ENV',
                '_FILES'
            );
            foreach($array as $value){
                foreach($GLOBALS[$value] as $key => $var){
                    if($var === $GLOBALS[$key]){
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }