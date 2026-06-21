<?php
$router->get('/', [HomeController::class, 'index']);

$router->get('/test-db', [TestController::class, 'index']);

$router->get('/register', [AuthController::class, 'register']);

$router->post('/register', [AuthController::class, 'store']);

$router->get('/login', [AuthController::class, 'login']);

$router->post('/login', [AuthController::class, 'authenticate']);

$router->get(
    '/dashboard',
    [DashboardController::class, 'index']
);

$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/habits', [HabitController::class, 'index']);

$router->get('/habits/create', [HabitController::class, 'create']);

$router->post('/habits/store', [HabitController::class, 'store']);

$router->get('/habits/edit', [HabitController::class, 'edit']);

$router->post('/habits/update', [HabitController::class, 'update']);

$router->get('/habits/delete', [HabitController::class, 'delete']);

$router->get(
    '/habits/complete',
    [HabitController::class, 'complete']
);
?>