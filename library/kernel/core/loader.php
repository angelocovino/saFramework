<?php
    namespace library\kernel\core;
    use library\kernel\core\Dispatcher;
    use library\kernel\core\Dispatch;
    
/*
    if(CSRF_ENABLED === true){
        // CONTROLLARE SE SEI IN POST SE C'E' IL TOKEN
        
        // GENERO UN NUOVO TOKEN A PRESCINDERE
    }
*/
    
    
    // CREATE DISPATCHER
    $dispatch = Dispatch::create($url);
    
    // FREE $url
    unset($url);
    
    // SET DISPATCH SINGLETON
    Dispatcher::setDispatch($dispatch);
    
    // LOAD FRAMEWORK BUILDER
    Dispatcher::start();