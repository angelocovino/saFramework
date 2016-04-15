<?php
    namespace library\request;
    use plugin\cookie\Cookie;
    use plugin\session\Session;
    
    class Request{
        // SUPPORT VARIABLES
        private static $isSet           = false;
        // VARIABLES
        private static $requestMethod   = false;
        private static $parameters      = false;
        private static $session         = false;
        private static $cookie          = false;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        public function __construct(){self::build();}
        
        // BUILD REQUEST FUNCTIONS
        private static function build(){
            if(!self::isSetted()){
                self::$requestMethod = $_SERVER['REQUEST_METHOD'];
                self::getRequest();
                if(SESSION_NEEDED === true){
                    self::$session = $_SESSION;
                }
                self::$cookie = $_COOKIE;
                self::$isSet = true;
            }
        }
        private static function isSetted(){return (self::$isSet !== false);}
        private static function getRequest(){
            switch(self::$requestMethod){
                case 'GET':
                    if(array_key_exists('url', $_GET)){
                        unset($_GET['url']);
                    }
                    self::$parameters = $_GET;
                    break;
                case 'POST':
                    self::$parameters = $_POST;
                    break;
            }
        }
        
        // GET FUNCTIONS
        public static function getMethod(){self::build(); return (self::$requestMethod);}
        public static function getCookie($name){self::build(); return (Cookie::get($name));}
        //public static function getSession($name){self::build(); return (Session::get($name));}
        public static function getParameters(){self::build(); return (self::$parameters);}
        public static function getInput($name){self::build();
            if(array_key_exists($name, self::$parameters)){
                return (self::$parameters[$name]);
            }
            return (false);
        }
    }