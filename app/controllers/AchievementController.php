<?php

class AchievementController extends Controller
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

        $achievementModel = new Achievement();

        $allAchievements =
            $achievementModel->getAllAchievements();

        $userAchievements =
            $achievementModel->getUserAchievements(
                $_SESSION['user_id']
            );

        $this->view(
            'achievements/index',
            [
                'allAchievements' => $allAchievements,
                'userAchievements' => $userAchievements,
                'achievementModel' => $achievementModel
            ]
        );
    }
}
