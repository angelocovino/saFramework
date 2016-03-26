<?php
    namespace plugin\cryptography;

    class Cryptography{
        // CRYPTOGRPHY VARIABLES
        private $fullKey = false;
        private $firstKey = false;
        private $secondKey = false;
        
        function __construct($seed){
            $this->fullKey = hash('sha512', $seed);
            $this->firstKey = substr($this->fullKey, FIRST_KEY_START, 64);
            $this->secondKey = substr($this->fullKey, SECOND_KEY_START, 16);
        }
        
       /**
        * Codifica il valore in ingresso utilizzando il seme, che di default e uguale alla key del progetto
        * @param $valore chiave da codificare
        * @param $seme = false seme
        * @return valore codificato
        */
        public static function encode($valore, $seme = SECURITY_KEY){
            $cryptography = new Cryptography($seme);
            $output = openssl_encrypt($valore, ENCODE_METHOD, $cryptography->firstKey, 0, $cryptography->secondKey);
            return (base64_encode($output));
        }
        
       /**
        * Decodifica il valore in ingresso con il seme dato, che di default e uguale alla key del progetto
        * @param $valore
        * @param $seme = false
        * @return valore decodificato
        */
        public static function decode($valore, $seme = SECURITY_KEY){
            $cryptography = new Cryptography($seme);
            return (openssl_decrypt(base64_decode($valore), ENCODE_METHOD, $cryptography->firstKey, 0, $cryptography->secondKey));
        }
        
    }