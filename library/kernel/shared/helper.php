<?php
    // FUNCTION var_dump ENCLOSED IN A <pre> TAG
    function var_dump2($var){
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
        echo "<br />";
    }
    
    function requireFileIfExists($path){
        if(file_exists($path)){
            require_once($path);
            return true;
        }
        return false;
    }
    
    function getClassFromNamespace($class){
        $tempArr = explode("\\", $class);
        return (end($tempArr));
    }