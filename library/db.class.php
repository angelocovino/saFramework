<?php
	abstract class mysql{
        // DATABASE VARS
            // CREDENTIALS VARS
            private $dbHost;
            private $dbUser;
            private $dbPwd;
            private $dbName;

            // CONNECTION VARS
            private $dbConn;
            private $dbIsConnActive;
        
        /*
		// VARIABILI STATICHE DI SUPPORTO
		protected static $mysqlNumericType = array(
			"tinyint",
			"smallint",
			"mediumint",
			"int",
			"bigint",
			"float",
			"double",
			"decimal"
			);
        */
        
		// CONSTRUCT AND DESTRUCT FUNCTIONS
		function __construct(){
            // CREDENTIALS VARS
			$this->dbHost = "localhost";
			$this->dbUser = "angelotm";
			$this->dbPwd = "olegnatm";
			$this->dbName = "prove";
            
            // CONNECTION VARS
			$this->dbConn = false;
			$this->dbIsConnActive = false;
            
            // CONNECTION
            $this->connect();
		}
		function __destruct(){
            // DISCONNECTION
			$this->disconnect();
        }
		
		// CONNECTION AND DISCONNECTION FUNCTIONS
		private function isConnected(){
            return ($this->dbIsConnActive);
        }
		private function connect(){
			if(!($this->isConnected())){
                try{
                    $this->dbConn = new PDO("mysql:host={$this->dbHost};dbname={$this->dbName}", $this->dbUser, $this->dbPwd);
                    $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $this->dbConn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
					$this->dbIsConnActive = true;
                }catch(PDOException $e){
                    echo "Error:  " . $e->getMessage();
                }
			}
		}
		private function disconnect(){
			if($this->isConnected()){
                $this->dbConn = null;
				$this->dbIsConnActive = false;
			}
		}
        
        // PDO FUNCTIONS
        protected function executeRes($query, $params, $isBoolRes = true, $transaction = true){
            $res = false;
            try{
                if($transaction){
                    $this->dbConn->beginTransaction();
                }
                $stmt = $this->prepareStmt($query);
                //echo $query . "<br />";
                //print_r($params);
                $stmt = $this->bindParams($stmt, $params);
                $res = $stmt->execute();
                if(!$isBoolRes){
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                if($transaction){
                    $this->dbConn->commit();
                }
            }catch(PDOException $e){
                if($transaction){
                    $this->dbConn->rollback();
                }
                echo "Error:  " . $e->getMessage();
            }
            return $res;
        }
        protected function exec($query){
            $affectedRows = 0;
            try{
                $affectedRows = $this->dbConn->exec($query);
            }catch(PDOException $e){
                echo "Error:  " . $e->getMessage();
            }
            return ($affectedRows);
        }
        protected function query($query, $pdoFetchType = PDO::FETCH_ASSOC){
            $res = false;
            try{
                $res = $this->dbConn->query($query, $pdoFetchType);
            }catch(PDOException $e){
                echo "Error:  " . $e->getMessage();
            }
            return ($res);
        }
            // STATEMENT FUNCTIONS
            protected function prepareStmt($prepare){
                try{
                    $stmt = $this->dbConn->prepare($prepare);
                }catch(PDOException $e){
                    echo "Error:  " . $e->getMessage();
                }
                return ($stmt);
            }
            protected function bindParams($stmt, $params){
                try{
                    if(is_array($params)){
                        for($i=0;$i<count($params);$i++){
                            $stmt->bindParam(($i+1), $params[$i]);
                        }
                    }else{
                        $stmt->bindParam(1, $params);
                    }
                }catch(PDOException $e){
                    echo "Error:  " . $e->getMessage();
                }
                return ($stmt);
            }
	}

    class joinClause{
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
    
	class DB extends mysql{
        // TABLE VARS
		private $table;
        private $tableStructure;
        private $tableJoinsQuery;
        
        // SELECT VARS
        private $selectQuery;
            // ORDER BY VARS
            private $orderByQuery;
            private $orderByCount;
            // GROUP BY / HAVING VARS
            private $groupByQuery;
            private $groupByCount;
            private $havingQuery;
            private $havingParams;
            private $havingParamsCount;
        
        // WHERE VARS
        private $whereQuery;
        private $whereParams;
        private $whereParamsCount;
        
		// CONSTRUCT AND DESTRUCT FUNCTIONS
        function __construct(){
			parent::__construct();
            //$this->table = $table;
            $this->tableStructure = false;
            $this->tableJoinsQuery = "";
            
            $this->selectQuery = false;
            $this->orderByQuery = "";
            $this->orderByCount = 0;
            $this->groupByQuery = "";
            $this->groupByCount = 0;
            $this->havingQuery = false;
            $this->havingParams = array();
            $this->havingParamsCount = 0;
            
            $this->whereQuery = false;
            $this->whereParams = array();
            $this->whereParamsCount = 0;
        }
		function __destruct(){
            parent::__destruct();
        }
        
        // GENERAL FUNCTIONS
        private function resetQuery($res = false){
            if($res){
                self::__construct($this->table);
            }
            return ($this);
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
            if($this->orderByCount>0){
                $query .= $this->orderByQuery;
            }
            if($this->groupByCount>0){
                $query .= $this->groupByQuery;
                if($this->havingParamsCount>0){
                    $query .= $this->havingQuery;
                }
            }
            $params = array_merge($this->whereParams, $this->havingParams);
            $res = $this->executeRes($query, $params, false);
            if($res){
                $this->resetQuery(true);
            }
            //var_dump($res);
            return ($res);
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
            $newRes[$itemName] = $res[0][$itemName];
            return ($newRes);
        }
        /* */
        
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
            }
            return ($this);
        }
        public function andWhere($x, $op, $y){
            if($this->whereParamsCount>0){
                $this->whereBuild($x, $op, $y, "AND");
            }
            return ($this);
        }
        
        // TABLE FUNCTIONS
        public function setTable($table){
            $this->table = $table;
        }
        private function getTableStructure($table){
            try{
                $stmt = $this->query("SHOW COLUMNS FROM {$table}");
                $this->tableStructure = $stmt->fetchAll();
            }catch(PDOException $e){
                echo "Error:  " . $e->getMessage();
            }
            return ($this);
		}
            // JOIN FUNCTIONS
            private function joinBuild(joinClause $join, $x, $op, $y){
                if(is_callable($x)){
                    $x($join);
                }else{
                    $join->on($x, $op, $y);
                }
                $this->tableJoinsQuery .= $join->getQuery();
                return ($join);
            }
            public function join($table, $x, $op = false, $y = false){
                $join = new joinClause($table, joinClause::INNERJOIN);
                $join = $this->joinBuild($join, $x, $op, $y);
                return ($this);
            }
            public function leftJoin($table, $x, $op = false, $y = false){
                $join = new joinClause($table, joinClause::LEFTOUTERJOIN);
                $join = $this->joinBuild($join, $x, $op, $y);
                return ($this);
            }
            public function rightJoin($table, $x, $op = false, $y = false){
                $join = new joinClause($table, joinClause::RIGHTOUTERJOIN);
                $join = $this->joinBuild($join, $x, $op, $y);
                return ($this);
            }
		
        /*
        $dbh = new PDO("blahblah");
        $stmt = $dbh->prepare('SELECT * FROM users where username = :username');
        $stmt->execute( array(':username' => $_REQUEST['username']) );
        
        
		protected function getTableStructure($table){
			$query = "SHOW COLUMNS FROM {$table}";
			$this->executeQuery($query);
			$rows = $this->getNumRowsStored();
			if($rows!=false){
				for($i=0;$i<$rows;$i++){
					$this->tableStructure[$i] = $this->fetchAssocStored();
					$this->tableStructureColumns[$i] = $this->tableStructure[$i]['Field'];
				}
			}
		}
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
?>