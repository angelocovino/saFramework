<?php
    namespace plugin\csrf;
    use plugin\token\Token;
    use plugin\cookie\Cookie;
    
    abstract class CSRF{
        public static function check(){
            $cookie = Cookie::get(CSRF_COOKIE_NAME);
            if($cookie !== false){
                // GET REQUEST
                // CHECK POST
            }
        }
        public static function generate(){
            $token = Token::generate();
            return ($token);
        }
    }