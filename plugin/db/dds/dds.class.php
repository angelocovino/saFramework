<?php
    namespace plugin\db\dds;
    use plugin\db\DBConnection;
    use plugin\db\ddl\DDL;
    use plugin\db\dds\table\DBTable;
    use \PDOException;
    
    // DATA DEFINITION STATEMENTS
    abstract class DDS extends DBConnection{
        // EXECUTE DBMS FUNCTIONS
        private static function execute($query, $isEmptyConnection = false, $execCmp = 1){
            $ddl = DDS::_chooseDatabase();
            try{
                if($ddl->_exec($query, $isEmptyConnection) == $execCmp){
                    return true;
                }
            }catch(PDOException $e){
                throw $e;
            }
            return false;
        }
        private static function ults($query, $params, $isBoolRes = true, $isEmptyConnection = false, $execCmp = 1){
            $ddl = DDS::_chooseDatabase();
            try{
                if(count($ddl->($query, $params, $isBoolRes, true, $isEmptyConnection)) == $execCmp){
                    return true;
                }
            }catch(PDOException $e){
                throw $e;
            }
            return false;
        }
        
        // DATABASE FUNCTIONS
        private static function checkDatabaseExists($dbName){
            return (DDS::ults("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", $dbName, false));
        }
        public static function createDatabase($dbName, $dropAndRecreate = false){
            if(!DDS::checkDatabaseExists($dbName)){
                if(DDS::execute(DDL::CREATE_DATABASE . " " . $dbName, true)){
                    return (DDS::checkDatabaseExists($dbName));
                }
            }else if($dropAndRecreate){
                if(DDS::dropDatabase($dbName)){
                    return (DDS::createDatabase($dbName, false));
                }
            }
            return false;
        }
        public static function dropDatabase($dbName){
            if(DDS::checkDatabaseExists($dbName)){
                if(DDS::ults(DDL::DROP_DATABASE . " " . $dbName, false, true, true)){
                    return (!(DDS::checkDatabaseExists($dbName)));
                }
            }
            return false;
        }
        
        // TABLE FUNCTIONS
        private static function checkTableExists($tableName){
            return (DDS::ults("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?", array(DB_NAME, $tableName), false));
        }
        public static function createTable(DBTable $table, $dropAndRecreate = false){
            try{
                $created = DDS::ults($table->build(), false);
            }catch(PDOException $e){
                switch($e->getCode()){
                    case DDL::CREATE_TABLE_ALREADY_EXISTS:
                        $created = false;
                        break;
                }
            }
            if($created){
                return (DDS::checkTableExists($table->getName()));
            }else if($dropAndRecreate){
                if(DDS::dropTable($table->getName())){
                    return (DDS::createTable($table, false));
                }
            }
            return false;
        }
        public static function dropTable($tableName){
            if(DDS::checkTableExists($tableName)){
                if(DDS::ults("DROP TABLE {$tableName}", false)){
                    return (!(DDS::checkTableExists($tableName)));
                }
            }
            return false;
        }
        
        //ALTER TABLE
        public static function alterTable($tableName){
            
        }
    }