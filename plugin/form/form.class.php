<?php
    namespace plugin\form;
    use plugin\form\FormBuilder;
    use plugin\form\FormInput;
    use plugin\form\FormLabel;
    use plugin\file\File;
    
    abstract class Form{
        // LABEL FUNCTIONS
        public static function label($for, $value){
            echo (FormLabel::create($for, $value));
        }
        // INPUT FUNCTIONS
        public static function input($params){
            echo "\t" . (FormInput::create($params)) . "\n";
        }
        private static function inputBuilder($type, $name, $placeholder, $value, $disabled){
            Form::input(compact('type', 'name', 'placeholder', 'value', 'disabled'));
        }
            // SPECIFIED INPUT FUNCTIONS
            public static function hidden($name, $value){
                $params['type']='hidden';
                $params['value']=$value;
                Form::input($params);
            }
            public static function text($name, $placeholder = false, $value = false, $disabled = false){
                Form::inputBuilder('text', $name, $placeholder, $value, $disabled);
            }
            public static function number($name, $placeholder = false, $value = false, $disabled = false){
                Form::inputBuilder('number', $name, $placeholder, $value, $disabled);
            }
            public static function password($name, $placeholder = false, $value = false, $disabled = false){
                Form::inputBuilder('password', $name, $placeholder, $value, $disabled);
            }
            public static function email($name, $placeholder = false, $value = false, $disabled = false){
                Form::inputBuilder('email', $name, $placeholder, $value, $disabled);
            }
            public static function submit($value = 'Submit'){
                $params['type']='submit';
                $params['value']=$value;
                Form::input($params);
            }
        
        // OPEN FORM FUNCTIONS
        public static function open($params = false){
            $form = new FormBuilder();
            if(is_array($params)){
                // FORM METHOD FETCH
                if(
                    array_key_exists('method', $params) && 
                    in_array($params['method'], FormBuilder::$FORM_METHODS)
                ){
                    $form->setMethod($params['method']);
                }
                // FORM URL
                if(
                    array_key_exists('url', $params)
                    //&& 
                    //preg_match('/^[a-zA-Z0-9]+\.[a-zA-Z]{3,4}$/', $params['url'])
                ){
                    $form->setAction($params['url']);
                    //$form->setAction(File::pathParse($params['url'], false)->getFullName());
                }
                // FORM ACTION
            }
            echo $form->build();
        }
        
        // CLOSE FORM FUNCTIONS
        public static function close(){echo "</form>\n";}
    }