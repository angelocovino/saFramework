<?php
    namespace plugin\table;
    use plugin\table\TableHtml;
    use plugin\table\Cella;

class Row{
    private $classe;
    private $ar_attr=array();
    private $celle=array();
    
    
    function __contruct($class,$attr){
        $this->classe=$class;
        $this->ar_attr=$attr;
    }
    
    //GET FUNCTIONS
    public function getClass(){return $this->classe;}
    public function getAttr(){return $this->ar_attr;}
    public function getCell(){return $this->celle;}
    
    
    public function addCell($contenuto='',$class='',$tipo='data',$ar_attr=array())
    {
        $this->celle[]=new Cella($contenuto,$class,$tipo,$ar_attr);
        return $this;
    }
    
    //Restituisce in una stringa il contenuto di un td o un th 
     /* argomenti: array di celle  */
    private function getRowCells($celle)
    {
        $str='';
        foreach($celle as $c){
            $str .= $c->buildCella();
        }
        return $str;
    }
    
    public function buildRow(){
        $str  = "<tr";
        $str .= (!empty($this->classe)? " class=\"{$this->classe}\"": "") . 
        TableHtml::addAttributi($this->ar_attr) . ">" . $this->getRowCells($this->celle) . "</tr>\n";
        
        return $str;
    }
    
    
}