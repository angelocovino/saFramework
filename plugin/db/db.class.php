<?php
    namespace plugin\db;
    use plugin\db\DBConnection;
    use plugin\db\JoinClause;
    use plugin\db\MysqlDB;
    
	abstract class DB extends DBConnection{
        // TABLE VARS
		private $table = false;
        private $tableStructure = false;
        private $tableJoinsQuery = '';
        
        // SELECT VARS
        private $selectQuery = false;
            // ORDER BY VARS
            private $orderByQuery = '';
            private $orderByCount = 0;
            // GROUP BY / HAVING VARS
            private $groupByQuery = '';
            private $groupByCount = 0;
            private $havingQuery = false;
            private $havingParams = array();
            private $havingParamsCount = 0;
        // LIMIT VARS
        private $limitQuery=false;
        // WHERE VARS
        private $whereQuery = false;
        private $whereParams = array();
        private $whereParamsCount = 0;
        
		// CONSTRUCT AND DESTRUCT FUNCTIONS
        function __construct(){
			parent::__construct();
            $this->tableJoinsQuery = '';

            // SELECT VARS
            $this->selectQuery = false;
                // ORDER BY VARS
                $this->orderByQuery = '';
                $this->orderByCount = 0;
                // GROUP BY / HAVING VARS
                $this->groupByQuery = '';
                $this->groupByCount = 0;
                $this->havingQuery = false;
                $this->havingParams = array();
                $this->havingParamsCount = 0;
                // LIMIT VARS
                $this->limitQuery = false;
                // WHERE VARS
                $this->whereQuery = false;
                $this->whereParams = array();
                $this->whereParamsCount = 0;
        }
		function __destruct(){
            parent::__destruct();
        }
        
        // NEW DB OPENING FUNCTION
        public static function open($tableName){
            return (DBConnection::chooseDatabase()->setTable($tableName));
        }
        
        // NOT NECESSARY FUNCTIONS
		public function getTableStructure($table){
			$query = "SHOW COLUMNS FROM {$table}";
            $res = $this->executeRes($query, false, false);
			if($res !== false){
                /*
				foreach($res as $res){
					$this->tableStructure[$i] = $this->fetchAssocStored();
					$this->tableStructureColumns[$i] = $this->tableStructure[$i]['Field'];
				}*/
                return ($res);
			}
            return (false);
		}
        
        
        // GENERAL FUNCTIONS
        private function resetQuery($res){
            self::__construct($this->table);
            return ($res);
            /*
            if($res){
                self::__construct($this->table);
            }
            return ($this);
            */
        }
        
        // SELECT FUNCTIONS
        public function select(){
            $this->selectQuery = "SELECT ";
            for($i=0;$i<func_num_args();$i++){
                if($i!=0){
                    $this->selectQuery .= ", ";
                }
                $this->selectQuery .= func_get_arg($i);
            }
            $this->selectQuery .= " FROM {$this->table}";
            return ($this);
        }
        public function get($column = false){
            if($this->selectQuery !== false){
                $query = $this->selectQuery;
            }else{
                $query = "SELECT ";
                if(!$column){
                    $query .= "*";
                }else{
                    $query .= $column;
                }
                $query .= " FROM {$this->table}";
            }
            if(!empty($this->tableJoinsQuery)){
                $query .= $this->tableJoinsQuery;
            }
            if($this->whereParamsCount>0){
                $query .= $this->whereQuery;
            }
            if($this->groupByCount>0){
                $query .= $this->groupByQuery;
                if($this->havingParamsCount>0){
                    $query .= $this->havingQuery;
                }
            }
            if($this->orderByCount>0){
                $query .= $this->orderByQuery;
            }
            if($this->limitQuery!==false){
                $query .= $this->limitQuery;
            }
            $params = array_merge($this->whereParams, $this->havingParams);
            $res = $this->executeRes($query, $params, false);
            return ($this->resetQuery($res));
        }
        
        public function limit($offset,$from=false){
            if(is_numeric($offset)){
                $this->limitQuery= ' LIMIT ' . $offset;
                if($from !==false && is_numeric($from)){
                    $this->limitQuery .= ' OFFSET ' . $from;
                }
            }
            return ($this);
        }
        
        /* */
        public function getItemsArray($itemName, $column = false){
            $res = $this->get($column);
            $newRes = array();
            $i = 0;
            foreach($res as $row){
                $newRes[$i][$itemName] = $row;
                $i++;
            }
            return ($newRes);
        }
        public function getItemArray($itemName, $column = false){
            $res = $this->getItemsArray($itemName, $column);
            $newRes = array();
            if(count($res)>0){
                $newRes[$itemName] = $res[0][$itemName];
            }
            return ($newRes);
        }
        /* */
        
        /*public function getRow($column = false){
            $res = $this->get($column);
            return ($res);
        }*/
        public function getValue($column){
            $res = $this->get($column);
            return ($res[$column]);
        }
            // ORDER BY FUNCTIONS
            public function orderBy($column, $order){
                if(($this->orderByCount++)<1){
                    $this->orderByQuery .= " ORDER BY ";
                }else{
                    $this->orderByQuery .= ", ";
                }
                $this->orderByQuery .= $column . " " . $order;
                return ($this);
            }
            // GROUP BY / HAVING FUNCTIONS
            public function groupBy($column){
                if(($this->groupByCount++)<1){
                    $this->groupByQuery .= " GROUP BY ";
                }else{
                    $this->groupByQuery .= ", ";
                }
                $this->groupByQuery .= $column;
                return ($this);
            }
            public function havingBuild($x, $op, $y, $str){
                $this->havingQuery .= " {$str} {$x}{$op}?";
                $this->havingParams[$this->havingParamsCount++] = $y;
            }
            public function having($x, $op, $y){
                $this->havingQuery = "";
                $this->havingBuild($x, $op, $y, "HAVING");
                return ($this);
            }
            public function orHaving($x, $op, $y){
                if($this->havingParamsCount>0){
                    $this->havingBuild($x, $op, $y, "OR");
                }
                return ($this);
            }
            public function andHaving($x, $op, $y){
                if($this->havingParamsCount>0){
                    $this->havingBuild($x, $op, $y, "AND");
                }
                return ($this);
            }
        
        // INSERT FUNCTIONS
        public function insert($assArray){
            $res = false;
            if(is_array($assArray)){
                $query = "INSERT INTO {$this->table}(";
                $i=0;
                $values = array();
                $howManyInsert = 1;
                $isMultiInsert = is_array((array_values($assArray)[0]));
                    /*
                    foreach($assArray as $arr){
                        $this->insert($arr);
                    }
                    */
                $arr = $assArray;
                if($isMultiInsert){
                    $arr = $assArray[0];
                }
                foreach($arr as $key => $value){
                    if($i!=0){
                        $query .= ", ";
                    }
                    $query .= $key;
                    if(!$isMultiInsert){
                        array_push($values, $value);
                    }
                    $i++;
                }
                if($isMultiInsert){
                    $howManyInsert = 0;
                    foreach($assArray as $assSubArray){
                        $howManyInsert++;
                        foreach($assSubArray as $key => $value){
                            array_push($values, $value);
                        }
                    }
                }
                $query .= ") VALUES";
                for($k=0;$k<$howManyInsert;$k++){
                    if($k>0){
                        $query .= ",";
                    }
                    $query .= " (";
                    for($j=0;$j<$i;$j++){
                        if($j!=0){
                            $query .= ", ";
                        }
                        $query .= "?";
                    }
                    $query .= ")";
                }
                $res = $this->executeRes($query, $values);
            }
            return ($this->resetQuery($res));
        }
        
        // DELETE FUNCTIONS
        public function delete(){
            $query = "DELETE FROM {$this->table}";
            if($this->whereParamsCount>0){
                $query .= $this->whereQuery;
            }
            $res = $this->executeRes($query, $this->whereParams);
            return ($this->resetQuery($res));
        }
            // TRUNCATE FUNCTIONS
            public function truncate(){
                $res = false;
                $query = "TRUNCATE TABLE {$this->table}";
                $affectedRows = $this->exec($query);
                if($affectedRows != 0){
                    $res = true;
                }
                return ($this->resetQuery($res));
            }
        
        // UPDATE FUNCTIONS
        public function update($assArray){
            $res = false;
            if(is_array($assArray)){
                $query = "UPDATE {$this->table} SET ";
                $i = 0;
                $params = array();
                foreach($assArray as $key => $value){
                    if($i!=0){
                        $query .= ", ";
                    }
                    $query .= $key . "=?";
                    array_push($params, $value);
                    $i++;
                }
                if($this->whereParamsCount>0){
                    $query .= $this->whereQuery;
                    $params = array_merge($params, $this->whereParams);
                }
                $res = $this->executeRes($query, $params);
            }
            return ($this->resetQuery($res));
        }
        public function increment($field, $amount = 1){
            $res = false;
            $query = "UPDATE {$this->table} SET {$field} = {$field} + {$amount}";
            if($this->whereParamsCount>0){
                $query .= $this->whereQuery;
                $res = $this->executeRes($query, $this->whereParams);
            }else{
                $affectedRows = $this->exec($query);
                if($affectedRows != 0){
                    $res = true;
                }
            }
            return ($this->resetQuery($res));
        }
        public function decrement($field, $amount = 1){
            return ($this->increment($field, -$amount));
        }
        
        // WHERE FUNCTIONS
        private function whereBuild($x, $op, $y, $str){
            $this->whereQuery .= " {$str} {$x}{$op}?";
            $this->whereParams[$this->whereParamsCount++] = $y;
        }
        public function where($x, $op, $y){
            $this->whereQuery = "";
            $this->whereBuild($x, $op, $y, "WHERE");
            return ($this);
        }
        public function orWhere($x, $op, $y){
            if($this->whereParamsCount>0){
                $this->whereBuild($x, $op, $y, "OR");
            }else{
                $this->where($x, $op, $y);
            }
            return ($this);
        }
        public function andWhere($x, $op, $y){
            if($this->whereParamsCount>0){
                $this->whereBuild($x, $op, $y, "AND");
            }else{
                $this->where($x, $op, $y);
            }
            return ($this);
        }
        public function whereArray($arr, $str='AND'){
            if(is_array($arr) && in_array($str, array('AND', 'OR'))){
                foreach($arr as $key => $value){
                    $this->{strtolower($str).'Where'}($key, '=', $value);
                }
            }
            return ($this);
        }
        
        // TABLE FUNCTIONS
        public function setTable($table){
            $this->table = $table;
            return ($this);
        }
        /*
        private function getTableStructure($table){
            try{
                $stmt = $this->query("SHOW COLUMNS FROM {$table}");
                $this->tableStructure = $stmt->fetchAll();
            }catch(PDOException $e){
                throw $e;
            }
            return ($this);
		}
        */
            // JOIN FUNCTIONS
            private function joinBuild(JoinClause $join, $x, $op, $y){
                if(is_callable($x)){
                    $x($join);
                }else{
                    $join->on($x, $op, $y);
                }
                $this->tableJoinsQuery .= $join->getQuery();
                return ($join);
            }
            public function join($table, $x, $op = false, $y = false){
                $join = new JoinClause($table, JoinClause::INNERJOIN);
                $join = $this->joinBuild($join, $x, $op, $y);
                return ($this);
            }
            public function leftJoin($table, $x, $op = false, $y = false){
                $join = new JoinClause($table, JoinClause::LEFTOUTERJOIN);
                $join = $this->joinBuild($join, $x, $op, $y);
                return ($this);
            }
            public function rightJoin($table, $x, $op = false, $y = false){
                $join = new JoinClause($table, JoinClause::RIGHTOUTERJOIN);
                $join = $this->joinBuild($join, $x, $op, $y);
                return ($this);
            }
		
        /*
        $dbh = new PDO("blahblah");
        $stmt = $dbh->prepare('SELECT * FROM users where username = :username');
        $stmt->execute( array(':username' => $_REQUEST['username']) );
        
        
		protected function isColumnNumeric($columnName){
			//echo "colonna ".$columnName."<br />";
			$index = array_search($columnName, $this->tableStructureColumns);
			$type = $this->tableStructure[$index]['Type'];
			if(strposarray($type, mysql::$mysqlNumericTypes)!==false){
				return (true);
			}
			return (false);
		}
        
		protected function calcTableAlias($table){
			$tableLength = strlen($table);
			if($tableLength>$this->getTableAliasLength()){$tableLength = $this->getTableAliasLength();}
			$tableAlias = substr($table, 0, $tableLength).substr($table, -($tableLength));
			return $tableAlias;
		}
		
		// GENERAL RESULTS FUNCTIONS
		public function printTableResults(){
			$rows = $this->getNumRowsStored();
			if($rows!=false){
				for($i=0;$i<$rows;$i++){
					$res[$i] = $this->fetchAssocStored();
				}
				if(!empty($res)){
					echo "<table style='width:100%;'>";
					echo "<tr>";
					$i=0;
					foreach($res[0] as $key => $value){
						$keys[$i++] = $key;
						echo "<td style='background:#ddd; border:1px solid black;'>";
						echo $key;
						echo "</td>";
					}
					echo "</tr>";
					for($i=0;$i<count($res);$i++){
						echo "<tr>";
						for($j=0;$j<count($res[0]);$j++){
							echo "<td style='border:1px solid black;'>";
							echo $res[$i][$keys[$j]];
							echo "</td>";
						}
						echo "</tr>";
					}
					echo "</table>";
				}else{
					echo "nessun valore nei risultati";
				}
			}
		}
        */
	}