<?php
    // PATHS LOADER
    require_once(ROOT . DS . 'library' . DS . 'kernel' . DS . 'config' . DS . 'path.php');
    
    // NAMESPACE LOADER
    require_once(PATH_KERNEL_CONFIG . 'namespace.php');
    
    // HELPERS LOADER
    require_once(PATH_KERNEL_TEMP . 'helper.php');
    
    // CONFIGURATIONS LOADER
    require_once(PATH_CONFIG . 'config.php');
    
    // KERNEL LOADER
    require_once(PATH_KERNEL_SHARED . 'sharedloader.php');