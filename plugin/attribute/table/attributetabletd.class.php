<?php
namespace plugin\attribute\table;

class AttributeTableTd extends AttributeTableTr{
    private $colspan=false;
    private $height=false;
    private $scope=false;
    private $width=false;
    private $rowspan=false;
    
    private $str='';
    
    function __construct($params){
        parent::__construct($params);
        $this->loadFromArray($params);
    }
    
    private function loadFromArray($array_attr){
         if(is_array($array_attr)){
            foreach($array_attr as $k=>$val){
                switch($k){
                    case 'colspan':
                        $this->setColspan($val);
                        break;
                    case 'height':
                        $this->setHeight($val);
                        break;
                    case 'scope':
                        $this->setScope($val);
                        break;
                    case 'width':
                        $this->setWidth($val);
                        break;
                    case 'rowspan':
                        $this->setRowspan($val);
                        break;
                }
            }
         }
        return $this;
    }
    
    public function getColspan(){
        return $this->colspan;
    }
    
    public function setColspan($colspan){
        $this->colspan=$colspan;
    }
    
    public function getHeight(){
        return $this->height;
    }
    
    public function setHeight($height){
        $this->height=$height;
    }
    
    public function getScope(){
        return $this->scope;
    }
    
    public function setScope($scope){
        $this->scope=$scope;
    }
    
    public function getWidth(){
        return $this->width;
    }
    
    public function setWidth($width){
        $this->width=$width;
    }
    
    public function getRowspan(){
        return $this->rowspan;
    }
    
    public function setRowspan($rowspan){
        $this->rowspan=$rowspan;
    }
    
    public function display(){
        $parentStr=parent::display();
        $colspan=$this->build('colspan',$this->colspan);
        $height=$this->build('height',$this->height);
        $scope=$this->build('scope',$this->scope);
        $width=$this->build('width',$this->width);
        $rowspan=$this->build('rowspan',$this->rowspan);
        
        $this->str .= $parentStr . $colspan . $height . $scope . $width . $rowspan;
        
        return $this->str;
        
    }
}