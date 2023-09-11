<?php

namespace App\models;

use App\data\Model;
use PDOException;



class User extends Model
{
    public function insert(array $params): int
    {
        try {
            $dbStatement = $this->db->prepare('INSERT INTO 
        Users(name,email,is_active) 
        VALUES(:name,:email,:is_active) ');
            $dbStatement->execute([
                ':name' => $params['name'],
                ':email' => $params['email'],
                ':is_active' => $params['is_active']
            ]);
            return (int) $this->db->lastInsertId();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function delete(int $id)
    {
        try {
            $query = "DELETE FROM Users WHERE id = $id";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function update(int $id, array $params)
    {
        try {
            $query = 'UPDATE Users SET name = :name,
        email = :email,
        is_active = :is_active 
        WHERE id =:id';
            $stmt = $this->db->prepare($query);
            [$name, $email, $is_active] = $params;
            $stmt->execute([
                ':name' => $name,
                ':email,' => $email,
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
            $query = 'SELECT * FROM Users';
            $stmt = $this->db->prepare($query);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
