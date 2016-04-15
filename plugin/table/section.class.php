<?php 
    namespace plugin\table;
    use plugin\table\Table;
    use plugin\table\Tabletr;
    use plugin\attribute\table\AttributeTableSection;


class Section extends TablePart{
    private $attribute=false;
    private $myTable=false;
    private $tr=array();
    
    
    protected function __construct($myTable,$attr=false){
        $this->myTable=$myTable;
        $this->attribute=new AttributeTableSection($attr);
    }
    
    public function getMytable(){return $this->myTable;}
    
    public function getAttr(){
        return $this->attribute;
    }
    
    public function createTr($attr=false){
        $this->tr[]=new Tabletr($this->myTable,$attr);
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
    
     protected function buildHtmlTableSection($sec,$tag){
        $str = "<${tag}";
        $str .= (($this->attribute !== false) ? $this->attribute->display() : '') .  ">\n";
        $str .= $this->getRow($this->tr) . "</${tag}>";
        
        return $str;
     }
    protected function buildHtmlTr(){}
    protected function buildHtmlTd(){}
    protected function buildHtmlTable(){}
}