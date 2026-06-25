<?php

class AnalyticsController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        // Prevent browser caching
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Pragma: no-cache");
        header("Expires: 0");

        $logModel = new HabitLog();
        $habitModel = new Habit();
        $userModel = new User();

        $xpHistory =
            $userModel->getXPHistory(
                $_SESSION['user_id']
            );

        $monthlyData =
            $logModel->getMonthlyActivity(
                $_SESSION['user_id']
            );

        $categoryStats =
            $habitModel->getCategoryStats(
                $_SESSION['user_id']
            );

        $topHabits =
            $habitModel->getTopHabits(
                $_SESSION['user_id']
            );

        $calendarData =
            $logModel->getCalendarData(
                $_SESSION['user_id']
            );

        $bestHabit =
            $habitModel->getBestHabit(
                $_SESSION['user_id']
            );

        $worstHabit =
            $habitModel->getWorstHabit(
                $_SESSION['user_id']
            );

        $this->view(
            'analytics/index',
            [
                'monthlyData' => $monthlyData,
                'categoryStats' => $categoryStats,
                'calendarData' => $calendarData,
                'topHabits' => $topHabits,
                'bestHabit' => $bestHabit,
                'worstHabit' => $worstHabit,
                'xpHistory' => $xpHistory
            ]
        );
    }

    public function day()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $date = $_GET['date'] ?? date('Y-m-d');

        $logModel = new HabitLog();

        $habits = $logModel->getHabitsByDate(
            $_SESSION['user_id'],
            $date
        );

        $this->view(
            'analytics/day',
            [
                'date' => $date,
                'habits' => $habits
            ]
        );
    }
}
