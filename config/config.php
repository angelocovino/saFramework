<?php
	// CONFIGURATION CONSTANTS
		// DEVELOPMENT ENVIRONMENT CONSTANTS
		define('DEVELOPMENT_ENVIRONMENT', true);
        
        // SESSION CONSTANTS
		define('SESSION_NEEDED', true);
		define('SESSION_DEFAULT_NAME', 'saFW');
		
        // DATABASE MODEL CONSTANTS
		define('DBMODEL_SESSION', 'session');
		define('DBMODEL_USER', 'user');
        
		// DATABASE CONSTANTS
		define('DB_HOST', 'localhost');
		define('DB_USER', 'root');
		define('DB_PASSWORD', '');
		define('DB_NAME', 'prove');
        
		// PATH CONSTANTS
		define('PATH_ROOT', ROOT . DS);
		define('PATH_LIBRARY', PATH_ROOT . 'library' . DS);
		define('PATH_APPLICATION', PATH_ROOT . 'application' . DS);
            define('PATH_CONTROLLERS', PATH_APPLICATION . 'controllers' . DS);
            define('PATH_MODELS', PATH_APPLICATION . 'models' . DS);
            define('PATH_VIEW', PATH_APPLICATION . 'views' . DS);
        
        // CALL BUILDER CONSTANTS
        define('BUILDER_URL_ERROR', 100);
        define('BUILDER_OK', 101);
        define('BUILDER_CONTROLLER_ERROR', 102);
        define('BUILDER_ACTION_ERROR', 103);

        // CRYPTOGRAPHY DEFINE
        define('ENCODE_METHOD',"AES-256-CBC");
        define('FIRST_KEY_START', 0);
        define('SECOND_KEY_START', 64);
        define('SECURITY_KEY','ASDF-SAD');