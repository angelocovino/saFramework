<?php
    namespace plugin\form;
    use \Exception;
    
    class FormInput{
        // CONSTANTS
        const INPUT_TYPE = ['text', 'number', 'password', 'submit', 'email'];
        
        // VARIABLES
        private $type = 'text';
        private $name = false;
        private $value = false;
        private $placeholder = false;
        private $disabled = false;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        public function __construct($params){
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
            }else{
                throw new Exception('FormInput needs a Parameters array', 666);
            }
        }
        
        // CREATE NEW OBJECT BY STATIC METHOD
        public static function create($params){
            return ((new FormInput($params))->build());
        }
        
        // BUILD HTML FUNCTION
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
        
        // SET FUNCTIONS
        private function setType($type){$this->type=$type; return ($this);}
        private function setName($name){$this->name=$name; return ($this);}
        private function setValue($value){$this->value=$value; return ($this);}
        private function setPlaceholder($plchldr){$this->placeholder=$plchldr; return ($this);}
        private function setDisabled($dsbld){$this->disabled=$dsbld; return ($this);}
        
        // GET FUNCTIONS
        private function getType(){return ($this->type);}
        private function getName(){return ($this->name);}
        private function getValue(){return ($this->value);}
        private function getPlaceholder(){return ($this->placeholder);}
        private function getDisabled(){return ($this->disabled);}
    }