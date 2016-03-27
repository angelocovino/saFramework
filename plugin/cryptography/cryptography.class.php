<?php
    namespace plugin\cryptography;

    class Cryptography{
       /**
        * Codifica il valore in ingresso utilizzando il seme (che di default e uguale alla key del progetto)
        * @private
        * @method static
        * @param {string} $valore chiave da codificare
        * @param {string} $seme = false seme
        * @return {string} valroe codificato
        */
        public static function encode($valore, $seme = SECURITY_KEY){ 
            $keyComplete = hash('sha512', $seme);
            $firstKey = substr($keyComplete, FIRST_KEY_START, 64);
            $secondKey = substr($keyComplete,SECOND_KEY_START,16);
            $output = openssl_encrypt($valore, ENCODE_METHOD, $firstKey, 0, $secondKey);
            return (base64_encode($output));
        }
        
       /**
        * Decodifica il valore in ingresso con il seme dato (che di default e uguale alla key del progetto)
        * @private
        * @method static
        * @param {string} $valore
        * @param {string} $seme = false
        * @return {string} valore decodificato
        */
        public static function decode($valore, $seme = SECURITY_KEY){ 
            $keyComplete = hash('sha512', $seme);
            $firstKey = substr($keyComplete, FIRST_KEY_START, 63);
            $secondKey = substr($keyComplete,SECOND_KEY_START,16);
            
            return (openssl_decrypt(base64_decode($valore), ENCODE_METHOD, $firstKey, 0, $secondKey));
        }
        
    }