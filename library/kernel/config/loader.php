<?php
    namespace library\kernel\config;
    use library\kernel\config\Config;
    
    // NAMESPACE LOADER
    require_once(PATH_KERNEL_CONFIG . 'namespace.php');
    
    // SET ERRORS REPORTING
    Config::parseINIFile(PATH_CONFIG . 'config.ini', true)
        ->defineConfig()
        ->defineCheck(PATH_KERNEL_CONFIG . 'default.ini');