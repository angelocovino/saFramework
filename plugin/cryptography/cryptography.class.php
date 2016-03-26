<?php
    namespace plugin\cryptography;
    use plugin\cryptography\CryptographyOpenSSL;
    
    abstract class Cryptography{
        // CRYPTOGRPHY VARIABLES
        protected $fullKey = false;
        
        function __construct($seed){
            $this->fullKey = hash('sha512', $seed);
        }
        
        abstract public function encodeBuilder($value);
        abstract public function decodeBuilder($value);
        
        // ENCODE AND DECODE FUNCTIONS
       /**
        * Codifica il valore in ingresso utilizzando il seme, che di default e uguale alla key del progetto
        * @param $valore chiave da codificare
        * @param $seme = false seme
        * @return valore codificato
        */
        public static function encode($value, $method = false, $seed = SECURITY_KEY){
            $cryptography = false;
            switch($method){
                default:
                case 'openssl':
                    $cryptography = new CryptographyOpenSSL($seed);
                    break;
            }
            return ($cryptography->encodeBuilder($value));
        }
        
       /**
        * Decodifica il valore in ingresso con il seme dato, che di default e uguale alla key del progetto
        * @param $valore
        * @param $seme = false
        * @return valore decodificato
        */
        public static function decode($value, $method = false, $seed = SECURITY_KEY){
            $cryptography = false;
            switch($method){
                default:
                case 'openssl':
                    $cryptography = new CryptographyOpenSSL($seed);
                    break;
            }
            return ($cryptography->decodeBuilder($value));
        }
    }