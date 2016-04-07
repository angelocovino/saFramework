<?php
    namespace plugin\cookie;
    
    abstract class Cookie{
        // CONSTANTS
        const COOKIE_EXPIRE_TIME = 60*60*24;
        
        // SET COOKIE FUNCTIONS
        public static function set($name, $value = '', $expire = Cookie::COOKIE_EXPIRE_TIME, $path = '/', $domain = '', $secure = false, $httpOnly = false){
            $res = setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
            if($res === true){
                $_COOKIE[$name] = $value;
            }
            return ($res);
        }
        // GET COOKIE FUNCTIONS
        public static function get($name){
            if(isset($_COOKIE[$name])){
                return ($_COOKIE[$name]);
            }
            return (false);
        }
        
        // DELETE COOKIE FUNCTIONS
        public static function delete($name){
            if(isset($_COOKIE[$name])){
                setcookie($name,'',time()-1);
                unset($_COOKIE[$name]);
                return (true);
            }
            return (false);
        }
    }