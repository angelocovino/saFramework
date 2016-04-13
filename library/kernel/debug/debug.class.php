<?php
    namespace library\kernel\debug;
    
    abstract class Debug{
        // CATCH UNCAUGHT EXCEPTIONS USING set_exception_handler
        public static function uncaughtException($exception){
            ?>
            <html>
                <body>
                    <h2>ERROR</h2>
                    <b>[MESSAGE]</b> <?php echo $exception->getMessage(); ?><br />
                    <b>[CODE]</b> <?php echo $exception->getCode(); ?><br />
                </body>
            </html>
            <?php
            //var_dump2($exception);
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
            error_log('', 3, PATH_STORAGE_LOGS . 'error.log');
        }
        
        /**
         * DEVELOPMENT ENVIRONMENT AND ERROR REPORTING
         */
        public static function setReporting(){
            if(DEVELOPMENT_ENVIRONMENT === true){
                ini_set('error_reporting', E_ALL & E_STRICT & E_RECOVERABLE_ERROR);
                ini_set('display_errors', 'On');
            }else{
                ini_set('error_reporting', 0);
                ini_set('display_errors', 'Off');
            }
            // SET LOGS DIRECTORY
            ini_set('log_errors', 'On');
            ini_set('error_log', PATH_STORAGE_LOGS . 'error.log');
            // SET EXCEPTION HANDLER
            set_exception_handler(NAMESPACE_KERNEL_DEBUG . 'Debug::uncaughtException');
            register_shutdown_function(NAMESPACE_KERNEL_DEBUG . 'Debug::uncaughtError');
            
            //set_error_handler(NAMESPACE_KERNEL_DEBUG . 'Debug::uncaughtError');
        }
    }