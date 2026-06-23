<?php

class Template extends Model
{
    public function getAll()
    {
        $stmt = $this->db->query(
            "SELECT * FROM habit_templates"
        );

        return $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    public function getHabits($templateId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM template_habits
             WHERE template_id = ?"
        );

        $stmt->execute([$templateId]);

        return $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );
    }
}