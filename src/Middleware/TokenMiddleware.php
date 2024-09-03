<?php

namespace MapcityBack\Middleware;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

use Exception;

class TokenMiddleware implements IMiddleware
{

    public function handle(Request $request): void
    {
        $token = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : null;

        if ($token) {
            preg_match('/Bearer\s(\S+)/', $token, $matches);
            $only_token = $matches[1]; 

            try{
                JWT::decode($only_token, new Key($_ENV['SECRET_KEY'], 'HS256'));
                return;
            }
            catch (Exception) {
                header("HTTP/1.0 401 Unauthorized");
                echo json_encode(["error" => "Unauthorized token"]);
                exit;
            }
        }
        else{
            header("HTTP/1.0 401 Unauthorized");
            echo json_encode(["error" => "Unauthorized"]);
            exit;
        }
   }
}
