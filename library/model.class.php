<?php
class Model extends DB{
	protected $_model;
    
    // CONSTRUCT AND DESTRUCT FUNCTIONS
	function __construct(){
        parent::__construct();
		//$this->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$this->_model = get_class($this);
		//$this->_table = strtolower($this->_model)."s";
		$this->setTable(strtolower($this->_model)."s");
	}
	function __destruct(){
	}
}
