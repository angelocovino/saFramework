<?php
	// CONFIGURATION CONSTANTS
		// DEVELOPMENT ENVIRONMENT CONSTANTS
		define('DEVELOPMENT_ENVIRONMENT', true);
        
        // SESSION CONSTANTS
		define('SESSION_NEEDED', true);
		define('SESSION_DEFAULT_NAME', 'saFW');
		
		// DATABASE CONSTANTS
			// DATABASE MODEL CONSTANTS
			define('DBMODEL_SESSION', 'session');
			define('DBMODEL_USER', 'user');
			
			// DATABASE TYPE 
			define('DBTYPE','mysql');
			
			// DATABASE CCREDENTIALS
			require_once('config.personal.php');
        
        // CALL BUILDER CONSTANTS
        define('BUILDER_URL_ERROR', 100);
        define('BUILDER_OK', 101);
        define('BUILDER_CONTROLLER_ERROR', 102);
        define('BUILDER_ACTION_ERROR', 103);
        
        // CRYPTOGRAPHY DEFINE
        define('SECURITY_KEY', 'ASDF-SAD');