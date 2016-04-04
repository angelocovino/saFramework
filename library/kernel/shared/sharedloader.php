<?php
    // LOAD SHARED CONSTANTS
    require_once(PATH_KERNEL_SHARED . 'constants.php');
    // LOAD SHARED FUNCTIONS
    require_once(PATH_KERNEL_SHARED . 'shared.php');
    
    // LOAD AUTOLOADER
    spl_autoload_register(__NAMESPACE__ . '\\autoloadNamespace');
    // SET ERRORS REPORTING
    setReporting();
    // PREVENT HIJACKING
    preventHijacking();
    // REMOVE MAGIC QUOTES
    removeMagicQuotes();
    // UNSET REGISTER GLOBALS
    unsetRegisterGlobals();
    // LOAD FRAMEWORK BUILDER
    $callRes = callBuilder($url);