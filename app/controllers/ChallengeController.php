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

        $joined = [];

        foreach ($challenges as $challenge) {

            $completed =
                $challengeModel->hasCompleted(
                    $_SESSION['user_id'],
                    $challenge['id']
                );

            if ($completed) {

                $joined[$challenge['id']] = true;
            } else {

                $joined[$challenge['id']] = false;
            }
        }

        $this->view(
            'challenges/index',
            [
                'challenges' => $challenges,
                'joined' => $joined
            ]
        );
    }

    public function join()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $challengeId =
            (int)($_GET['id'] ?? 0);

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
