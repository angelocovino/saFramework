<?php
    namespace library\kernel\config;
    use library\kernel\config\ConfigINI;
    
    class Config{
        // CONFIGURATION VARIABLES
        protected $fullFileName   = false;
        protected $configs        = false;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        function __construct($fullFileName){
            $this->fullFileName = $fullFileName;
        }
        
        // SET FUNCTIONS
        public function setConfigArray($configs){$this->configs = $configs;}
        
        // PARSE INI FILE FUNCTIONS
        public static function parseINIFile($fullFileName, $sections = false, $scannerMode = \INI_SCANNER_RAW){
            $config = new ConfigINI($fullFileName, $sections, $scannerMode);
            $config->setConfigArray(parse_ini_file($fullFileName, $sections, $scannerMode));
            return ($config);
        }
    }