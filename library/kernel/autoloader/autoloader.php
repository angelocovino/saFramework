<?php
    /**
     * AUTOLOAD CLASS FUNCTIONS
     * spl_autoload_register (PHP 5 >= 5.1.2)
     * @param $className NAME OF THE CLASS TO REQUIRE
     */
    function autoloadNamespace($className){
        $pathRoot = PATH_ROOT . strtolower($className) . '.class.php';
        if(!requireFileIfExists($pathRoot)){
            $pathRoot = PATH_ROOT . strtolower($className) . '.php';
            requireFileIfExists($pathRoot);
        }
    }