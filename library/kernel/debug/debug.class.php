<?php
    namespace library\kernel\debug;
    
    abstract class Debug{
        // CATCH UNCAUGHT EXCEPTIONS USING set_exception_handler
        public static function uncaughtException($exception){
            echo $exception->getMessage();
        }
        public static function uncaughtError(){
            $error = error_get_last();
            if($error !== NULL){
                Debug::uncaughtFatalError($error);
            }
        }
        public static function uncaughtFatalError($error){
            $errno   = $error["type"];
            $errfile = $error["file"];
            $errline = $error["line"];
            $errstr  = $error["message"];
            var_dump2($error);
            //error_log('', 3, PATH_STORAGE_LOGS . 'error.log');
        }
    }