<?php
    namespace plugin\db\dds\table;
    use plugin\db\dds\table\TableColumn;
    use plugin\db\dds\DDS;
    
    class Table{
        private $name = false;
        private $columns = array();
        private $query = false;
        
        private $nPKs = 0;
        
        function __construct($tableName){
            $this->setName($tableName);
        }
        public static function create($tableName){
            return (new TableDDS($tableName));
        }
        public function addColumn($name, $type){
            $this->setColumn(new TableColumn($name, $type, $this));
            return ($this->getColumnLast());
        }
        
        public function getName(){return ($this->name);}
        public function getColumn($index){return ($this->columns[$index]);}
        public function getColumnLast(){
            $column = end($this->columns);
            reset($this->columns);
            return ($column);
        }        
        public function getNPKs(){return ($this->nPKs);}
        
        private function setName($name){$this->name = $name; return ($this);}
        private function setColumn(TableColumn $column, $index = false){
            if($index === false){
                $this->columns[] = $column;
            }else{
                $this->columns[$index] = $column;
            }
            return ($this);
        }

        public function incrementNPKs(){$this->nPKs++; return ($this);}
        
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
    }