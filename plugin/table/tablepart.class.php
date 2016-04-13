<?php
    namespace plugin\table;

abstract class TablePart{
    abstract protected function __construct($a);
    abstract protected function buildHtmlTable();
    abstract protected function buildHtmlTr();
    abstract protected function buildHtmlTd();
}