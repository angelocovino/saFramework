<?php
    namespace plugin\db\ddlbuilder;
    use plugin\db\DBConnection;
    use \PDOException;
    
    abstract class DDLBuilder extends DBConnection{
        function __construct(){
            
        }
        private static function execute($query, $execCmp = 1){
            $ddl = DDLBuilder::chooseDatabase();
            try{
                if($ddl->exec($query, true) == $execCmp){
                    return true;
                }
            }catch(PDOException $e){
                var_dump($e);
            }
            return false;
        }
        public static function createDatabase($dbName, $dropAndRecreate = false){
            $res = DDLBuilder::execute("CREATE DATABASE ${dbName}");
            //var_dump2($res);
            /*
            if($dropAndRecreate && !$res){
                echo "elimino";
                $res2 = DDLBuilder::dropDatabase($dbName);
                var_dump2($res2);
                if($res2){
                    echo "ricreo";
                    $res = DDLBuilder::createDatabase($dbName);
                }
            }
            */
            return ($res);
        }
        /*
        public static function dropDatabase($dbName){
            return (DDLBuilder::execute("DROP DATABASE ${dbName}"));
        }
        */
    }