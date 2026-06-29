<?php

class ChallengeController extends Controller
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

        $challengeModel = new DailyChallenge();

        $challenges = $challengeModel->getAll();

        $dailyChallenge = new DailyChallenge();

        $joined = [];

        foreach ($challenges as $challenge) {

            $joined[$challenge['id']] =
                $dailyChallenge->completedToday(
                    $_SESSION['user_id'],
                    $challenge['id']
                );
        }

        $this->view(
            'challenges/index',
            [
                'challenges' => $challenges,
                'joined' => $joined
            ]
        );
    }
    // Check login

    public function join()
    {

        // CSRF validation
        if (
            !isset($_POST['csrf_token']) ||
            !hash_equals(
                $_SESSION['csrf_token'],
                $_POST['csrf_token']
            )
        ) {
            die('Invalid CSRF Token');
        }

        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $challengeId =
            (int)($_POST['challenge_id'] ?? 0);

        $challengeModel =
            new Challenge();

        $challengeModel->joinChallenge(
            $_SESSION['user_id'],
            $challengeId
        );

        header(
            'Location: /habittracker/public/challenges'
        );
        exit;
    }
}
