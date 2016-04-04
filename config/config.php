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
        
        // CRYPTOGRAPHY CONSTANTS
        define('SECURITY_KEY', 'ASDF-SAD');