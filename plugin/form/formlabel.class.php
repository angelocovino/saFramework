<?php
    namespace plugin\form;
    
    class FormLabel{
        private $forValue = false;
        private $value = false;
        
        public function __construct($for, $str){
            $this->setFor($for);
            $this->setValue($str);
        }
        
        public static function create($for, $str){
            return ((new FormLabel($for, $str))->build());
        }
        
        private function setFor($for){$this->forValue=$for; return ($this);}
        private function getFor(){return ($this->forValue);}
        
        private function setValue($value){$this->value=$value; return ($this);}
        private function getValue(){return ($this->value);}
        
        public function build(){
            $str = "<label for='" .$this->getFor() ."'>";
            $str .= $this->getValue() . "</label>";
            return ($str);
        }
    }