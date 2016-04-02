<?php
    namespace plugin\db\dds\table;
    use plugin\db\dds\table\DBTable;
    use \Exception;

    class DBColumn{
        // TABLE VARIABLES
        private $name = false;
        private $type = false;
        private $isNull = true;
        private $isPK = false;
        private $dflt = false;
        private $parentt = false;
        // SUPPORT VARIABLES
        private $query = false;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        function __construct($name, $type, $parentt){
            // POSSIAMO ANCHE METTERE TableDDS $parentt NEI PARAMETRI AL POSTO DELL'INSTANCEOF
            if($parentt instanceof DBTable){
                $this->parentt = $parentt;
                $this
                    ->setName($name)
                    ->setType($type);
            }else{
                throw new Exception("Non e' possibile instanziare una Colonna di Tabella se non tramite una Tabella");
            }
        }
        
        // INTERFACES WITH TABLE CLASS
        public function addColumn($name, $type){
            return ($this->parentt->addColumn($name, $type));
        }
        public function build(){
            return ($this->parentt->build());
        }
        public function get(){
            return ($this->parentt);
        }
        
        // BUILD FUNCTIONS
        public function buildColumn(){
            $this->query = $this->getName() . " " . $this->getType();
            if(!$this->getIsNull()){
                $this->query .= " NOT NULL";
            }
            if($this->getDefault() !== false){
                $this->query .= " DEFAULT '" . $this->getDefault() . "'";
            }
            return ($this->query);
        }
        
        // GET FUNCTIONS
        public function getName(){return ($this->name);}
        public function getType(){return ($this->type);}
        public function getIsNull(){return ($this->isNull);}
        public function getIsPK(){return ($this->isPK);}
        public function getDefault(){return ($this->dflt);}
        
        // SET FUNCTIONS
        private function setName($name){$this->name = $name; return ($this);}
        private function setType($type){$this->type = $type; return ($this);}
        public function setNotNull(){$this->isNull = false; return ($this);}
        public function setIsPK(){$this->isPK = true; $this->parentt->incrementNPKs(); return ($this);}
        public function setDefault($default){$this->dflt = $default; return ($this);}
    }
