<?php
    use plugin\form\Form;
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
?>
<style>
thead {color:green;}
tbody {color:blue;}
tfoot {color:red;}

table, th, td {
    border: 1px solid black;
}
</style>
<span style="display:block; border:1px solid black;">
    <h2>persona's index</h2>
    <form method="post" action="">
        <input type="text" name="username" value="angelotm" placeholder="username" />
        <input type="text" name="password" value="napoli" placeholder="password" />
        <input type="hidden" name="action" value="login" />
        <input type="submit" value="Login" />
    </form>
    <form method="post" action="">
        <input type="hidden" name="action" value="logout" />
        <input type="submit" value="Logout" />
    </form>
</span>

<?php

$utenti=DB::open('utenti')->get();


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
$table= new Table(array('id' => 'pollo'));
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

$tbl->addSezione('tbody','mioTbody');
foreach($utenti as $u){
    $tbl->addRow();
    $tbl->addCell($u['user']);
    $tbl->addCell($u['nome']);
    $tbl->addCell($u['cognome']);
}

*/

    
//echo $tbl->displayTable();

    