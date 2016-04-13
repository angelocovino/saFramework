<?php 
namespace plugin\table;
use plugin\attribute\table\AttributeTableTr;
use plugin\table\TableTd;
use plugin\table\TablePart;

class Tabletr extends TablePart{
    private $myTable=false;
    private $attribute=false;
    private $td=array();
    
    protected function __construct($myTable,$attr=false){
        $this->myTable=$myTable;
        $this->attribute=new AttributeTableTr($attr);
    }
    
    public function getMytable(){return $this->myTable;}
    
    public function getAttr(){
        return $this->attribute;
    }
    
    public function setAttribute($nameAttr,$val){
        $this->attribute->{"set".ucfirst($nameAttr)}($val);
        /*call_user_func_array(
            array($this->attribute, "set".ucfirst()),
            array($val)
        );*/
        return $this;
    }
    
    public function createTd($cont,$t='data',$attr=false){
        $this->td[]=new TableTd($this,$cont,$t,$attr);
        return end($this->td);
    }
    
    private function getRowCells($celle)
    {
        $str='';
        foreach($celle as $c){
            $str .= $c->buildHtmlTd();
        }
        return $str;
    }
    
    protected function buildHtmlTr(){
        $str  = "<tr "; 
        $str .= (($this->attribute !== false)? $this->attribute->display() : '') . ">" . $this->getRowCells($this->td) . "</tr>\n";
        return $str;
    }
    
    protected function buildHtmlTable(){}
    protected function buildHtmlTd(){}
    
}