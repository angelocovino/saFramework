<?php 
namespace plugin\table;
use plugin\table\TablePart;
use plugin\table\Tabletr;
use plugin\attribute\table\AttributeTableTag;

class Table extends Tablepart{
    private $attribute=false;
    private $thead=false;
    private $tbody=false;
    private $tfoot=false;
    private $tr=array();
    
    
    public function __construct($attr=false){
        $this->attribute=new AttributeTableTag($attr);
    }
    
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
    
    public function createTr($attr=false){
        $this->tr[]=new Tabletr($this,$attr);
        return end($this->tr);
    }
    
    private function getRow($row)
    {
        $str='';
        foreach($row as $r){
            $str .= $r->buildHtmlTr();
        }
        return $str;
    }
    protected function buildHtmlTr(){}
    protected function buildHtmlTd(){}
    protected function buildHtmlTable(){
        $str = '<table ';
        $str .= (($this->attribute !== false) ? $this->attribute->display() : '') .  ">\n";
        $str .= $this->getRow($this->tr) . "</table>";
        
        return $str;
        
    }
    
}
    
    
