<?php
    // LOAD SHARED FUNCTIONS
    require_once(PATH_KERNEL_SHARED . 'shared.php');
    
    // LOAD SHARED FUNCTIONS
    require_once(PATH_KERNEL_SHARED . 'helper.php');
    
    // PREVENT HIJACKING
    preventHijacking();
    // REMOVE MAGIC QUOTES
    removeMagicQuotes();
    // UNSET REGISTER GLOBALS
    unsetRegisterGlobals();