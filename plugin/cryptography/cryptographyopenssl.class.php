<?php
    namespace plugin\cryptography;
    
    class CryptographyOpenSSL extends Cryptography{
        // VARIABLES
        private $firstKey = false;
        private $secondKey = false;
        
        // CONSTANTS
        const ENCODE_METHOD = 'AES-256-CBC';
        const FIRST_KEY_START = 0;
        const SECOND_KEY_START = 64;
        
        // CONSTRUCT FUNCTIONS
        function __construct($seed){
            parent::__construct($seed);
            $this->firstKey = substr($this->fullKey, CryptographyOpenSSL::FIRST_KEY_START, 64);
            $this->secondKey = substr($this->fullKey, CryptographyOpenSSL::SECOND_KEY_START, 16);
        }
        
        // ENCODE AND DECODE FUNCTIONS
        public function encodeBuilder($value){
            $output = openssl_encrypt($value, CryptographyOpenSSL::ENCODE_METHOD, $this->firstKey, 0, $this->secondKey);
            return (base64_encode($output));
        }
        public function decodeBuilder($value){
            return (openssl_decrypt(base64_decode($value), CryptographyOpenSSL::ENCODE_METHOD, $this->firstKey, 0, $this->secondKey));
        }
    }