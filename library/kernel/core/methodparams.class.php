<?php
    namespace library\kernel\core;
    use \ReflectionMethod;
    use \Exception;
    
    class MethodParams{
        // VARIABLES
        private $name = false;
        private $isOptional = false;
        private $defaultValue = false;
        private $classFullName = false;
        private $className = false;
        private $classNameCount = false;
        private $classOccurencies = false;
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
                $this->classFullName = array();
                $this->className = array();
                $this->classNameCount = array();
            }
            foreach($parameters as $index => $param) {
                // SETTING UP PARAMETER NAME
                $this->name[$index] = $param->getName();
                //if($param->isOptional()){
                if(!is_null($param->getClass())){
                    $this->classFullName[$index] = $param->getClass()->name;
                    $this->className[$index] = getClassFromNamespace($this->classFullName[$index]);
                    if(!isset($this->classNameCount[$this->className[$index]])){
                        $this->classNameCount[$this->className[$index]] = 0;
                    }
                    if(!isset($this->classOccurencies[$this->className[$index]])){
                        $this->classOccurencies[$this->className[$index]] = array();
                    }
                    $this->classOccurencies[$this->className[$index]][$index] = $index;
                    $this->classNameCount[$this->className[$index]]++;
                }
                if($param->isDefaultValueAvailable()){
                    $this->countOptionalParams++;
                    $this->isOptional[$index] = true;
                $this->defaultValue[$index] = $param->getDefaultValue();
                    //$this->defaultValue[$index] = $param->getDefaultValue();
                }else{
                    $this->isOptional[$index] = false;
                }
                
                /*
                try{
                    $this->defaultValue[$index] = $param->getDefaultValue();
                }catch(\ReflectionException $e){
                    //var_dump2($e);
                }*/
            }
            $this->countNecessaryParams = $this->countParams - $this->countOptionalParams;
        }
        
        // BUILD CLASS FUNCTIONS
        public static function build($class, $method){
            return (new MethodParams($class, $method));
        }
        
        // OTHER FUNCTIONS
        public function removeParams($params){
            if(is_array($params)){
                foreach($params as $key => $param){
                    if(
                        is_array($this->classOccurencies) &&
                        isset($this->classOccurencies[$param])
                    ){
                        foreach($this->classOccurencies[$param] as $index){
                            if($this->isOptional[$index]){
                                $this->countOptionalParams--;
                            }
                            $this->countParams--;
                        }
                        $this->name = $this->arrayDiffKey($this->name, $this->classOccurencies[$param]);
                        $this->isOptional = $this->arrayDiffKey($this->isOptional, $this->classOccurencies[$param]);
                        $this->defaultValue = $this->arrayDiffKey($this->defaultValue, $this->classOccurencies[$param]);
                        $this->classFullName = $this->arrayDiffKey($this->classFullName, $this->classOccurencies[$param]);
                        $this->className = $this->arrayDiffKey($this->className, $this->classOccurencies[$param]);
                        $this->classNameCount = $this->arrayDiffKey($this->classNameCount, $this->classOccurencies[$param]);
                    }
                }
                $this->countNecessaryParams = $this->countParams - $this->countOptionalParams;
            }
        }
        private function arrayDiffKey($a, $b){
            if(is_array($a) && is_array($b)){
                return (array_diff_key($a, $b));
            }
            return $a;
        }
        
        // GET FUNCTIONS
        public function getNameIndex($name){
            return (($this->getCheck($this->name)) ? array_search($name, $this->name) : false );
        }
        public function getIndexName($index){
            return ($this->name[$index]);
        }
        public function isOptional($index){
            if($this->getCheck($this->isOptional, $index)){
                return ($this->isOptional[$index]);
            }
            throw new Exception('Trying to get ' . $index . ' default value, it is not a value', 666);
        }
        public function getDefaultValues(){return ($this->defaultValue);}
        public function getDefaultValue($index){
            if($this->getCheck($this->defaultValue, $index)){
                return ($this->defaultValue[$index]);
            }
            throw new Exception('Trying to get ' . $index . ' default value, it is not an optional parameter', 666);
        }
        public function getClassFullName($index){
            return (($this->getCheck($this->classFullName, $index)) ? $this->classFullName[$index] : false );
        }
        public function getClassName($index){
            return (($this->getCheck($this->className, $index)) ? $this->className[$index] : false );
        }
        public function getClassNameIndex($name){
            return (($this->getCheck($this->className)) ? array_search($name, $this->className) : false );
        }
        public function getClassNameCount($name){
            return (($this->getCheck($this->classNameCount, $name)) ? $this->classNameCount[$name] : 0 );
        }
        public function getCount(){return ($this->countParams);}
        public function getCountNecessary(){return ($this->countNecessaryParams);}
        public function getCountOptional(){return ($this->countOptionalParams);}
        private function getCheck($array, $index = false){
            if(!is_array($array) || (($index !== false) && !isset($array[$index]))){
                return (false);
            }
            return (true);
        }
    }