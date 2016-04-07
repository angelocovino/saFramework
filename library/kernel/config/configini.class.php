<?php
    namespace library\kernel\config;
    
    class ConfigINI extends Config{
        private $fullFileName = false;
        private $defaultFileName = false;
        // PARSE INI FILE VARIABLES
        private $sections       = false;
        private $scannerMode    = false;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        function __construct($fullFileName, $sections = false, $scannerMode = false){
            $this->fullFileName = $fullFileName;
            $this->sections = $sections;
            $this->scannerMode = $scannerMode;
        }
        
        // PARSE INI FILE FUNCTIONS
        public static function parseFile($fullFileName, $sections = false, $scannerMode = \INI_SCANNER_RAW){
            if(file_exists($fullFileName)){
                return (parse_ini_file($fullFileName, $sections, $scannerMode));
            }
            return (false);
        }
        
        // DEFINE CONFIG FUNCTIONS
        public function defineConfig(){
            if($this->sections == false){
                $this->defineSection($this->configs);
            }else if($this->sections == true){
                foreach($this->configs as $section => $value){
                    $this->defineSection($value);
                }
            }
            return ($this);
        }
        private function defineSection($section){
            foreach($section as $key => $value){
                $value = ($value == 'false')?false:(($value == 'true')?true:$value);
                define($key, $value);
            }
        }
        private function defineSectionCheckOrRedefine($sectionDefault){
            foreach($sectionDefault as $key => $value){
                $value = ($value == 'false')?false:(($value == 'true')?true:$value);
                defined($key) or define($key, $value);
            }
        }
        public function defineCheck($defaultFileName = false, $sections = false, $scannerMode = \INI_SCANNER_RAW){
            $this->defaultFileName = $defaultFileName;
            if(file_exists($defaultFileName)){
                $configs = parse_ini_file($defaultFileName, $sections, $scannerMode);
                $this->defineSectionCheckOrRedefine($configs);
                return (true);
            }
            return (false);
        }
    }