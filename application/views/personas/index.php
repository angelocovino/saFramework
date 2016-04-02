<?php
    use plugin\form\Form;
    use plugin\cryptography\Cryptography;
    use plugin\auth\Auth;
    use plugin\db\DB;
    use plugin\table\TableHtml;
    use plugin\katana\Katana;
    use plugin\db\dds\DDS;
    use plugin\db\dds\table\DBTable;
    use plugin\db\dds\table\DBColumn;
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

$tbl = DBTable::create("tabella")
    ->addColumn("colonna1","varchar(20)")->setNotNull()->setIsPK()->setDefault("defaultValue")
    ->addColumn("colonna2","int(2)")->setNotNull()->setIsPK()->setDefault("0")->get();

var_dump2($tbl->build());
//var_dump2(DDS::createDatabase("simonevolgare"));
//var_dump2(DDS::dropTable("tabella"));

//DDS::createTable($tbl);
//var_dump2(DDS::createTable($tbl));

//var_dump2(DDS::createTable($tbl));
//var_dump2(DDS::dropDatabase("simonevolgare"));

//$utenti=DB::open('user')->get();
//var_dump2($utenti);