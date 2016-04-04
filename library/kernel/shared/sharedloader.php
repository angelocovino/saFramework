<?php
    require_once(PATH_KERNEL_SHARED . 'constants.php');
    require_once(PATH_KERNEL_SHARED . 'shared.php');
    
    //spl_autoload_register(__NAMESPACE__ . '\\autoloadLibrary');
    //spl_autoload_register(__NAMESPACE__ . '\\autoloadModel');
    //spl_autoload_register(__NAMESPACE__ . '\\autoloadController');
    spl_autoload_register(__NAMESPACE__ . '\\autoloadNamespace');

    setReporting();
    preventHijacking();
    removeMagicQuotes();
    unsetRegisterGlobals();
    $callRes = callBuilder($url);