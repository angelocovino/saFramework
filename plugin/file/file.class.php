<?php
    namespace plugin\file;
    use \Exception;
    
    class File{
        const REGEXP_FILEFULLPATH   = '/^(%s*\:)?(%s*)\.([a-zA-Z]{3,4})$/';
        const REGEXP_INVALID_CHARS  = '[^\/\s]';
        private $path               = false;
        private $name               = false;
        private $extension          = false;
        private $exists             = false;
        private $fullName           = false;
        
        function __construct(){
        }
        public static function create(){
            return (new File());
        }
        private function doesItExists(){
            $this->exists = file_exists($this->fullName);
        }
        public function getExists(){return ($this->exists);}
        public function getName(){return ($this->name);}
        public function getPath(){return ($this->path);}
        public function getExtension(){return ($this->extension);}
        public function getFullName(){return ($this->fullName);}
        public static function pathParse($fileFullPath){
            $file = File::create();
            $regexp = sprintf(File::REGEXP_FILEFULLPATH, File::REGEXP_INVALID_CHARS, File::REGEXP_INVALID_CHARS);
            if(preg_match($regexp, $fileFullPath, $matches) != 0){
                $file->path = str_replace(':', DS, $matches[1]);
                $file->name = str_replace("\\", DS, $matches[2]);
                $file->extension = $matches[3];
            }else{
                throw new Exception('Invalid file path/name', 666);
            }
            $file->fullName = str_replace("\\", '/', PATH_VIEW . $file->path . $file->name . '.' . $file->extension);
            $file->doesItExists();
            return ($file);
        }
    }