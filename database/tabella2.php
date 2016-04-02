<?php
/**
 * User: Simone
 * Date: 02/04/2016
 * Time: 18.39
 */
use plugin\db\dds\table\DBTable;

function create(){
    return DBTable::create("TabellaPipposchi")
        ->addColumn("Solo","int")->setIsPK()
        ->addColumn("Angelo","varchar(5)");
}