<?php
    namespace plugin\form;
    
    class FormBuilder{
        public static $FORM_METHODS = ['post', 'get'];
        private $method = 'post';
        private $url = false;
        private $action = false;
        
        public function build(){
            $str = "<form method='" . $this->getMethod() . "'";
            if($this->getUrl()!==false){
                $str .= " action='" . $this->getUrl() . "'";
            }else if($this->getAction()!==false){
                $str .= " action='" . $this->getAction() . "'";
            }
            $str .=">\n";
            return ($str);
        }
        
        public function setUrl($url){$this->url=$url;}
        public function getUrl(){return ($this->url);}
        
        public function setMethod($method){$this->method=$method;}
        public function getMethod(){return ($this->method);}
        
        public function setAction($action){$this->action=$action;}
        public function getAction(){return ($this->action);}
    }