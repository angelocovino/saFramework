<?php
    // PATH CONSTANTS
    define('PATH_ROOT', ROOT . DS);
    define('PATH_CONFIG', PATH_ROOT . 'config' . DS);
    define('PATH_LIBRARY', PATH_ROOT . 'library' . DS);
        define('PATH_KERNEL', PATH_LIBRARY . 'kernel' . DS);
            define('PATH_KERNEL_AUTOLOADER', PATH_KERNEL . 'autoloader' . DS);
            define('PATH_KERNEL_BOOTSTRAP', PATH_KERNEL . 'bootstrap' . DS);
            define('PATH_KERNEL_CORE', PATH_KERNEL . 'core' . DS);
            define('PATH_KERNEL_CONFIG', PATH_KERNEL . 'config' . DS);
            define('PATH_KERNEL_DEBUG', PATH_KERNEL . 'debug' . DS);
            define('PATH_KERNEL_TEMP', PATH_KERNEL . 'temp' . DS);
        define('PATH_SHARED', PATH_LIBRARY . 'shared' . DS);
    define('PATH_APPLICATION', PATH_ROOT . 'application' . DS);
        define('PATH_CONTROLLERS', PATH_APPLICATION . 'controllers' . DS);
        define('PATH_MODELS', PATH_APPLICATION . 'models' . DS);
        define('PATH_VIEW', PATH_APPLICATION . 'views' . DS);
    define('PATH_DATABASE', PATH_ROOT . 'database' . DS);
    define('PATH_PLUGIN', PATH_ROOT . 'plugin' . DS);
    define('PATH_STORAGE', PATH_ROOT . 'storage' . DS);
        define('PATH_STORAGE_LOGS', PATH_STORAGE . 'logs' . DS);
        define('PATH_STORAGE_VIEWS', PATH_STORAGE . 'views' . DS);