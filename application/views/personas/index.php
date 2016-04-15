<?php
    use plugin\cryptography\Cryptography;
    use plugin\auth\Auth;
    use plugin\db\DB;
    use plugin\table\TableHtml;
    use plugin\katana\Katana;

use plugin\attribute\AttributeHtml;
use plugin\attribute\table\AttributeTableElement;
use plugin\attribute\table\AttributeTableTag;
use plugin\attribute\table\AttributeTableTd;
use plugin\table\Table;
use plugin\table\TableTr;
    use plugin\db\dds\DDS;
    use plugin\db\dds\table\DBTable;
    use plugin\db\dds\table\DBColumn;
    //use plugin\cookie\Cookie;
    use plugin\token\Token;
    use plugin\csrf\CSRF;
    use library\request\Request;
    use library\kernel\config\Config;
?>
<span style="display:block; border:1px solid black;">
    <h2>persona's index</h2>
<?php
    $form = $plugins['form'];
    $cookie = $plugins['cookie'];
    $form::open(['method' => 'post', 'url' => 'login']);
    $form::text('username', false, 'angelotm');
    $form::password('password', false, 'napoli');
    $form::submit('Login');
    $form::close();
    
    $form::open(['method' => 'post']);
    $form::submit('Logout');
    $form::close();
?>
</span>
<?php
    //Config::parseINIFile(PATH_CONFIG . 'tag.ini', true);
    
    //var_dump2(Request::getMethod());
    
    //var_dump2($_SERVER);

    //var_dump2(CSRF::generate());
    //var_dump2(Token::generate(22));


// arguments: id, class
// can include associative array of optional additional attributes
/*$tbl = new TableHtml('', 'miatable');
$tbl->addCaption('Mia nuova Tabella','myCap');
$tbl->addSezione('thead','myThead')->addRow()->addCell('user','','header')->addCell('nome','','header')->addCell('cognome','','header');
$tbl->addSezione('tfoot','mioTfoot')->addRow()->addCell('Sono la riga di foot', 'foot', 'data',['colspan'=>3,'align'=>'center'] );
$tbl->addSezione('tbody','mioTbody');*/


/*TableHtml::createTableFromArray($utenti)->displayTable();

$attr=new AttributeTableTd(['id'=>'1','class'=>'miaclasse','style'=>'color:blue;text-align:center','align'=>'center','valign'=>'top','bgcolor'=>'#FF0000','width'=>'5px','height'=>'100%']);
echo $attr->display();*/

///QUELLO CHE VOGLIO FARE
$table= new Table(array('id' => 'pollo','style'=>'border:1px solid black'));
$table->createTr()->createTd('mio cont')->buildHtmlTable();




/*class Table{
    public static function create(){
        
        return($this);
    }
    public function createTR(){
        return (new TableTR());
    }
}
class TableTR{
    private $myTable;
    public function __construct(Table $myTable){
        $this->myTable = $myTable;
    }
    public function createTD($dv,$vdv,$dfs){
        return (new TableTD($this,$dv,$vdv,$dfs));
    }
}
class TableTD{
    private $myTR;
    public function __construct(TableTR $myTR){
        $this->myTR = $myTR;
    }
    public function createTD($dv,$vdv,$dfs){
        return $this->myTR->createTD($dv,$vdv,$dfs);
    }
    public function createTR(){
        $this->myTR->myTable->createTR();
    }
}*/


/*$tbl->addSezione('tfoot','mioTfoot');
$tbl->addRow();
$tbl->addCell('Sono la riga di foot', 'foot', 'data',['colspan'=>3,'align'=>'center'] );
=======
    //use library\tag\Angelo;
    //$angelo = new Angelo();
/*
    $headers = apache_request_headers();
    var_dump2($headers);
*/
    var_dump2($cookie::get('prova'));
    //var_dump2(Cookie::get('prova'));
    //trigger_error("asd", E_ERROR);
    
    
    //echo $a;
    //casa();

    //get_defined_constants();
//throw new Exception("Daniele e' scem", 100);



/*
$tbl = DBTable::create("powcm")
    ->addColumn("colonna1","varchar(20)")->setNotNull()->setIsPK()->setDefault("defaultValue")
    ->addColumn("colonna2","int(2)")->setNotNull()->setIsPK()->setDefault("0");
*/



    
//echo $tbl->displayTable();

/*
var_dump2($tbl->build());
*/
//var_dump2(DDS::createDatabase("simonevolgare"));
//var_dump2(DDS::dropTable("tabella"));

//DDS::createTable($tbl);
//var_dump2(DDS::createTable($tbl));

//var_dump2(DDS::createTable($tbl));
//var_dump2(DDS::dropDatabase("simonevolgare"));

//$utenti=DB::open('user')->get();
//var_dump2($utenti);