<?php

class Achievement extends Model
{
    protected $table = 'achievements';

    public function getUserAchievements($userId)
    {
        $sql = "
            SELECT a.*
            FROM achievements a
            INNER JOIN user_achievements ua
                ON a.id = ua.achievement_id
            WHERE ua.user_id = :user_id
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function hasAchievement($userId, $achievementId)
    {
        $sql = "
            SELECT id
            FROM user_achievements
            WHERE user_id = :user_id
            AND achievement_id = :achievement_id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId,
            ':achievement_id' => $achievementId
        ]);

        return $stmt->fetch();
    }

    public function unlock($userId, $achievementId)
    {
        $sql = "
            INSERT INTO user_achievements
            (user_id, achievement_id)
            VALUES
            (:user_id, :achievement_id)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':user_id' => $userId,
            ':achievement_id' => $achievementId
        ]);
    }

    public function getUserCompletionCount($userId)
    {
        $sql = "
            SELECT COUNT(*) as total
            FROM habit_logs hl
            INNER JOIN habits h
                ON hl.habit_id = h.id
            WHERE h.user_id = ?
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function unlockIfNotExists(
        $userId,
        $achievementId
    )
    {
        if (
            !$this->hasAchievement(
                $userId,
                $achievementId
            )
        ) {
            $this->unlock(
                $userId,
                $achievementId
            );
        }
    }
}