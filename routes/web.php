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

$router->get(
    '/dashboard/hideLevelPopup',
    [DashboardController::class,'hideLevelPopup']
);

$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/habits', [HabitController::class, 'index']);

$router->get('/habits/create', [HabitController::class, 'create']);

$router->post('/habits/store', [HabitController::class, 'store']);

$router->get('/habits/edit', [HabitController::class, 'edit']);

$router->post('/habits/update', [HabitController::class, 'update']);

$router->post('/habits/delete', [HabitController::class, 'delete']);

$router->post(
    '/habits/complete',
    [HabitController::class, 'complete']
);

$router->get('/achievements', [AchievementController::class, 'index']);

$router->get(
    '/templates',
    [TemplateController::class, 'index']
);

$router->get(
    '/templates/use',
    [TemplateController::class, 'use']
);

$router->get(
    '/challenges',
    [ChallengeController::class, 'index']
);
$router->get(
    '/challenges/join',
    [ChallengeController::class, 'join']
);

$router->get(
    '/habits/history',
    [HabitController::class, 'history']
);

$router->get(
    '/analytics',
    [AnalyticsController::class, 'index']
);

$router->get(
    '/profile',
    [DashboardController::class, 'profile']
);

$router->get(
    '/analytics/day',
    [AnalyticsController::class,'day']
);

$router->get(
    '/profile/password',
    [DashboardController::class, 'changePassword']
);

$router->post(
    '/profile/password',
    [DashboardController::class, 'updatePassword']
);