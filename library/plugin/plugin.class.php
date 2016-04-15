<?php
    namespace library\plugin;
    
    class Plugin{
        private $plugins;
        
        function __construct($plugins){
            $this->plugins = array_map('strtolower', $plugins);
        }
        
        public function get($pluginName){
            $pluginName = strtolower($pluginName);
            if(array_key_exists($pluginName, $this->plugins)){
                return ($this->plugins[$pluginName]);
            }
            return (false);
        }
        public function getAll(){
            return ($this->plugins);
        }
    }