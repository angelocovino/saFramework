<?php
    namespace plugin\cryptography;
    use plugin\cryptography\CryptographyOpenSSL;
    
    abstract class Cryptography{
        // CRYPTOGRPHY VARIABLES
        protected $fullKey = false;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        function __construct($seed){
            $this->fullKey = hash('sha512', $seed);
        }
        
        // ENCODE AND DECODE FUNCTION NEEDED BY SUBCLASSES
        abstract public function encodeBuilder($value);
        abstract public function decodeBuilder($value);
        
        // ENCODE AND DECODE FUNCTIONS
       /**
        * Builder for encode and decode functions
        * @param $method the encoding/decoding method
        * @param $seed the seed for the encoding/decoding
        * @return the selected encode/decode object
        */
        protected static function cryptographyBuiler($method, $seed){
            $cryptography = false;
            switch($method){
                default:
                case 'openssl':
                    $cryptography = new CryptographyOpenSSL($seed);
                    break;
            }
            return ($cryptography);
        }
       /**
        * Encode value using the seed that is by default the project's key
        * @param $value the value to encode
        * @param $method the encoding method
        * @param $seed the seed for the encoding
        * @return the encoded value
        */
        public static function encode($value, $method = false, $seed = SECURITY_KEY){
            return (Cryptography::cryptographyBuiler($method, $seed)->encodeBuilder($value));
        }
        
       /**
        * Decode value using the seed that is by default the project's key
        * @param $value the value to decode
        * @param $method the decoding method
        * @param $seed the seed for the decoding
        * @return the decoded value
        */
        public static function decode($value, $method = false, $seed = SECURITY_KEY){
            return (Cryptography::cryptographyBuiler($method, $seed)->decodeBuilder($value));
        }
    }