<?php
    namespace plugin\form;
    use plugin\form\FormBuilder;
    use plugin\form\FormInput;
    use plugin\form\FormLabel;
    
    abstract class Form{
        // LABEL FUNCTIONS
        public static function label($for, $value){
            echo (FormLabel::create($for, $value));
        }
        // INPUT FUNCTIONS
        public static function input($params = false){
            echo (FormInput::create($params));
        }
        private static function inputBuilder($type, $name, $placeholder = false){
            $params['type']=$type;
            $params['name']=$name;
            //if($value !== false){$params['value']=$value;}
            if($placeholder !== false){$params['placeholder']=$placeholder;}
            Form::input($params);
        }
            // SPECIFIED INPUT FUNCTIONS
            public static function text($name, $placeholder = false){
                Form::inputBuilder('text', $name, $placeholder);
            }
            public static function number($name, $placeholder = false){
                Form::inputBuilder('number', $name, $placeholder);
            }
            public static function password($name, $placeholder = false){
                Form::inputBuilder('password', $name, $placeholder);
            }
            public static function email($name, $placeholder = false){
                Form::inputBuilder('email', $name, $placeholder);
            }
            public static function submit($value = 'Submit'){
                $params['type']='submit';
                $params['value']=$value;
                Form::input($params);
            }
        
        // OPEN FORM FUNCTIONS
        public static function open($params){
            $form = new FormBuilder();
            if(is_array($params)){
                // FORM METHOD FETCH
                if(
                    array_key_exists('method', $params) && 
                    in_array($params['method'], FormBuilder::FORM_METHODS)
                ){
                    $form->setMethod($params['method']);
                }
                // FORM URL
                if(
                    array_key_exists('url', $params) && 
                    preg_match('/^[a-zA-Z0-9]+\.[a-zA-Z]{3,4}$/', $params['url'])
                ){
                    $form->setAction($params['url']);
                }
                // FORM ACTION
            }
            echo $form->build();
        }
        
        // CLOSE FORM FUNCTIONS
        public static function close(){echo "</form>";}
    }