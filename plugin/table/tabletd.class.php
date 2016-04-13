<?php
namespace plugin\table;
use plugin\attribute\table\AttributeTableTd;
use plugin\table\TablePart;

class TableTd extends TablePart{
     private $myTr;
     private $content;
     private $type;
     private $attribute;
    
    protected function __construct($myTr, $cont='', $type='data', $attr=false){
        $this->content = $cont;
        $this->type = $type;
        $this->attribute= new AttributeTableTd($attr);
        $this->myTr=$myTr;
        
    }

    public function getContent(){
        return $this->content;
    }
    
    public function getType(){
        return $this->type;
    }
    
    public function getAttr(){
        return $this->attribute;
    }
    
    public function setContent($val){
        $this->content = $val;
        return $this;
    }
    
    public function setType($val){
        $this->type= $val;
        return $this;
    }
    
    public function createTd($cont,$t='data',$attr=false){
        return $this->myTr->createTd($cont,$t='data',$attr);
    }
    
    public function createTr($attr){
        $this->myTr->getMytable()->createTr($attr);
    }
    public function setAttribute($nameAttr,$val){
        $this->attribute->{"set".ucfirst($nameAttr)}($val);
        /*call_user_func_array(
            array($this->attribute, "set".ucfirst()),
            array($val)
        );*/
        return $this;
    }
    
    protected function buildHtmlTd(){
        $tag = ($this->type == 'data')? 'td': 'th';
        $str ="<${tag} ";
        $str .= (($this->attribute !== false)? $this->attribute->display() : '') . ">" . $this->content . "</${tag}>\n";
        return $str;
    }
    
    protected function buildHtmlTr(){}
    
    public function buildHtmlTable(){
        echo $this->myTr->getMytable()->buildHtmlTable();
    }
    
    
    
}