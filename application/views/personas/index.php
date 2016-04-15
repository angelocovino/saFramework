<?php
    // ATTRIBUTE PLUGINS
    use plugin\attribute\AttributeHtml;
    use plugin\attribute\table\AttributeTableElement;
    use plugin\attribute\table\AttributeTableTag;
    use plugin\attribute\table\AttributeTableTd;
    // TABLE PLUGINS
    use plugin\table\Table;
    use plugin\table\TableTr;
    use plugin\table\TableHtml;
    // DDS PLUGINS
    use plugin\db\dds\DDS;
    use plugin\db\dds\table\DBTable;
    use plugin\db\dds\table\DBColumn;
    // OTHERS
    use plugin\cryptography\Cryptography;
    use library\kernel\config\Config;
    use plugin\katana\Katana;
    use plugin\token\Token;
    use plugin\csrf\CSRF;
    use plugin\auth\Auth;
    use plugin\db\DB;
?>
<span style="display:block; border:1px solid black;">
    <h2>persona's index</h2>
<?php
    var_dump2($request::getCookie('cookie'));
    
    /*  
    $cookie = $plugin->get('cookie');
    if($cookie::get('prova') === false){
        $cookie::set('prova','valoreprova', time()+5);
    }
    var_dump2($cookie::get('prova'));
    */
    
    $form = $plugin->get('form');
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


/*TableHtml::createTableFromArray($utenti)->displayTable();

$attr=new AttributeTableTd(['id'=>'1','class'=>'miaclasse','style'=>'color:blue;text-align:center','align'=>'center','valign'=>'top','bgcolor'=>'#FF0000','width'=>'5px','height'=>'100%']);
echo $attr->display();*/

///QUELLO CHE VOGLIO FARE
$table= new Table(array('id' => 'pollo','style'=>'border:1px solid black'));
$table->createTr()->createTd('mio cont')->buildHtmlTable();


/*$tbl->addSezione('tfoot','mioTfoot');
$tbl->addRow();
$tbl->addCell('Sono la riga di foot', 'foot', 'data',['colspan'=>3,'align'=>'center'] );
=======

/*
    $headers = apache_request_headers();
    var_dump2($headers);
*/

    //get_defined_constants();
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