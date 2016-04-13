<?php
    namespace plugin\cryptography;
    
    class Base64 extends Cryptography{
        // ENCODE AND DECODE FUNCTIONS
        public function encodeBuilder($value){
            return (base64_encode($value));
        }
        public function decodeBuilder($value){
            return (base64_decode($value));
        }
    }