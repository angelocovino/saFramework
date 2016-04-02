<?php
    namespace plugin\db\dds;
    use plugin\db\dds\DDS;
    use \Exception;
    
    class TableDDS{
        private $name = false;
        private $columns = array();
        
        function __construct($tableName){
            $this->name = $tableName;
        }
        public static function create($tableName){
            return (new TableDDS($tableName));
        }
        public function addColumn($name, $type){
            $this->columns[] = new TableColumnDDS($name, $type, $this);
            return (end($this->columns));
        }
    }

    class TableColumnDDS{
        private $name = false;
        private $type = false;
        private $isNull = true;
        private $isPK = false;
        private $dflt = false;
        private $parentt = false;
        //private $extra;
        
        public function addColumn($name, $type){
            return ($this->parentt->addColumn($name, $type));
        }
        
        function __construct($name, $type, $parentt){
            if($parentt instanceof TableDDS){
                $this->parentt = $parentt;
                $this
                    ->setName($name)
                    ->setType($type);
            }else{
                throw new Exception("Non e' possibile instanziare una Colonna di Tabella se non tramite una Tabella");
            }
        }
        
        private function getName(){return ($this->name);}
        private function getType(){return ($this->type);}
        private function getIsNull(){return ($this->isNull);}
        private function getIsPK(){return ($this->isPK);}
        private function getDefault(){return ($this->dflt);}
        
        private function setName($name){$this->name = $name; return ($this);}
        private function setType($type){$this->type = $type; return ($this);}
        public function setNotNull(){$this->isNull = false; return ($this);}
        public function setIsPK(){$this->isPK = true; return ($this);}
        public function setDefault($default){$this->dflt = $default; return ($this);}
    }
