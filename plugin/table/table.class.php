<?php 
namespace plugin\table;
use plugin\table\TablePart;
use plugin\table\Tabletr;
use plugin\attribute\table\AttributeTableTag;
use plugin\table\Section;

class Table extends Tablepart{
    private $attribute=false;
    private $thead=false;
    private $tbody=false;
    private $tfoot=false;
    private $tr=array();
    
    
    public function __construct($attr=false){
        $this->attribute=new AttributeTableTag($attr);
    }
    
    public function addSezione($sez,$attr=false)
    {
        
         switch ($sez) {
            case 'thead':
                 if($this->thead===false){
                    $this->thead=new Section($this,$ar_attr=false);
                    $ref=$this->thead;
                 }
                break;
            case 'tfoot':
                if($this->tfoot===false){
                    $this->tfoot=new Section($this,$ar_attr=false);
                    $ref=$this->tfoot;
                }
                break;
            default:
             case 'tbody':
                 if($this->tbody===false){
                    $this->tbody=new Section($this,$ar_attr=false);
                    $ref=$this->tbody;
                 }
                break;
        }
        
        return $ref;
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
    
    public static function createTableFromArray($array,$attr=false,$thead=false,$tfoot=false){
        $tbl=new Table($attr);
        
        $Nrow=count($array);
        if($Nrow > 0 ){
            $Ncelle=count($array[0]);
            $elemTh=array_keys($array[0]);
        }
        
        if($thead!==false){
            //CREAZIONE SEZIONE THEAD, OGNI CELLA DELLA PRIMA RIGA HA COME VALORE LA CHIAVE DELL'ARRAY PASSATO IN INPUT.
            $sezione=$tbl->addSezione('thead');
            $row=$sezione->createTr();
            foreach($elemTh as $t){
                 $row->createTh($t,'header');  
            }
        }
        
        if($tfoot!==false){
            //CREAZIONE SEZIONE FOOTER
            $sezione=$tbl->addSezione('tfoot');
            $row=$sezione->createTr();
            $row->createTd('Riga di footer','data');
        }
        
        //CREAZIONE SEZIONE TBODY
        $sezione=$tbl->addSezione('tbody');
        foreach($array as $a){
            $row=$sezione->createTr(array('id'=>"${a['id']}"));
            foreach($a as $i=>$val){
                $row->createTd($val);
            }
        }
        
        return $tbl;    
    }
    
    protected function buildHtmlTr(){}
    protected function buildHtmlTd(){}
    protected function buildHtmlTableSection($sec,$tag){
        $str='';
        $str .= $sec->buildHtmlTableSection($sec,$tag);
        return $str;
    }
    public function buildHtmlTable(){
        
        $str = '<table ';
        $str .= (($this->attribute !== false) ? $this->attribute->display() : '') .  ">\n";
        $str .= ($this->thead!==false)? $this->buildHtmlTableSection($this->thead,'thead') : '';
        $str .= ($this->tfoot!==false)? $this->buildHtmlTableSection($this->tfoot, 'tfoot'): '';
        $str .= ($this->tbody!==false)? $this->buildHtmlTableSection($this->tbody,'tbody') : '';
        $str .= "</table>";
        
        echo $str;
        
    }
    
}
    
    
