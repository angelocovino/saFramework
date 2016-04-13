<?php    
    namespace plugin\table;
    use plugin\table\TableHtml;

class Cella{
    private $contenuto;
    private $klass;
    private $ar_attr=array();
    private $tipo;

    
    function __construct($cont,$cl,$t='data',$attr){
        $this->contenuto=$cont;
        $this->klass=$cl;
        $this->tipo=$t;
        $this->ar_attr=$attr;
    }
    
    public function getContenuto(){
        return $this->contenuto;
    }
    
    public function getClass(){
        return $this->klass;
    }
    public function getTipo(){
        return $this->tipo;
    }
    public function getAttr(){
        return $this->ar_attr;
    }
    
    public function buildCella(){
        
        $tag = ($this->tipo == 'data')? 'td': 'th';
        $str ="<${tag}";
        $str .= (!empty($this->klass)? " class=\"{$this->klass}\"": "") . TableHtml::addAttributi($this->ar_attr) . ">"
        . $this->contenuto . "</${tag}>\n";
        
        return $str;
    }
}

