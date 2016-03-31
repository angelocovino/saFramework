<?php
    namespace plugin\db;
    use \PDO;
    
	abstract class DBConnection{
        // DATABASE VARS
            // DATABASE TYPE VARS
            protected $dbType;
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
			$this->dbHost = DB_HOST;
			$this->dbUser = DB_USER;
			$this->dbPwd = DB_PASSWORD;
			$this->dbName = DB_NAME;

            // CONNECTION VARS
			$this->dbConn = false;
			$this->dbIsConnActive = false;
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
                    $this->dbConn = new PDO("{$this->dbType}:host={$this->dbHost};dbname={$this->dbName}", $this->dbUser, $this->dbPwd);
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
            $this->connect();
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
			$this->disconnect();
            return $res;
        }
        protected function exec($query){
            $this->connect();
            $affectedRows = 0;
            try{
                $affectedRows = $this->dbConn->exec($query);
            }catch(PDOException $e){
                echo "Error:  " . $e->getMessage();
            }
			$this->disconnect();
            return ($affectedRows);
        }
        protected function query($query, $pdoFetchType = PDO::FETCH_ASSOC){
            $this->connect();
            $res = false;
            try{
                $res = $this->dbConn->query($query, $pdoFetchType);
            }catch(PDOException $e){
                echo "Error:  " . $e->getMessage();
            }
			$this->disconnect();
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