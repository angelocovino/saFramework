<?php
    namespace library\kernel\config;
    
    class ConfigINI extends Config{
        // PARSE INI FILE VARIABLES
        private $sections       = false;
        private $scannerMode    = false;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        function __construct($fullFileName, $sections = false, $scannerMode = false){
            parent::__construct($fullFileName);
            $this->sections = $sections;
            $this->scannerMode = $scannerMode;
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
        }
        private function defineSection($section){
            foreach($section as $key => $value){
                $value = ($value == 'false')?false:(($value == 'true')?true:$value);
                define($key, $value);
            }
        }
    }