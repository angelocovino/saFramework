<?php 
namespace plugin\attribute\table;

class AttributeTableTag extends AttributeTableElement{
    private $bgcolor=false;
    private $border=false;	
    private $cellpadding=false;	
    private $cellspacing=false;	
    private $width=false;
    
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
                    case 'border':
                        $this->setBorder($val);
                        break;
                    case 'cellpadding':
                        $this->setCellpadding($val);
                        break;
                    case 'cellspacing':
                        $this->setCellspacing($val);
                        break;
                    case 'width':
                        $this->setWidth($val);
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
    
    public function getBorder(){
        return $this->border;
    }
    public function setBorder($border){
        $this->border=$border;
    }
    
    public function getCellpadding(){
        return $this->cellpadding;
    }
    public function setCellpadding($cellpadding){
        $this->cellpadding=$cellpadding;
    }
    public function getCellspacing(){
        return $this->cellspacing;
    }
    public function setCellspacing($cellspacing){
        $this->cellspacing=$cellspacing;
    }
    public function getWidth(){
        return $this->width;
    }
    public function setWidth($width){
        $this->width=$width;
    }
    
    public function display(){
        $parentStr=parent::display();
        $bgcolor=$this->build('bgcolor',$this->bgcolor);
        $border=$this->build('border',$this->border);
        $cellpadding=$this->build('cellpadding',$this->cellpadding);
        $cellspacing=$this->build('cellspacing',$this->cellspacing);
        $width=$this->build('width',$this->width);
        
        $this->str .= $parentStr . $bgcolor . $border . $cellpadding . $cellspacing . $width;
        
        return $this->str;
    }  
}