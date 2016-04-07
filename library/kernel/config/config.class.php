<?php
    namespace library\kernel\config;
    use library\kernel\config\ConfigINI;
    
    abstract class Config{
        // CONFIGURATION VARIABLES
        protected $configs  = false;
        
        // SET FUNCTIONS
        public function setConfigArray($configs){$this->configs = $configs;}
        
        // PARSE INI FILE FUNCTIONS
        public static function parseINIFile($fullFileName, $sections = false, $scannerMode = \INI_SCANNER_RAW){
            $config = new ConfigINI($fullFileName, $sections, $scannerMode);
            $config->setConfigArray($config->parseFile($fullFileName, $sections, $scannerMode));
            return ($config);
        }
    }