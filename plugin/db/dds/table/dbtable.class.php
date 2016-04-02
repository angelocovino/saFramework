<?php
    namespace plugin\db\dds\table;
    use plugin\db\dds\table\DBColumn;
    
    class DBTable{
        // TABLE VARIABLES
        private $name = false;
        private $columns = array();
        private $query = false;
        // SUPPORT VARIABLES
        private $nPKs = 0;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        function __construct($tableName){
            $this->setName($tableName);
        }
        public static function create($tableName){
            return (new DBTable($tableName));
        }
        
        // COLUMN FUNCTIONS
        public function addColumn($name, $type){
            $this->setColumn(new DBColumn($name, $type, $this));
            return ($this->getColumnLast());
        }
        
        // BUILD FUNCTIONS
        public function build(){
            $pks = "";
            $j = 0;
            $this->query = "CREATE TABLE {$this->name} (";
            foreach($this->columns as $i => $column){
                if($i > 0){$this->query .= ", ";}
                $this->query .= $column->buildColumn();
                if($column->getIsPK()){
                    $pks .= $column->getName();
                    if(++$j < $this->getNPKs()){
                        $pks .= ", ";
                    }
                }
            }
            if($this->getNPKs()>0){
                $this->query .= ", PRIMARY KEY(" . $pks . ")";
            }
            $this->query .= ")";
            return ($this->query);
        }
        
        // GET FUNCTIONS
        public function getName(){return ($this->name);}
        public function getColumn($index){return ($this->columns[$index]);}
        public function getColumnLast(){
            $column = end($this->columns);
            reset($this->columns);
            return ($column);
        }        
        public function getNPKs(){return ($this->nPKs);}
        
        // SET FUNCTIONS
        private function setName($name){$this->name = $name; return ($this);}
        private function setColumn(DBColumn $column, $index = false){
            if($index === false){
                $this->columns[] = $column;
            }else{
                $this->columns[$index] = $column;
            }
            return ($this);
        }
            // INCREMENT FUNCTIONS
            public function incrementNPKs(){$this->nPKs++; return ($this);}
    }