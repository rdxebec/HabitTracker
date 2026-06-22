<?php

class DailyChallenge extends Model
{
    protected $table = 'daily_challenges';

    public function getAll()
    {
        $stmt = $this->db->query(
            "SELECT * FROM daily_challenges"
        );

        return $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );
    }
    public function hasCompleted($userId, $challengeId)
    {
        $sql = "
        SELECT id
        FROM user_challenges
        WHERE user_id = :user_id
        AND challenge_id = :challenge_id
        LIMIT 1
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId,
            ':challenge_id' => $challengeId
        ]);

        return $stmt->fetch();
    }

    public function completeChallenge($userId, $challengeId)
    {
        $sql = "
        INSERT INTO user_challenges
        (
            user_id,
            challenge_id,
            completed,
            completed_at
        )
        VALUES
        (
            :user_id,
            :challenge_id,
            1,
            NOW()
        )
    ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':user_id' => $userId,
            ':challenge_id' => $challengeId
        ]);
    }

    public function getChallenge($challengeId)
    {
        $sql = "
        SELECT *
        FROM daily_challenges
        WHERE id = :id
        LIMIT 1
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $challengeId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function awardChallengeXP($userId, $challengeId)
    {
        $challenge = $this->getChallenge($challengeId);

        if (!$challenge) {
            return;
        }

        $userModel = new User();

        $userModel->addXP(
            $userId,
            $challenge['xp_reward']
        );
    }
}
