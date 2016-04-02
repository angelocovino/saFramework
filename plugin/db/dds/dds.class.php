<?php
    namespace plugin\db\dds;
    use plugin\db\DBConnection;
    use \PDOException;
    
    abstract class DDS extends DBConnection{
        // EXECUTE DBMS FUNCTIONS
        private static function execute($query, $execCmp = 1){
            $ddl = DDS::chooseDatabase();
            try{
                if($ddl->exec($query, true) == $execCmp){
                    return true;
                }
            }catch(PDOException $e){
                var_dump($e);
            }
            return false;
        }
        private static function executeResults($query, $params, $isBoolRes = true, $execCmp = 1){
            $ddl = DDS::chooseDatabase();
            try{
                if(count($ddl->executeRes($query, $params, $isBoolRes, true, true)) == $execCmp){
                    return true;
                }
            }catch(PDOException $e){
                var_dump($e);
            }
            return false;
        }
        
        // DATABASE FUNCTIONS
        private static function checkDatabaseExists($dbName){
            return (DDS::executeResults("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", $dbName, false));
        }
        public static function createDatabase($dbName, $dropAndRecreate = false){
            if(!DDS::checkDatabaseExists($dbName)){
                if(DDS::execute("CREATE DATABASE ${dbName}")){
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
                if(DDS::executeResults("DROP DATABASE {$dbName}", false, true)){
                    return (!(DDS::checkDatabaseExists($dbName)));
                }
            }
            return false;
        }
        
        // TABLE FUNCTIONS
        private static function checkTableExists($dbName, $tableName){
            return (DDS::executeResults("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?", array($dbName, $tableName), false));
        }
/*
        public static function createTable($dbName, $tableName){
                if(DDS::execute("CREATE TABLE ${dbName}")){
                    return (DDS::checkDatabaseExists($dbName));
                }
            }else if($dropAndRecreate){
                if(DDS::dropDatabase($dbName)){
                    return (DDS::createDatabase($dbName, false));
                }
            }
            return false;
        }
*/
        public static function dropTable($dbName, $tableName){
            if(DDS::checkTableExists($dbName, $tableName)){
                if(DDS::executeResults("DROP TABLE {$tableName}", false, true)){
                    return (!(DDS::checkTableExists($dbName)));
                }
            }
            return false;
        }
    }