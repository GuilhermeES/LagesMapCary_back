<?php

namespace MapcityBack\Middleware;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class TokenMiddleware implements IMiddleware
{
    public function handle(Request $request): void
   {
        $token = true;

        if ($token) {
            header("HTTP/1.0 401 Unauthorized");
            echo json_encode(["error" => "Unauthorized"]);
            exit;
        }
   }
}
