<?php
    namespace library\kernel;
    use plugin\db\DB;

    abstract class Model{
        protected $modelName    = false;
        private $connection     = false;

        // CONSTRUCT AND DESTRUCT FUNCTIONS
        function __construct(){
            // GET THE CORRECT CLASSNAME, WITHOUT NAMESPACE
            $this->modelName = getClassFromNamespace(get_class($this)) . "s";
            // MAKE A NEW CONNECTION
            $this->connection = DB::_open($this->modelName);
        }
        
        // TO USE DATABASE METHODS
        // MODEL IS NOT A DATABASE EXTENSION ANYMORE, BECAUSE OF THE DATABASE CHOOSE IMPLEMENT
        public function __call($method, $params){
            return (call_user_func_array(array($this->connection, $method), $params));
        }
        
        public function getModelName(){
            return ($this->modelName);
        }
    }