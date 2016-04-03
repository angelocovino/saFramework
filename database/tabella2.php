<?php
use plugin\db\dds\table\DBTable;

function create(){
    return DBTable::create("TabellaPipposchi")
        ->addColumn("Solo","int")->setIsPK()
        ->addColumn("Angelo","varchar(5)");
}