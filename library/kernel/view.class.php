<?php
    namespace library\kernel;
    use plugin\file\File;
    use \Exception;
    
    class View{
        // VIEW-CONTEXT USABLE VARIABLES
        private $variables  = false;
        // VIEW VARIABLES
        private $fileBody   = false;
        private $fileHeader = false;
        private $fileFooter = false;
        
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
        private function getFilePath($viewPart){return ($this->{'file'.ucfirst($viewPart)}->getFullName());}
        
        // SET FUNCTIONS
        private function setFile($fileName){$this->fileBody = File::pathParse($fileName);}
        public function setVariables($key, $value){$this->variables[$key] = $value; return ($this);}
        
        public function setHeader($fileHeader){$this->fileHeader = File::pathParse($fileHeader);}
        public function setFooter($fileFooter){$this->fileFooter = File::pathParse($fileFooter);}
        
        // RENDER FUNCTIONS
        public function render(){
            extract($this->variables);
            
            // HEADER
            if($this->fileHeader !== false && file_exists($this->getFilePath('header'))){
                include_once($this->getFilePath('header'));
            }else if(file_exists(PATH_VIEW . 'header.php')){
                include(PATH_VIEW . 'header.php');
            }else{
                // DEFAULT HEADER PAGE IN STORAGE??
            }
            
            // ACTION
            if(file_exists($this->getFilePath('body'))){
                include($this->getFilePath('body'));
            }else{
                throw new Exception('View not found on path ' . $this->getFilePath('body'), 666);
            }
            
            // FOOTER
            if($this->fileFooter !== false && file_exists($this->getFilePath('footer'))){
                include_once($this->getFilePath('footer'));
            }else if(file_exists(PATH_VIEW . 'footer.php')){
                include(PATH_VIEW . 'footer.php');
            }else{
                // DEFAULT FOOTER PAGE IN STORAGE??
            }
        }
    }