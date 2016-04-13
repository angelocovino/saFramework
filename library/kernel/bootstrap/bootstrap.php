<?php
    // PATHS LOADER
    require_once(ROOT . DS . 'library' . DS . 'kernel' . DS . 'config' . DS . 'path.php');
    
    // SHARED LOADER
    require_once(PATH_SHARED . 'loader.php');
    
    // AUTOLOAD LOADER
    require_once(PATH_KERNEL_AUTOLOADER . 'loader.php');
    
    // CONFIGURATIONS LOADER
    require_once(PATH_KERNEL_CONFIG . 'loader.php');
    
    // DEBUG LOADER
    require_once(PATH_KERNEL_DEBUG . 'loader.php');
    
    // CORE LOADER
    require_once(PATH_KERNEL_CORE . 'loader.php');