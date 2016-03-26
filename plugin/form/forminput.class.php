<?php
    namespace plugin\form;
    
    class FormInput{
        const INPUT_TYPE = ['text', 'number', 'password', 'submit', 'email'];
        
        private $type = 'text';
        private $name = false;
        private $value = false;
        private $placeholder = false;
        private $disabled = false;
        
        public function __construct($params = false){
            if(is_array($params)){
                if(
                    array_key_exists('type', $params) && 
                    in_array($params['type'], FormInput::INPUT_TYPE)
                ){
                    $this->setType($params['type']);
                }
                if(array_key_exists('name', $params)){
                    $this->setName($params['name']);
                }
                if(array_key_exists('value', $params)){
                    $this->setValue($params['value']);
                }
                if(array_key_exists('placeholder', $params)){
                    $this->setPlaceholder($params['placeholder']);
                }
                if(
                    array_key_exists('disabled', $params) && 
                    is_bool($params['disabled'])
                ){
                    $this->setDisabled($params['disabled']);
                }
            }
        }
        
        public static function create($params = false){
            return ((new FormInput($params))->build());
        }
        
        private function setType($type){$this->type=$type; return ($this);}
        private function getType(){return ($this->type);}
        
        private function setName($name){$this->name=$name; return ($this);}
        private function getName(){return ($this->name);}
        
        private function setValue($value){$this->value=$value; return ($this);}
        private function getValue(){return ($this->value);}
        
        private function setPlaceholder($plchldr){$this->placeholder=$plchldr; return ($this);}
        private function getPlaceholder(){return ($this->placeholder);}
        
        private function setDisabled($dsbld){$this->disabled=$dsbld; return ($this);}
        private function getDisabled(){return ($this->disabled);}
        
        public function build(){
            $str = "<input type='" . $this->getType() . "'";
            if($this->getName()!=false){
                $str .= " name='" . $this->getName() . "'";
            }
            if($this->getValue()!=false){
                $str .= " value='" . $this->getValue() . "'";
            }
            if($this->getPlaceholder()!=false){
                $str .= " placeholder='" . $this->getPlaceholder() . "'";
            }
            if($this->getDisabled()){
                $str .= " disabled";
            }
            $str .= " />";
            return ($str);
        }
    }