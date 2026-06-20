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
}