<?php
    namespace plugin\db\ddl;
    
    // DATA DEFINITION LANGUAGE
    abstract class DDL{
        // CREATE CONSTANTS
        const CREATE_DATABASE = "CREATE DATABASE";
        const CREATE_TABLE = "CREATE TABLE";
        // DROP CONSTANTS
        const DROP_DATABASE = "DROP DATABASE";
        const DROP_TABLE = "DROP TABLE";
        
        // ERRORS
            // MYSQL
                // TABLES
                const CREATE_TABLE_ALREADY_EXISTS = '42S01';
    }