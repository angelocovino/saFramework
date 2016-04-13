<?php 
 namespace plugin\attribute;
     

class AttributeHtml{
     private $id=false;
     private $klass=false;
     private $style=false;
     
     private $strAttr='';
     
     function __construct($params=false){
        $this->loadFromArray($params);
     }
    
    public function setId($id){
        $this->id=$id;
    }
    public function getId(){
         return $this->id;
    }
     
    public function getClass(){
         return $this->klass;
    }
    public function setClass($klass){
        $this->klass=$klass;
    }
    public function getStyle(){
        return $this->style;
    }
    public function setStyle($style){
        $this->style=$style;
    }
     
    //protected load from array for construct
    private function loadFromArray($array_attr){
        if(is_array($array_attr)){
            foreach($array_attr as $k=>$val){
                switch($k){
                    case 'id':
                        $this->setId($val);
                        break;
                    case 'class':
                        $this->setClass($val);
                        break;
                    case 'style':
                        $this->setStyle($val);
                        break;
                }
            }
        }
        return $this;
    }
     
    //Load from array programmers     
    public static function loadArray($array_attr){
        return (new AttributeHtml())->loadFromArray($array_attr);
    }
    
    
     public static function build($k,$value){
         $str='';
         $str .= ($value!==false)? " ${k}=\"{$value}\"" : '';
         return $str;
     }
     
     public function display(){
         $id=$this->build('id',$this->id);
         $class=$this->build('class',$this->klass);
         $style=$this->build('style',$this->style);
         
         $this->strAttr .= $id . $class . $style;
         return $this->strAttr;
     }  
 }