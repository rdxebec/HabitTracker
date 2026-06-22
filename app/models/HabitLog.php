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

    public function getLongestStreak($userId)
    {
        $sql = "
        SELECT COUNT(*) as streak
        FROM habit_logs hl
        INNER JOIN habits h
        ON h.id = hl.habit_id
        WHERE h.user_id = :user_id
        AND hl.completed = 1
        GROUP BY hl.habit_id
        ORDER BY streak DESC
        LIMIT 1
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['streak'] : 0;
    }

    public function getWeeklyCompletions($userId)
    {
        $sql = "
        SELECT COUNT(*) 
        FROM habit_logs hl
        INNER JOIN habits h
        ON h.id = hl.habit_id
        WHERE h.user_id = :user_id
        AND hl.completed = 1
        AND hl.completed_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        return $stmt->fetchColumn();
    }

    public function getWeeklyActivity($userId)
    {
        $days = [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0
        ];

        $sql = "
        SELECT
            DAYNAME(completed_date) as day_name,
            COUNT(*) as total
        FROM habit_logs hl
        INNER JOIN habits h
            ON h.id = hl.habit_id
        WHERE h.user_id = :user_id
        AND hl.completed = 1
        AND hl.completed_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY DAYNAME(completed_date)
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            $days[$row['day_name']] = $row['total'];
        }

        return $days;
    }

    public function getHabitHistory($habitId)
    {
        $sql = "
        SELECT completed_date
        FROM habit_logs
        WHERE habit_id = :habit_id
        ORDER BY completed_date DESC
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':habit_id' => $habitId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHabitCurrentStreak($habitId)
    {
        return $this->getCurrentStreak($habitId);
    }
    public function getHabitCompletionRate($habitId)
    {
        $sql = "
        SELECT COUNT(*) as total
        FROM habit_logs
        WHERE habit_id = :habit_id
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':habit_id' => $habitId
        ]);

        $completed =
            $stmt->fetch()['total'] ?? 0;

        return min(100, $completed * 10);
    }

    public function getMonthlyActivity($userId)
    {
        $sql = "
        SELECT
            completed_date,
            COUNT(*) as total
        FROM habit_logs hl
        INNER JOIN habits h
            ON h.id = hl.habit_id
        WHERE h.user_id = :user_id
        AND MONTH(completed_date) = MONTH(CURDATE())
        AND YEAR(completed_date) = YEAR(CURDATE())
        GROUP BY completed_date
        ORDER BY completed_date
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countTotalCompletions($userId)
    {
        $sql = "
        SELECT COUNT(*) as total
        FROM habit_logs hl
        INNER JOIN habits h
            ON h.id = hl.habit_id
        WHERE h.user_id = :user_id
    ";

        $stmt =
            $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        return $stmt->fetch()['total'];
    }

    public function getLongestUserStreak($userId)
    {
        $sql = "
        SELECT id
        FROM habits
        WHERE user_id = :user_id
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        $habits =
            $stmt->fetchAll(PDO::FETCH_ASSOC);

        $longest = 0;

        foreach ($habits as $habit) {

            $streak =
                $this->getCurrentStreak(
                    $habit['id']
                );

            if ($streak > $longest) {
                $longest = $streak;
            }
        }

        return $longest;
    }
}
