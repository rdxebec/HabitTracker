<?php

class DashboardController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $habitModel = new Habit();
        $logModel = new HabitLog();
        $userModel = new User();

        $user = $userModel->getById(
            $_SESSION['user_id']
        );

        $totalHabits = $habitModel->countByUser(
            $_SESSION['user_id']
        );

        $completedToday =
            $logModel->countCompletedToday(
                $_SESSION['user_id']
            );

        $successRate =
            $logModel->getSuccessRate(
                $_SESSION['user_id']
            );

        $recentHabits =
            $habitModel->getRecentHabits(
                $_SESSION['user_id']
            );

        $activeStreaks =
            $logModel->getActiveStreaksCount(
                $_SESSION['user_id']
            );

        $longestStreak =
            $logModel->getLongestStreak(
                $_SESSION['user_id']
            );

        $weeklyCompletions =
            $logModel->getWeeklyCompletions(
                $_SESSION['user_id']
            );

        $weeklyActivity =
            $logModel->getWeeklyActivity(
                $_SESSION['user_id']
            );

        $this->view('dashboard', [
            'totalHabits' => $totalHabits,
            'completedToday' => $completedToday,
            'successRate' => $successRate,
            'recentHabits' => $recentHabits,
            'activeStreaks' => $activeStreaks,
            'longestStreak' => $longestStreak,
            'weeklyCompletions' => $weeklyCompletions,
            'weeklyActivity' => $weeklyActivity,

            // XP System
            'xp' => $user['xp'],
            'level' => $user['level'],
            'xpProgress' => $user['xp'] % 100
        ]);
    }
}