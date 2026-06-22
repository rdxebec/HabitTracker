<?php

class Challenge extends Model
{
    public function getAll()
    {
        $stmt = $this->db->query(
            "SELECT * FROM challenges
             ORDER BY xp_reward DESC"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserChallenges($userId)
    {
        $stmt = $this->db->prepare(
            "SELECT challenge_id, completed
             FROM user_challenges
             WHERE user_id = ?"
        );

        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function joinChallenge(
        $userId,
        $challengeId
    ) {
        $stmt = $this->db->prepare(
            "INSERT IGNORE INTO user_challenges
             (
                user_id,
                challenge_id,
                completed
             )
             VALUES
             (?, ?, 0)"
        );

        return $stmt->execute([
            $userId,
            $challengeId
        ]);
    }
}