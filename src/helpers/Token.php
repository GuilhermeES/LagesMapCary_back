<?php

namespace MapcityBack\helpers;
use \Firebase\JWT\JWT;

class Token
{
    private $secretKey = '84f6924f-7fd5-454f-a55a-1198a11b4319';

    public function expire() {
        return time() + 3600;
    }

    public function generateToken() {
        $expire = $this->expire(); 
        $payload = [
            'iss' => 'http://localhost:8000/',
            'aud' => 'http://localhost:8000/',
            'iat' => time(),         
            'nbf' => time(),      
            'exp' => $expire,
        ];
        return JWT::encode($payload, $this->secretKey, 'HS256');
    }
}
