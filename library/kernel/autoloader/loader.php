<?php
    require_once(PATH_KERNEL_AUTOLOADER . 'autoloader.php');
    
    // LOAD AUTOLOADER
    spl_autoload_register(__NAMESPACE__ . '\\autoloadNamespace');