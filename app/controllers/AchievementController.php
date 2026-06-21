<?php

class AchievementController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $achievementModel = new Achievement();

        $achievements =
            $achievementModel->getUserAchievements(
                $_SESSION['user_id']
            );

        $this->view(
            'achievements/index',
            [
                'achievements' => $achievements
            ]
        );
    }
}