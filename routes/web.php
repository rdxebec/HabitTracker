<?php
$router->get('/', [HomeController::class, 'index']);

$router->get('/test-db', [TestController::class, 'index']);

$router->get('/register', [AuthController::class, 'register']);

$router->post('/register', [AuthController::class, 'store']);
?>