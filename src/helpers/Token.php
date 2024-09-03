<?php

namespace MapcityBack\helpers;
use \Firebase\JWT\JWT;

class Token
{
    public function expire() {
        return time() + 3600;
    }

    public function generateToken() {
        $payload = [
            'iss' => 'http://localhost:5173/',
            'aud' => 'http://localhost:5173/',
            'iat' => time(),         
            'nbf' => time(),      
            'exp' => $this->expire(),
        ];
        return JWT::encode($payload, $_ENV['SECRET_KEY'], 'HS256');
    }
}
