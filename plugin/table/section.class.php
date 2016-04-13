<?php 
    namespace plugin\table;
    use plugin\table\TableHtml;


class Section{
    public $classe;
    public $ar_attr=array();
    public $rows=array();
    
    function __contruct($class,$attr){
        $this->classe=$class;
        $this->ar_attr=$attr;
    }
    
    public function addRow($class='',$ar_attr=array())
    {
        $this->rows[]=new Row($class,$ar_attr);
        $pos=count($this->rows);
        return $this->rows[$pos-1];
    }
}