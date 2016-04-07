<?php
    namespace library\tag;
    
    abstract class Tag{
        function construct(){
            $methods = get_class_methods($this);
            foreach($methods as $method){
                $this->{$method}();
            }
        }
    }