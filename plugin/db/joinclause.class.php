<?php
    namespace plugin\db;
    
    class JoinClause{
        // JOIN CONSTANTS
        const INNERJOIN = "JOIN";
        const LEFTOUTERJOIN = "LEFT JOIN";
        const RIGHTOUTERJOIN = "RIGHT JOIN";
        
        // JOIN VARS
        private $query;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        function __construct($table, $type = self::INNERJOIN){
            $this->query = " {$type} {$table}";
        }
        
        // JOIN FUNCTIONS
        private function onBuild($x, $op, $y){
            $this->query .= " {$x}{$op}{$y}";
        }
        public function on($x, $op, $y){
            $this->query .= " ON";
            $this->onBuild($x, $op, $y);
            return ($this);
        }
        public function orOn($x, $op, $y){
            $this->query .= " OR";
            $this->onBuild($x, $op, $y);
            return ($this);
        }
        public function andOn($x, $op, $y){
            $this->query .= " AND";
            $this->onBuild($x, $op, $y);
            return ($this);
        }
        
        // GET FUNCTION
        public function getQuery(){
            return ($this->query);
        }
    }