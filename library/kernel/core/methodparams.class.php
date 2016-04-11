<?php
    namespace library\kernel\core;
    use \ReflectionMethod;
    
    class MethodParams{
        // VARIABLES
        private $name = false;
        private $isOptional = false;
        private $defaultValue = false;
        // COUNT VARIABLES
        private $countParams = 0;
        private $countOptionalParams = 0;
        private $countNecessaryParams = 0;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        private function __construct($class, $method){
            $ref = new ReflectionMethod($class, $method);
            $parameters = $ref->getParameters();
            // SETTING UP NUMBER OF PARAMETERS
            if(($this->countParams = count($parameters))>0){
                $this->name = array();
                $this->isOptional = array();
                $this->defaultValue = array();
            }
            foreach($parameters as $index => $param) {
                // SETTING UP PARAMETER NAME
                $this->name[$index] = $param->getName();
                if($param->isOptional()){
                    $this->countOptionalParams++;
                    $this->isOptional[$index] = true;
                    $this->defaultValue[$index] = $param->getDefaultValue();
                }else{
                    $this->isOptional[$index] = false;
                }
            }
            $this->countNecessaryParams = $this->countParams - $this->countOptionalParams;
        }
        
        // BUILD CLASS FUNCTIONS
        public static function build($class, $method){
            return (new MethodParams($class, $method));
        }
        
        //public function nameExists($name){return (in_array($name, $this->name));}
        public function getNameIndex($name){return (array_search($name, $this->name));}
        public function getIndexName($index){return ($this->name[$index]);}
        public function isOptional($index){return ($this->isOptional[$index]);}
        public function getDefault($index){return ($this->defaultValue[$index]);}
        public function getCount(){return ($this->countParams);}
        public function getCountNecessary(){return ($this->countNecessaryParams);}
        public function getCountOptional(){return ($this->countOptionalParams);}
    }