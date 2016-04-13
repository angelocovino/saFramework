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
        
        // BUILD FUNCTIONS
        public static function build($fileName){
            return (new View($fileName));
        }
        
        // GET FUNCTIONS
        private function getFileName(){return ($this->fileObj->getFullName());}
        
        // SET FUNCTIONS
        private function setFile($fileName){$this->fileObj = File::pathParse($fileName);}
        public function setVariables($key, $value){$this->variables[$key] = $value; return ($this);}
        
        // RENDER FUNCTIONS
        public function render(){
            extract($this->variables);
            include(PATH_VIEW . 'header.php');
            include($this->getFileName());
        }
    }