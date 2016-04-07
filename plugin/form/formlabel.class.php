<?php
    namespace plugin\form;
    
    class FormLabel{
        // LABEL VARIABLES
        private $forValue = false;
        private $value = false;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        public function __construct($for, $str){
            $this->setFor($for);
            $this->setValue($str);
        }
        
        // CREATE NEW OBJECT BY STATIC METHOD
        public static function create($for, $str){
            return ((new FormLabel($for, $str))->build());
        }
        
        // BUILD HTML FUNCTIONS
        public function build(){
            $str = "<label for='" .$this->getFor() ."'>";
            $str .= $this->getValue() . "</label>";
            return ($str);
        }
        
        // SET FUNCTIONS
        private function setFor($for){$this->forValue=$for; return ($this);}
        private function setValue($value){$this->value=$value; return ($this);}
        
        // GET FUNCTIONS
        private function getFor(){return ($this->forValue);}
        private function getValue(){return ($this->value);}
    }