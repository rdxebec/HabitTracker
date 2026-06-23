<?php
require_once __DIR__ . '/../../core/Model.php';
class User extends Model
{
    private string $table = 'users';

    /**
     * Create new user
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table}
                (name, email, password)
                VALUES
                (:name, :email, :password)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => $data['password']
        ]);
    }

    /**
     * Find user by email
     */
    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE email = :email
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Find user by ID
     */
    public function findById(int $id)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addXP($userId, $xp)
    {
        $sql = "
        UPDATE users
        SET xp = xp + :xp
        WHERE id = :id
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':xp' => $xp,
            ':id' => $userId
        ]);

        $logSql = "
        INSERT INTO xp_logs
        (
            user_id,
            xp_gained,
            created_at
        )
        VALUES
        (
            :user_id,
            :xp_gained,
            NOW()
        )
    ";

        $logStmt = $this->db->prepare($logSql);

        $logStmt->execute([
            ':user_id' => $userId,
            ':xp_gained' => $xp
        ]);

        return true;
    }
    public function getById($id)
    {
        $sql = "
        SELECT *
        FROM users
        WHERE id = :id
        LIMIT 1
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateLevel($userId, $level)
    {
        $sql = "
        UPDATE users
        SET level = :level
        WHERE id = :id
    ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':level' => $level,
            ':id' => $userId
        ]);
    }

    public function getXPHistory($userId)
    {
        $sql = "
        SELECT
            DATE(created_at) as day,
            SUM(xp_gained) as total_xp
        FROM xp_logs
        WHERE user_id = :user_id
        GROUP BY DATE(created_at)
        ORDER BY day
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateLastLevelSeen(
        $userId,
        $level
    ) {
        $sql = "
        UPDATE users
        SET last_level_seen = :level
        WHERE id = :id
    ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':level' => $level,
            ':id' => $userId
        ]);
    }
}
