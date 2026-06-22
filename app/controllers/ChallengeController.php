<?php

class ChallengeController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/login');
            exit;
        }

        $challengeModel = new Challenge();

        $challenges =
            $challengeModel->getAll();

        $userChallenges =
            $challengeModel->getUserChallenges(
                $_SESSION['user_id']
            );

        $joined = [];

        foreach ($userChallenges as $challenge) {

            $joined[
                $challenge['challenge_id']
            ] = $challenge['completed'];
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