<?php

class Habit extends Model
{
    public function create(array $data): bool
    {
        $sql = "INSERT INTO habits
                (
                    user_id,
                    title,
                    description,
                    category,
                    frequency,
                    priority
                )
                VALUES
                (
                    :user_id,
                    :title,
                    :description,
                    :category,
                    :frequency,
                    :priority
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':user_id' => $data['user_id'],
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':category' => $data['category'],
            ':frequency' => $data['frequency'],
            ':priority' => $data['priority']
        ]);
    }

    public function getByUserId(int $userId)
    {
        $sql = "SELECT *
                FROM habits
                WHERE user_id = :user_id
                ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $sql = "SELECT * FROM habits
            WHERE id = :id
            LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateHabit(
        int $id,
        int $userId,
        array $data
    ) {
        $sql = "UPDATE habits
            SET
                title = :title,
                description = :description,
                category = :category,
                frequency = :frequency,
                priority = :priority
            WHERE
                id = :id
            AND
                user_id = :user_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':category' => $data['category'],
            ':frequency' => $data['frequency'],
            ':priority' => $data['priority'],
            ':id' => $id,
            ':user_id' => $userId
        ]);
    }

    public function deleteHabit(int $id, int $userId)
    {
        $sql = "DELETE FROM habits
            WHERE id = :id
            AND user_id = :user_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':user_id' => $userId
        ]);
    }

    public function countByUser($userId)
    {
        $sql = "SELECT COUNT(*) 
            FROM habits
            WHERE user_id = :user_id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        return $stmt->fetchColumn();
    }

    public function getRecentHabits($userId, $limit = 5)
    {
        $sql = "SELECT *
            FROM habits
            WHERE user_id = :user_id
            ORDER BY created_at DESC
            LIMIT {$limit}";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryStats($userId)
    {
        $sql = "
        SELECT
            category,
            COUNT(*) AS total
        FROM habits
        WHERE user_id = ?
        GROUP BY category
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopHabits($userId)
    {
        $sql = "
        SELECT
            h.title,
            COUNT(hl.id) as completions
        FROM habits h
        LEFT JOIN habit_logs hl
            ON h.id = hl.habit_id
        WHERE h.user_id = :user_id
        GROUP BY h.id
        ORDER BY completions DESC
        LIMIT 5
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBestHabit($userId)
    {
        $sql = "
        SELECT
            h.title,
            COUNT(hl.id) as completions
        FROM habits h
        LEFT JOIN habit_logs hl
            ON h.id = hl.habit_id
        WHERE h.user_id = :user_id
        GROUP BY h.id
        ORDER BY completions DESC
        LIMIT 1
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getWorstHabit($userId)
    {
        $sql = "
        SELECT
            h.title,
            COUNT(hl.id) as completions
        FROM habits h
        LEFT JOIN habit_logs hl
            ON h.id = hl.habit_id
        WHERE h.user_id = :user_id
        GROUP BY h.id
        ORDER BY completions ASC
        LIMIT 1
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function existsByTitle(
        $userId,
        $title
    ) {
        $sql = "
        SELECT id
        FROM habits
        WHERE user_id = ?
        AND title = ?
        LIMIT 1
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $userId,
            $title
        ]);

        return $stmt->fetch();
    }

    public function habitExists($userId, $title)
    {
        $sql = "SELECT id
            FROM habits
            WHERE user_id = ?
            AND LOWER(title) = LOWER(?)
            LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $title]);

        return $stmt->fetch();
    }

    public function habitExistsForUpdate($userId, $title, $habitId)
    {
        $sql = "SELECT id
            FROM habits
            WHERE user_id = ?
            AND LOWER(title) = LOWER(?)
            AND id != ?
            LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $title, $habitId]);

        return $stmt->fetch();
    }
}
