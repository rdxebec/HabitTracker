<?php

class DashboardController extends Controller
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

        $habitModel = new Habit();
        $logModel = new HabitLog();
        $userModel = new User();
        $challengeModel = new DailyChallenge();
        $achievementModel = new Achievement();

        $recentAchievements =
            $achievementModel->getUserAchievements(
                $_SESSION['user_id']
            );

        $dailyChallenges =
            $challengeModel->getAll();

        $userChallenges = [];

        foreach ($dailyChallenges as $challenge) {

            $userChallenges[$challenge['id']] =
                $challengeModel->hasCompleted(
                    $_SESSION['user_id'],
                    $challenge['id']
                );
        }

        $user = $userModel->getById(
            $_SESSION['user_id']
        );

        $showLevelPopup =
            $user['level'] >
            $user['last_level_seen'];

        $currentXP = $user['xp'];

        $currentLevel = $user['level'];

        $xpForCurrentLevel =
            ($currentLevel - 1) * 100;

        $xpForNextLevel =
            $currentLevel * 100;

        $levelXP =
            $currentXP - $xpForCurrentLevel;

        $neededXP =
            $xpForNextLevel - $xpForCurrentLevel;

        $progressPercent =
            ($levelXP / $neededXP) * 100;

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
            'progressPercent' => $progressPercent,
            'levelXP' => $levelXP,
            'neededXP' => $neededXP,
            'currentLevel' => $currentLevel,
            'xpRemaining' =>
            $xpForNextLevel - $currentXP,
            'dailyChallenges' => $dailyChallenges,
            'userChallenges' => $userChallenges,
            'recentAchievements' =>
            $recentAchievements,
            'showLevelPopup' => $showLevelPopup,
            'user' => $user,

            // XP System
            'xp' => $user['xp'],
            'level' => $user['level'],
            'xpProgress' => $user['xp'] % 100
        ]);
    }

    public function analytics()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $logModel = new HabitLog();

        $monthlyData =
            $logModel->getMonthlyActivity(
                $_SESSION['user_id']
            );

        $this->view(
            'analytics/index',
            [
                'monthlyData' => $monthlyData
            ]
        );
    }

    public function profile()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $userModel = new User();
        $habitModel = new Habit();
        $logModel = new HabitLog();
        $achievementModel = new Achievement();

        $user =
            $userModel->findById(
                $_SESSION['user_id']
            );

        $totalHabits =
            $habitModel->countByUser(
                $_SESSION['user_id']
            );

        $totalCompletions =
            $logModel->countTotalCompletions(
                $_SESSION['user_id']
            );

        $longestStreak =
            $logModel->getLongestStreak(
                $_SESSION['user_id']
            );

        $achievements =
            count(
                $achievementModel->getUserAchievements(
                    $_SESSION['user_id']
                )
            );
        $recentAchievements =
            $achievementModel->getUserAchievements(
                $_SESSION['user_id']
            );

        $this->view(
            'profile/index',
            [
                'user' => $user,
                'totalHabits' => $totalHabits,
                'totalCompletions' => $totalCompletions,
                'longestStreak' => $longestStreak,
                'achievements' => $achievements,
                'recentAchievements' =>
                $recentAchievements
            ]
        );
    }

    public function hideLevelPopup()
    {
        if (!isset($_SESSION['logged_in'])) {
            exit;
        }

        $userModel = new User();

        $user =
            $userModel->getById(
                $_SESSION['user_id']
            );

        $userModel->updateLastLevelSeen(
            $_SESSION['user_id'],
            $user['level']
        );

        echo json_encode([
            'success' => true
        ]);
    }
    public function changePassword()
    {
        if (!isset($_SESSION['logged_in'])) {

            header(
                'Location: /habittracker/public/login'
            );

            exit;
        }

        $this->view(
            'profile/change-password'
        );
    }

    public function updatePassword()
    {
        if (!isset($_SESSION['logged_in'])) {

            header(
                'Location: /habittracker/public/login'
            );

            exit;
        }

        $currentPassword =
            $_POST['current_password'] ?? '';

        $newPassword =
            $_POST['new_password'] ?? '';

        $confirmPassword =
            $_POST['confirm_password'] ?? '';

        $userModel = new User();

        $user =
            $userModel->findById(
                $_SESSION['user_id']
            );

        if (
            !password_verify(
                $currentPassword,
                $user['password']
            )
        ) {

            $_SESSION['error'] =
                'Current password is incorrect';

            header(
                'Location: /habittracker/public/profile/password'
            );

            exit;
        }
        if (strlen($newPassword) < 8) {

            $_SESSION['error'] =
                'Password must be at least 8 characters';

            header(
                'Location: /habittracker/public/profile/password'
            );

            exit;
        }

        if (
            $newPassword !==
            $confirmPassword
        ) {

            $_SESSION['error'] =
                'Passwords do not match';

            header(
                'Location: /habittracker/public/profile/password'
            );

            exit;
        }

        $hash =
            password_hash(
                $newPassword,
                PASSWORD_DEFAULT
            );

        $userModel->updatePassword(
            $_SESSION['user_id'],
            $hash
        );

        $_SESSION['success'] =
            'Password updated successfully';

        header(
            'Location: /habittracker/public/profile/password'
        );

        exit;
    }
}
