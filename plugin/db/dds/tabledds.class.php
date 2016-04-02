<?php
    namespace plugin\db\dds;
    use plugin\db\dds\DDS;
    
    class TableDDS{
        private $name = false;
        private $columns = false;
        
        public function add($name, $type, $isNull = true, $default = false){
            $params = compact('name', 'type', 'isnull', 'default');
            $this->columns[] = new TableColumnDDS($params);
            return ($this);
        }
    }
    
    class TableColumnDDS{
        private $name = false;
        private $type = false;
        private $isNull = true;
        private $isPK = false;
        private $dflt = false;
        //private $extra;
        
        public function invokeWithParam($func, $params){
            if(method_exists($this, $func)){
                if(!is_array($params)){$params = array($params);}
                return (call_user_func_array(array($this, $func), $params));
            }
            return (false);
        }
        
        function __construct($params){
            if(is_array($params)){
                foreach($params as $key => $value){
                    echo $key;
                    if(substr($key, 0, 2) == "is"){
                        $key = substr($key, 0, 2) . ucfirst(substr($key, 2, strlen($key)));
                    }
                    $this->invokeWithParam('set' . ucfirst($key), $value);
                    /*
                    switch($key){
                        case 'name':
                            $this->setName($value);
                            break;
                        case 'type':
                            $this->setType($value);
                            break;
                        case 'is null':
                        case 'isnull':
                        case 'null':
                            $this->setIsNull($value);
                            break;
                        case 'primary key':
                        case 'primarykey':
                        case 'pk':
                            $this->setIsPK($value);
                            break;
                        case 'default':
                            $this->setDefault($value);
                            break;
                    }
                    */
                }
            }
        }
        
        public function getName(){return ($this->name);}
        public function getType(){return ($this->type);}
        public function getIsNull(){return ($this->isNull);}
        public function getIsPK(){return ($this->isPK);}
        public function getDefault(){return ($this->dflt);}
        
        public function setName($name){$this->name = $name; return ($this);}
        public function setType($type){$this->type = $type; return ($this);}
        public function setIsNull($isNull){$this->isNull = $isNull; return ($this);}
        public function setIsPK($isPK){$this->isPK = $isPK; return ($this);}
        public function setDefault($default){$this->dflt = $default; return ($this);}
    }
