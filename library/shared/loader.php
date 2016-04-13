<?php
    // LOAD SHARED FUNCTIONS
    require_once(PATH_SHARED . 'shared.php');
    
    // LOAD SHARED FUNCTIONS
    require_once(PATH_SHARED . 'helper.php');
    
    // PREVENT HIJACKING
    preventHijacking();
    // REMOVE MAGIC QUOTES
    removeMagicQuotes();
    // UNSET REGISTER GLOBALS
    unsetRegisterGlobals();