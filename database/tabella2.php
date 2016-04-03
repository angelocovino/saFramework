<?php
use plugin\db\dds\table\DBTable;

function create(){
    return DBTable::create("TabellaPipposchi")
        ->addColumn("sale","int")->setIsPK()->setUnique()
        ->addColumn("pepe","varchar(5)")
        ->addColumn("caramello","varchar(5)")
        ->addColumn("sale1","varchar(5)")
        ->addColumn("pepe1","varchar(5)")
        ->addColumn("caramello1","varchar(5)")
        ->setUnique("sale","pepe","caramello")
        ->setUnique("sale1","pepe1","caramello1")
        ->setUnique();
}