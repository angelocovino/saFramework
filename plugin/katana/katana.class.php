<?php
    namespace plugin\katana;
    
    class Katana{
        private $fileContent = false;
        function __construct(){
            
        }
        
        public static function convert(){
            $katana = new Katana();
            $katana->getFile();
            $katana->convertParenthesis();
        }
        
        private function getFile(){
            $this->fileContent = file_get_contents(PATH_VIEW . 'personas' . DS .  'provola.katana.php');
            //$section = file_get_contents(PATH_VIEW . 'personas' . DS .  'provola.katana.php', NULL, NULL, 20, 14);
            var_dump2($this->fileContent);
        }
        private function convertParenthesis(){
            $i = 0;
            $j = 0;
            $k = 1;
            $parentesi = explode('{{{', $this->fileContent);
            $tutto = $parentesi[0];
            while(strpos($parentesi[$k], '}}}') !== false){
                // CONTROLLA VALIDITA' CODICE INTERNO ??
                $porzione = explode('}}}', $parentesi[$k]);
                $tutto .= '<?php echo ' . $porzione[0] . '; ?>' . $porzione[1];
                */
                /*
                for($i=1; $i<count($parentesi); $i++){
                    $parentesi[$i] = explode('}}}', $parentesi[$i]);
                    $parentesi[$i][0] = trim($parentesi[$i][0]);
                    $parentesi[$i][0] = "<?php echo $" . $parentesi[$i][0];
                    $parentesi[$i][0] = $parentesi[$i][0] . '; ?>';
                    for($j=0; $j<2; $j++){
                        $parentesi[$i][$j] = htmlspecialchars($parentesi[$i][$j]);
                    }
                    $parentesi[$i] = implode('', $parentesi[$i]);
                }
                $parentesi = implode('', $parentesi);
                */
            }
            var_dump2($tutto);
        }
    }