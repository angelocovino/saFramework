<?php
    namespace library\kernel\config;
    use library\kernel\config\ConfigINI;
    
    abstract class Config{
        // CONFIGURATION VARIABLES
        protected $configs  = false;
        
        // SET FUNCTIONS
        public function setConfigs($configs){$this->configs = $configs;}
        
        // GET FUNCTIONS
        public function getConfigs($section = false){
            if($section !== false){
                if(isset($this->configs[strtoupper($section)])){
                    return ($this->configs[strtoupper($section)]);
                }
                return (false);
            }
            return ($this->configs);
        }
        
        // PARSE INI FILE FUNCTIONS
        public static function parseINIFile($fullFileName, $sections = false, $scannerMode = \INI_SCANNER_RAW){
            $config = new ConfigINI($fullFileName, $sections, $scannerMode);
            $config->setConfigs($config->parseFile($fullFileName, $sections, $scannerMode));
            //var_dump2($config->configs);
            return ($config);
        }
    }