<?php
    // 008fc4ff
    namespace plugin\token;
    use plugin\cryptography\Cryptography;
    
    abstract class Token{
        public static function generate($length = 64){
            $seed = time() . $_SERVER['REMOTE_ADDR'] . openssl_random_pseudo_bytes($length);
            $seed = Cryptography::encode($seed, 'base64');
            return (substr($seed, 0, $length));
        }
    }