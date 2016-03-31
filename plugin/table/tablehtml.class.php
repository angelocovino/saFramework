<?php
    namespace plugin\table;

class TableHtml {
    
    private $thead=array();//Array contiene header
    private $tbody=array();//Array contiene body
    private $tfoot=array();//Array contiene footer
    
    private $sez_curr;//Sezione corrente
    
    private $tableStr='<table';//Stringa per la costruzione della tabella
    
    //Costruttore 
    function __construct($id='',$class='',$ar_attr=array())
    {
        
        //Aggiorno la sezione corrente al tbody
        $this->sez_curr=$this->tbody[]=array();
        
        $this->tableStr .= (!empty($id)? " id=\"$id\"":'') . 
            (!empty($class)? " class=\"$class\"":'') . 
            $this->addAttributi($ar_attr) . ">\n";
        
    }
    
    //Crea una stringa di attributi
     /* argomenti: array associativo per attributi*/
    public function addAttributi($attr)
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
                $ref=&$this->thead;
                 
                break;
            case 'tfoot':
                $ref=&$this->tfoot;
                break;
            default:
             case 'tbody':
                $ref=&$this->tbody[ count($this->tbody) ];
                break;
        }
        
        $ref['class']=$class;
        $ref['attr']=$ar_attr;
        $ref['rows']=array();
        
        $this->sez_curr=&$ref;
        
    }
    
    //Aggiunge il caption alla tabella
     /* argomenti: contenuto caption, class (opzionale),
    array associativo per attributi (opzionale)*/
    public function addCaption($string,$class='',$ar_attr=array())
    {
        $this->tableStr .="<caption" . (!empty($class)? " class=\"$class\"": '') .
            $this->addAttributi($ar_attr) . '>' . $string . "</caption>\n";
    }
    
    //Aggiunge una riga alla sezione corrente
     /* argomenti:class (opzionale)
    array associativo per attributi (opzionale)*/
    public function addRow($class='',$ar_attr=array())
    {
        //Aggiunge una riga alla sezione corrente
        $this->sez_curr['rows'][]=array(
            'class'=>$class,
            'attr'=>$ar_attr,
            'celle'=> array()
        );
    }
    
    /* argomenti: contenuto cella, class (opzionale),
    tipo (default è 'data' per td, 'header' per th)
    array associativo per attributi (opzionale)*/
    public function addCell($contenuto='',$class='',$tipo='data',$ar_attr=array())
    {
        $cella= array(
            'contenuto'=>$contenuto,
            'class'=>$class,
            'tipo'=>$tipo,
            'attr'=>$ar_attr
        );
        
        if(empty($this->sez_curr['rows']) ){
            try {
                throw new Exception('Aggiungi prima una riga prima di aggiungere una cella');
            } catch(Exception $ex) {
                $msg = $ex->getMessage();
                echo "<p>Errore: $msg</p>";
            }
        }
        
        $pos=count($this->sez_curr['rows'] );
        $currRow=&$this->sez_curr['rows'][$pos-1];
        $currRow['celle'][]=&$cella;
    }
    
    
    //Restituisce in una stringa il contenuto di un td o un th 
     /* argomenti: array di celle  */
    private function getRow($celle)
    {
        $str='';
        foreach($celle as $c){
            //controllo il tipo di tag
            $tag = ($c['tipo'] == 'data')? 'td': 'th';
            $str .="<${tag}";
            $str .= (!empty($c['class'])? " class=\"${c['class']}\"": "") . $this->addAttributi($c['attr']) . ">"
                . $c['contenuto'] . "</${tag}>\n";
        }
        return $str;
    }
    
    //Rstituisce in una stringa una sezione con le proprie righe
     /* argomenti: array di sezione, tag (Indica il tipo di sezione thead,tbody o tfoot)*/
    private function getSection($sec,$tag){
        echo "$tag ";
        $str='';
        $class=(!empty($sec['class'])? " class=\"${sec['class']}\"": "");
        $attr=(!empty($sec['attr'])? $this->addAttributi($sec['attr']) : "");
        
        $str .="<${tag}" . $class . $attr . ">\n";
        
        foreach($sec['rows'] as $r){
            $str .= "<tr";
            $str .= (!empty($r['class'])? " class=\"${r['class']}\"": "") . 
                $this->addAttributi($r['attr']) . ">" . $this->getRow($r['celle']) . "</tr>\n";             
        }
        
        $str .= "</${tag}>\n";
        
        return $str;   
    }
    
    //Ritorna la stringa contenente la tabella costruita
    public function displayTable(){
        $this->tableStr .= (count($this->thead)>0? $this->getSection($this->thead,'thead') : '');
        $this->tableStr .= (!empty($this->tfoot)? $this->getSection($this->tfoot, 'tfoot'): '');
        
        foreach($this->tbody as $t){
            $this->tableStr .= (!empty($t) ? $this->getSection($t,'tbody') : "");
        }
        
        $this->tableStr .= "</table>";
        
        return $this->tableStr;
    }
    
}
