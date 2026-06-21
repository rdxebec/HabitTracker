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

    }

    header('Location: /habittracker/public/habits');
    exit;
}
}