<?php
    use plugin\form\Form;
    use plugin\cryptography\Cryptography;
    use plugin\auth\Auth;
    use plugin\db\DB;
    use plugin\table\TableHtml;
    use plugin\katana\Katana;
    use plugin\db\dds\DDS;
    use plugin\db\dds\TableDDS;
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

$table = new TableDDS();
$table->add("ciao","asd", false, "Defau");
var_dump2($table);

var_dump2(DDS::createDatabase("simonevolgare", false));
//var_dump2(DDS::createTable("simonevolgare", true));
//var_dump2(DDS::dropDatabase("simonevolgare"));

//$utenti=DB::open('user')->get();
//var_dump2($utenti);



/*


// arguments: id, class
// can include associative array of optional additional attributes
$tbl = new TableHtml('', 'miatable');
$tbl->addCaption('Mia nuova Tabella','myCap');
$tbl->addSezione('thead','myThead');

$tbl->addRow();
$tbl->addCell('user','','header');
$tbl->addCell('nome','','header');
$tbl->addCell('cognome','','header');

$tbl->addSezione('tfoot','mioTfoot');
$tbl->addRow();
$tbl->addCell('Sono la riga di foot', 'foot', 'data',['colspan'=>3,'align'=>'center'] );

$tbl->addSezione('tbody','mioTbody');
foreach($utenti as $u){
    $tbl->addRow();
    $tbl->addCell($u['user']);
    $tbl->addCell($u['nome']);
    $tbl->addCell($u['cognome']);
}



    
echo $tbl->displayTable();
*/
    