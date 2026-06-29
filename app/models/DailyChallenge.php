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
        $stmt = $this->db->prepare("
        SELECT id
        FROM user_challenges
        WHERE user_id = ?
        AND challenge_id = ?
        AND DATE(completed_at) = CURDATE()
        LIMIT 1
    ");

        $stmt->execute([
            $userId,
            $challengeId
        ]);

        return (bool)$stmt->fetch();
    }
    public function completeChallenge($userId, $challengeId)
    {
        $stmt = $this->db->prepare("
        UPDATE user_challenges
        SET
            completed = 1,
            completed_at = NOW()
        WHERE
            user_id = ?
        AND
            challenge_id = ?
    ");

        return $stmt->execute([
            $userId,
            $challengeId
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

    public function completedToday($userId, $challengeId)
    {
        $sql = "
        SELECT id
        FROM challenge_logs
        WHERE user_id = ?
        AND challenge_id = ?
        AND DATE(completed_at) = CURDATE()
        LIMIT 1
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $challengeId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function logCompletion($userId, $challengeId)
    {
        $sql = "
        INSERT INTO challenge_logs
        (
            user_id,
            challenge_id,
            completed_at
        )
        VALUES
        (?, ?, NOW())
    ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $userId,
            $challengeId
        ]);
    }
}
