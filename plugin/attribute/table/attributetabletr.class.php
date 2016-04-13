<?php 
namespace plugin\attribute\table;


class AttributeTableTr extends AttributeTableSection{
    
    private $bgcolor=false;
    private $str='';
    
    function __construct($params){
        parent::__construct($params);
        $this->loadFromArray($params);
    }
    
    private function loadFromArray($array_attr){
         if(is_array($array_attr)){
            foreach($array_attr as $k=>$val){
                switch($k){
                    case 'bgcolor':
                        $this->setBgcolor($val);
                        break;
                }
            }
         }
        return $this;
    }
    
    public function getBgcolor(){
        return $this->bgcolor;
    }
    public function setBgcolor($bg){
        $this->bgcolor=$bg;
    }
    
    public function display(){
        $parentStr=parent::display();
        $bgcolor=$this->build('bgcolor',$this->bgcolor);
        
        $this->str .= $parentStr . $bgcolor;
        
        return $this->str;
    }  
}