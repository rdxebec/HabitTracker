<?php

class TemplateController extends Controller
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

        $templateModel = new Template();

        $templates =
            $templateModel->getAll();

        $this->view(
            'templates/index',
            [
                'templates' => $templates
            ]
        );
    }

    public function use()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $templateId = (int)($_GET['id'] ?? 0);

        // Invalid ID
        if ($templateId <= 0) {
            $_SESSION['achievement_notification'] =
                "❌ Invalid template.";

            header('Location: /habittracker/public/templates');
            exit;
        }

        $templateModel = new Template();
        $habitModel = new Habit();

        $templateHabits = $templateModel->getHabits($templateId);

        // Template doesn't exist
        if (empty($templateHabits)) {
            $_SESSION['achievement_notification'] =
                "❌ Template not found.";

            header('Location: /habittracker/public/templates');
            exit;
        }

        $imported = 0;

        foreach ($templateHabits as $templateHabit) {

            if (
                !$habitModel->existsByTitle(
                    $_SESSION['user_id'],
                    $templateHabit['title']
                )
            ) {

                $habitModel->create([
                    'user_id' => $_SESSION['user_id'],
                    'title' => $templateHabit['title'],
                    'description' => $templateHabit['description'],
                    'category' => 'Template',
                    'frequency' => 'daily',
                    'priority' => 'medium'
                ]);

                $imported++;
            }
        }

        if ($imported > 0) {

            $_SESSION['achievement_notification'] =
                "✅ Successfully imported {$imported} habits.";
        } else {

            $_SESSION['achievement_notification'] =
                "⚠️ All habits from this template already exist.";
        }

        header('Location: /habittracker/public/habits');
        exit;
    }
}
