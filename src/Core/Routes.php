<?php

use Pecee\SimpleRouter\SimpleRouter;

use MapcityBack\Middleware\TokenMiddleware;
use MapcityBack\Controller\LoginController;
use MapcityBack\Controller\UserController;
use MapcityBack\Controller\IncidentsController;


SimpleRouter::post('/login', [LoginController::class, 'login']);
SimpleRouter::post('/register', [UserController::class, 'register']);

SimpleRouter::group(['middleware' => TokenMiddleware::class], function () {
    SimpleRouter::post('/incident', [IncidentsController::class, 'create']);
});

SimpleRouter::start();