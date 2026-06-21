<?php

class HabitLog extends Model
{
    public function markComplete($habitId)
    {
        $sql = "INSERT INTO habit_logs
                (habit_id, completed_date)
                VALUES
                (:habit_id, CURDATE())";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':habit_id' => $habitId
        ]);
    }

    public function isCompletedToday($habitId)
    {
        $sql = "SELECT id
                FROM habit_logs
                WHERE habit_id = :habit_id
                AND completed_date = CURDATE()
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':habit_id' => $habitId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCurrentStreak($habitId)
{
    $sql = "SELECT completed_date
            FROM habit_logs
            WHERE habit_id = :habit_id
            ORDER BY completed_date DESC";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        ':habit_id' => $habitId
    ]);

    $dates = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (empty($dates)) {
        return 0;
    }

    $streak = 0;

    $expectedDate = date('Y-m-d');

    foreach ($dates as $date) {

        if ($date === $expectedDate) {

            $streak++;

            $expectedDate = date(
                'Y-m-d',
                strtotime($expectedDate . ' -1 day')
            );

        } else {

            break;
        }
    }

    return $streak;
}

public function countCompletedToday($userId)
{
    $sql = "SELECT COUNT(*)
            FROM habit_logs hl
            JOIN habits h
                ON hl.habit_id = h.id
            WHERE h.user_id = :user_id
            AND hl.completed_date = CURDATE()";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        ':user_id' => $userId
    ]);

    return $stmt->fetchColumn();
}

public function getSuccessRate($userId)
{
    $sql = "SELECT COUNT(*)
            FROM habit_logs hl
            JOIN habits h
            ON hl.habit_id = h.id
            WHERE h.user_id = :user_id";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        ':user_id' => $userId
    ]);

    $completed = $stmt->fetchColumn();

    $habitModel = new Habit();

    $totalHabits =
        $habitModel->countByUser($userId);

    if ($totalHabits == 0) {
        return 0;
    }

    return round(
        ($completed / $totalHabits) * 100
    );
}

public function getActiveStreaksCount($userId)
{
    $sql = "
        SELECT COUNT(DISTINCT h.id)
        FROM habits h
        INNER JOIN habit_logs hl
        ON h.id = hl.habit_id
        WHERE h.user_id = :user_id
        AND hl.completed = 1
    ";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        ':user_id' => $userId
    ]);

    return $stmt->fetchColumn();
}
}