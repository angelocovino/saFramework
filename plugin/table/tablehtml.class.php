<?php
    namespace plugin\table;
    use plugin\table\TablePart;
    use plugin\table\Cella;
    use plugin\table\Row;
    use plugin\table\Section;
class TableHtml {
    
    private $thead=false;
    private $tbody=false;
    private $tfoot=false;
    
    private $sez_curr;//Sezione corrente
    
    private $tableStr='<table';//Stringa per la costruzione della tabella
    
    //Costruttore 
    function __construct($id='',$class='',$ar_attr=array())
    {
        $this->tableStr .= (!empty($id)? " id=\"$id\"":'') . 
            (!empty($class)? " class=\"$class\"":'') . 
            $this->addAttributi($ar_attr) . ">\n";
        
    }
    
    //Crea una stringa di attributi
     /* argomenti: array associativo per attributi*/
    public static function addAttributi($attr)
    {
        $attr_str='';
        foreach($attr as $key=>$val){
            $attr_str .=" $key=\"$val\"";
        }
        return $attr_str;
    }
    
     /* argomenti: sezione thead, tfoot o tbody, class (opzionale),
        array associativo per attributi (opzionale)*/
    public function addSezione($sez,$class='',$ar_attr=array())
    {
        
         switch ($sez) {
            case 'thead':
                 if($this->thead===false){
                //$ref=&$this->thead;
                 $this->thead=new Section($class,$ar_attr);
                 $ref=$this->thead;
                 }
                break;
            case 'tfoot':
                if($this->tfoot===false){
                $this->tfoot=new Section($class,$ar_attr);
                 $ref=$this->tfoot;
                }
                break;
            default:
             case 'tbody':
                 if($this->tbody===false){
                 $this->tbody=new Section($class,$ar_attr);
                 $ref=$this->tbody;
                 }
                break;
        }
        return $ref;
    }
    
    //Aggiunge il caption alla tabella
     /* argomenti: contenuto caption, class (opzionale),
    array associativo per attributi (opzionale)*/
    public function addCaption($string,$class='',$ar_attr=array())
    {
        $this->tableStr .="<caption" . (!empty($class)? " class=\"$class\"": '') .
            $this->addAttributi($ar_attr) . '>' . $string . "</caption>\n";
    }
    
    

    //Rstituisce in una stringa una sezione con le proprie righe
     /* argomenti: array di sezione, tag (Indica il tipo di sezione thead,tbody o tfoot)*/
    private function getSection($sec,$tag){
        $str='';
        $class=(!empty($sec->classe)? " class=\"{$sec->classe}\"": "");
        $attr=(!empty($sec->ar_attr)? $this->addAttributi($sec->ar_attr) : "");
        
        $str .="<${tag}" . $class . $attr . ">\n";
        
        
        foreach($sec->rows as $r){
             $str .= $r->buildRow();
        }
        
        $str .= "</${tag}>\n";
        
        return $str;   
    }
    
    //Ritorna la stringa contenente la tabella costruita
    public function displayTable(){
        $this->tableStr .= ($this->thead!==false)? $this->getSection($this->thead,'thead') : '';
        $this->tableStr .= ($this->tfoot!==false)? $this->getSection($this->tfoot, 'tfoot'): '';
        $this->tableStr .= ($this->tbody!==false)? $this->getSection($this->tbody,'tbody') : '';
        $this->tableStr .= "</table>";
        
        echo $this->tableStr;
    }
     
    public static function createTableFromArray($array,$thead=false,$tfoot=false){
        $tbl=new TableHtml();
        
        $Nrow=count($array);
        if($Nrow > 0 ){
            $Ncelle=count($array[0]);
            $elemTh=array_keys($array[0]);
        }
        
        if($thead!==false){
            //CREAZIONE SEZIONE THEAD, OGNI CELLA DELLA PRIMA RIGA HA COME VALORE LA CHIAVE DELL'ARRAY PASSATO IN INPUT.
            $sezione=$tbl->addSezione('thead');
            $row=$sezione->addRow();
            foreach($elemTh as $t){
                 $row->addCell($t,'','header');  
            }
        }
        
        if($tfoot!==false){
            //CREAZIONE SEZIONE FOOTER
            $sezione=$tbl->addSezione('tfoot');
            $row=$sezione->addRow();
            $row->addCell('Footer', 'foot', 'data',['colspan'=>$Ncelle,'align'=>'center'] );
        }
        
        //CREAZIONE SEZIONE TBODY
        $sezione=$tbl->addSezione('tbody');
        foreach($array as $a){
            $row=$sezione->addRow();
            foreach($a as $i=>$val){
                $row->addCell($val);
            }
        }
        
        return $tbl;    
    }
    
}
