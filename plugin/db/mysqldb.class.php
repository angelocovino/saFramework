<?php
    namespace plugin\db;
    use plugin\db\DB;

class MySqlDB extends DB{
        // CONSTRUCT FUNCTION
        function __construct(){
            parent::__construct();
			$this->dbType="mysql";
        }
}