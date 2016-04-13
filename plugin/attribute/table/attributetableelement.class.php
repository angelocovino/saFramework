<?php 
 namespace plugin\attribute\table;
 use plugin\attribute\AttributeHtml;    

class AttributeTableElement extends AttributeHtml{
    private $align=false;
    private $str='';
    
    function __construct($params){
        parent::__construct($params);
        $this->loadFromArray($params);      
    }
    
    public function getAlign(){
        return $this->align;
    }
    
    public function setAlign($align){
        $this->align=$align;
    }
    
    private function loadFromArray($array_attr){
        if(is_array($array_attr)){
            foreach($array_attr as $k=>$val){
                switch($k){
                    case 'align':
                        $this->setAlign($val);
                        break;
                }
            }
        }
        return $this;
    }
    
    public function display(){
        $parentStr=parent::display();
        $align=$this->build('align',$this->align);
        
        $this->str .= $parentStr . $align;
        
        return $this->str;
    }  
}