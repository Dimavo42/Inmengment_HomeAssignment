<?php

namespace App\models;

use App\data\Model;
use PDOException;




class Post extends Model
{
    public function insert(array $params): int
    {
        try {
            $dbStatement = $this->db->prepare('INSERT INTO 
        Posts(user_id,title,content,created_at,is_active) 
        VALUES(:user_id,:title,:text,NOW(),:is_active) ');
            $dbStatement->execute([
                ':user_id' => $params['user_id'],
                ':title' => $params['title'],
                ':text' => $params['text'],
                'is_active' => $params['is_active']
            ]);
            return (int) $this->db->lastInsertId();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function delete(int $id)
    {
        try {
            $query = "DELETE FROM Posts WHERE id = $id";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function update(int $id, array $params)
    {
        try {
            $query = 'UPDATE Posts SET content = :content,
        title = :title,
        is_active = :is_active 
        WHERE user_id =:id';
            $stmt = $this->db->prepare($query);
            [$title, $content, $is_active] = $params;
            $stmt->execute([
                ':title' => $title,
                ':content,' => $content,
                'is_active' => $is_active,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getAll()
    {
        try {
            $query = 'SELECT * FROM Posts';
            $stmt = $this->db->prepare($query);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
