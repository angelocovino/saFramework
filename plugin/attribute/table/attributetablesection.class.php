<?php 
namespace plugin\attribute\table;

class AttributeTableSection extends AttributeTableElement{
    private $char=false;
    private $charoff=false;
    private $valign=false;
    
    private $str='';
    
    function __construct($params){
         parent::__construct($params);
         $this->loadFromArray($params);
    }
    
    
    private function loadFromArray($array_attr){
        if(is_array($array_attr)){
            foreach($array_attr as $k=>$val){
                switch($k){
                    case 'char':
                        $this->char=$val;
                        break;
                    case 'charoff':
                        $this->charoff=$val;
                        break;
                    case 'valign':
                        $this->valign=$val;
                        break;
                }
            }
        }
        return $this;
    }
    
    public function getChar(){
        return $this->char;
    }
    public function setChar($ch){
        $this->char=$ch;
    }
    
    public function getCharoff(){
        return $this->charoff;
    }
    public function setCharoff($choff){
        $this->charoff=$choff;
    }
    public function getValign(){
        return $this->valign;
    }
    public function setCellpadding($valign){
        $this->valign=$valign;
    }
    
    public function display(){
        $parentStr=parent::display();
        $char=$this->build('char',$this->char);
        $charoff=$this->build('charoff',$this->charoff);
        $valign=$this->build('valign',$this->valign);
    
        $this->str .= $parentStr . $char . $charoff . $valign;
        
        return $this->str;
    } 
}

