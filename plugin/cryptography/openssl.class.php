<?php
    namespace plugin\cryptography;
    
    class OpenSSL extends Cryptography{
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
            $this->firstKey = substr($this->fullKey, OpenSSL::FIRST_KEY_START, 64);
            $this->secondKey = substr($this->fullKey, OpenSSL::SECOND_KEY_START, 16);
        }
        
        // ENCODE AND DECODE FUNCTIONS
        public function encodeBuilder($value){
            return (openssl_encrypt($value, OpenSSL::ENCODE_METHOD, $this->firstKey, 0, $this->secondKey));
        }
        public function decodeBuilder($value){
            return (openssl_decrypt($value, OpenSSL::ENCODE_METHOD, $this->firstKey, 0, $this->secondKey));
        }
    }