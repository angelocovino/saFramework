<?php
    namespace library\request;
    use plugin\cookie\Cookie;
    use plugin\session\Session;
    
    class Request{
        private static $isSet           = false;
        private static $requestMethod   = false;
        private static $parameters      = false;
        private static $session         = false;
        private static $cookie          = false;
        
        // BUILD REQUEST FUNCTIONS
        private static function build(){
            if(!self::isSetted()){
                self::$requestMethod = $_SERVER['REQUEST_METHOD'];
                self::getRequest();
                if(SESSION_NEEDED === true){
                    self::$session = $_SESSION;
                }
                self::$cookie = $_COOKIE;
            }
        }
        private static function isSetted(){
            if(self::$isSet !== false){
                return (true);
            }
            return (false);
        }
        private static function getRequest(){
            switch(Request::$requestMethod){
                case 'GET':
                    if(isset($_GET['url'])){
                        unset($_GET['url']);
                    }
                    Request::$parameters = $_GET;
                    break;
                case 'POST':
                    Request::$parameters = $_POST;
                    break;
            }
        }
        
        // GET FUNCTIONS
        public static function getMethod(){
            Request::build();
            return (Request::$requestMethod);
        }
        public static function getCookie($name){
            Request::build();
            return (Cookie::get($name));
        }
        /*public static function getSession($name){
            Request::build();
            Session::get($name);
        }*/
        public static function getInput($name){
            Request::build();
            if(isset(Request::$parameters[$name])){
                return (Request::$parameters[$name]);
            }
            return (false);
        }
    }