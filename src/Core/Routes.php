<?php

use Pecee\SimpleRouter\SimpleRouter;

use MapcityBack\Middleware\TokenMiddleware;
use MapcityBack\Controller\DashboardController;
use MapcityBack\Controller\LoginController;

SimpleRouter::get('/login', [LoginController::class, 'login']);

SimpleRouter::group(['middleware' => TokenMiddleware::class], function () {
    SimpleRouter::get('/dashboard', [DashboardController::class, 'home']);
});

SimpleRouter::start();