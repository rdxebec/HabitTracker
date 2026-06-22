<?php

class AnalyticsController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $logModel = new HabitLog();
        $habitModel = new Habit();

        $monthlyData =
            $logModel->getMonthlyActivity(
                $_SESSION['user_id']
            );

        $categoryStats =
            $habitModel->getCategoryStats(
                $_SESSION['user_id']
            );

        $this->view(
            'analytics/index',
            [
                'monthlyData' => $monthlyData,
                'categoryStats' => $categoryStats
            ]
        );
    }
}