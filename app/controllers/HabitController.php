<?php

class HabitController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $habitModel = new Habit();

        $habits = $habitModel->getByUserId(
            $_SESSION['user_id']
        );

        $search = trim($_GET['search'] ?? '');
        $priority = trim($_GET['priority'] ?? '');
        $category = trim($_GET['category'] ?? '');
        $frequency = trim($_GET['frequency'] ?? '');

        if (!empty($search)) {

            $habits = array_filter(
                $habits,
                function ($habit) use ($search) {

                    return stripos(
                        $habit['title'],
                        $search
                    ) !== false;
                }
            );
        }

        if (!empty($priority)) {

            $habits = array_filter(
                $habits,
                function ($habit) use ($priority) {

                    return strtolower(
                        $habit['priority']
                    ) === strtolower($priority);
                }
            );
        }

        if (!empty($category)) {

            $habits = array_filter(
                $habits,
                function ($habit) use ($category) {

                    return strtolower(
                        $habit['category']
                    ) === strtolower($category);
                }
            );
        }

        if (!empty($frequency)) {

            $habits = array_filter(
                $habits,
                function ($habit) use ($frequency) {

                    return strtolower(
                        $habit['frequency']
                    ) === strtolower($frequency);
                }
            );
        }

        $this->view('habits/index', [
            'habits' => $habits
        ]);
    }

    public function create()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] =
                bin2hex(random_bytes(32));
        }

        $this->view('habits/create');
    }

    public function store()
    {
        // Check login
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        // CSRF Validation
        if (
            !isset($_POST['csrf_token']) ||
            !hash_equals(
                $_SESSION['csrf_token'],
                $_POST['csrf_token']
            )
        ) {
            die('Invalid CSRF Token');
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $frequency = $_POST['frequency'] ?? 'daily';
        $priority = $_POST['priority'] ?? 'medium';

        $errors = [];

        if (empty($title)) {
            $errors[] = 'Title is required';
        }

        if (strlen($title) > 100) {
            $errors[] = 'Title too long';
        }

        if (!empty($errors)) {

            echo "<h2>Validation Errors</h2>";

            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }

            exit;
        }

        $habitModel = new Habit();

        $habitModel->create([
            'user_id' => $_SESSION['user_id'],
            'title' => htmlspecialchars($title),
            'description' => htmlspecialchars($description),
            'category' => htmlspecialchars($category),
            'frequency' => $frequency,
            'priority' => $priority
        ]);

        require_once __DIR__ . '/../models/Achievement.php';
        $achievementModel = new Achievement();

        $userHabits = $habitModel->getByUserId(
            $_SESSION['user_id']
        );

        $totalHabits = count($userHabits);

        if ($totalHabits >= 1) {

            if (
                !$achievementModel->hasAchievement(
                    $_SESSION['user_id'],
                    1
                )
            ) {
                $achievementModel->unlock(
                    $_SESSION['user_id'],
                    1
                );

                $_SESSION['achievement_notification'] =
                    '🏆 First Habit Unlocked!';
            }
        }
        if ($totalHabits >= 3) {

            if (
                !$achievementModel->hasAchievement(
                    $_SESSION['user_id'],
                    2
                )
            ) {

                $achievementModel->unlock(
                    $_SESSION['user_id'],
                    2
                );

                $_SESSION['achievement_notification'] =
                    '🏆 3 Habits Unlocked!';
            }
        }

        header('Location: /habittracker/public/habits');
        exit;
    }

    public function edit()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);

        $habitModel = new Habit();

        $habit = $habitModel->findById($id);

        if (
            !$habit ||
            $habit['user_id'] != $_SESSION['user_id']
        ) {
            die('Habit not found');
        }

        $this->view('habits/edit', [
            'habit' => $habit
        ]);
    }

    public function update()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);

        $habitModel = new Habit();

        $habitModel->updateHabit(
            $id,
            $_SESSION['user_id'],
            [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'category' => trim($_POST['category']),
                'frequency' => $_POST['frequency'],
                'priority' => $_POST['priority']
            ]
        );

        header('Location: /habittracker/public/habits');
        exit;
    }

    public function delete()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);

        $habitModel = new Habit();

        $habitModel->deleteHabit(
            $id,
            $_SESSION['user_id']
        );

        header('Location: /habittracker/public/habits');
        exit;
    }

    public function complete()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $habitId = (int)($_GET['id'] ?? 0);

        $habitModel = new Habit();

        $habit = $habitModel->findById($habitId);

        if (
            !$habit ||
            $habit['user_id'] != $_SESSION['user_id']
        ) {
            die('Habit not found');
        }

        $logModel = new HabitLog();

        if (!$logModel->isCompletedToday($habitId)) {

            $logModel->markComplete($habitId);

            $userModel = new User();

            $userModel->addXP(
                $_SESSION['user_id'],
                10
            );

            $user = $userModel->getById(
                $_SESSION['user_id']
            );

            $xp = $user['xp'];

            $level = floor($xp / 100) + 1;

            $userModel->updateLevel(
                $_SESSION['user_id'],
                $level
            );


            $achievementModel = new Achievement();



            $totalCompletions =
                $achievementModel->getUserCompletionCount(
                    $_SESSION['user_id']
                );

            if ($totalCompletions >= 100) {

                if (
                    !$achievementModel->hasAchievement(
                        $_SESSION['user_id'],
                        5
                    )
                ) {

                    $achievementModel->unlock(
                        $_SESSION['user_id'],
                        5
                    );

                    $_SESSION['achievement_notification'] =
                        '🏆 100 Completions!';
                }
            }

            $longestStreak =
                $logModel->getLongestUserStreak(
                    $_SESSION['user_id']
                );

            if ($longestStreak >= 7) {

                if (
                    !$achievementModel->hasAchievement(
                        $_SESSION['user_id'],
                        3
                    )
                ) {

                    $achievementModel->unlock(
                        $_SESSION['user_id'],
                        3
                    );

                    $_SESSION['achievement_notification'] =
                        '🏆 7 Day Streak!';
                }
            }

            if ($longestStreak >= 30) {

                if (
                    !$achievementModel->hasAchievement(
                        $_SESSION['user_id'],
                        4
                    )
                ) {

                    $achievementModel->unlock(
                        $_SESSION['user_id'],
                        4
                    );

                    $_SESSION['achievement_notification'] =
                        '🏆 30 Day Streak!';
                }
            }

            $challengeModel = new DailyChallenge();

            if (
                !$challengeModel->hasCompleted(
                    $_SESSION['user_id'],
                    3
                )
            ) {

                $challengeModel->completeChallenge(
                    $_SESSION['user_id'],
                    3
                );

                $userModel->addXP(
                    $_SESSION['user_id'],
                    10
                );
            }
        }

        header('Location: /habittracker/public/habits');
        exit;
    }

    public function history()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $habitId = (int)($_GET['id'] ?? 0);

        $habitModel = new Habit();

        $habit = $habitModel->findById($habitId);

        if (
            !$habit ||
            $habit['user_id'] != $_SESSION['user_id']
        ) {
            die('Habit not found');
        }

        $logModel = new HabitLog();

        $history =
            $logModel->getHabitHistory(
                $habitId
            );

        $currentStreak =
            $logModel->getHabitCurrentStreak(
                $habitId
            );

        $completionRate =
            $logModel->getHabitCompletionRate(
                $habitId
            );

        $this->view('habits/history', [
            'habit' => $habit,
            'history' => $history,
            'currentStreak' => $currentStreak,
            'completionRate' => $completionRate
        ]);
    }
}
