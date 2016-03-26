<?php
    use plugin\db\DB;

    class Model extends DB{
        protected $modelName;

        // CONSTRUCT AND DESTRUCT FUNCTIONS
        function __construct(){
            parent::__construct();
            $this->modelName = get_class($this) . "s";
            $this->setTable($this->modelName);
        }
        function __destruct(){}
        
        function getModelName(){
            return ($this->modelName);
        }
    }