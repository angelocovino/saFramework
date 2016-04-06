<?php
    namespace library\kernel;
    use plugin\file\File;
    
    class View{
        // VIEW-CONTEXT USABLE VARIABLES
        private $variables = false;
        // VIEW VARIABLES
        private $fileObj = false;
        
        // CONSTRUCT AND DESTRUCT VARIABLES
        function __construct($fileName){
            $this->setFile($fileName);
            $this->variables = array(); 
        }
        
        public static function build($fileName){
            return (new View($fileName));
        }
        
        private function getFileName(){return ($this->fileObj->getFullName());}
        
        private function setFile($fileName){
            $fileObj = File::pathParse($fileName);
            $this->fileObj = $fileObj;
        }
        public function setVariables($key, $value){$this->variables[$key] = $value; return ($this);}
        
        public function render(){
            extract($this->variables);
            include(PATH_VIEW . 'header.php');
            include($this->getFileName());
        }
    }