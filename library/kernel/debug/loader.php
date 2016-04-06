<?php
    namespace library\kernel\debug;
    use library\kernel\debug\Debug;
    
    // LOAD ERROR CODES
    require_once(PATH_KERNEL_DEBUG . 'errors.php');
    
    // SET ERRORS REPORTING
    Debug::setReporting();