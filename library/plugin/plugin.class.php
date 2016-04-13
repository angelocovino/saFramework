<?php
    namespace library\plugin;
    
    class Plugin{
        private $plugins;
        function __construct($plugins){
            $this->plugins = $plugins;
        }
        public function ciao(){
            echo "ciao";
        }
    }