<?php

namespace App\data;

use ErrorException;
use PDO;
use PDOException;

/**
 * @mixin PDO
 */


class Repository
{
    private static ?Repository $instance = null;
    private ?PDO $dbConnection = null;
    private  function __construct(protected ?array $config)
    {
        $this->dbConnection = $this->connectPDO();
        if (!$this->checkIfDBNotEmpty()) {
            $this->initTables();
            $this->insertTableData();
        }
    }
    private function connectPDO()
    {
        try {
            return empty($this->config) ?
                new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASS'], [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]) :
                new PDO($this->config['driver'] . ':host=' . $this->config['host'] . ';dbname=' . $this->config['database'], $_ENV['user'], $_ENV['pass']);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public static function GetRepository(array $config = []): Repository
    {
        if (is_null(self::$instance)) {
            static::$instance = new self($config);
        }
        return static::$instance;
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->dbConnection, $name], $arguments);
    }
    private function initTables()
    {
        try {
            // Query to check if the users table exists
            $checkUsersTable = 'SHOW TABLES LIKE "Users"';
            $result = $this->dbConnection->query($checkUsersTable);
            if (!($result->rowCount() > 0)) {
                $usersTable = 'CREATE TABLE Users(
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255),
                email VARCHAR(255),
                is_active BOOLEAN
            )';
                $this->dbConnection->query($usersTable);
            }
            // Query to check if the posts table exists
            $checkPostsTable = 'SHOW TABLES LIKE "Posts"';
            $result = $this->dbConnection->query($checkPostsTable);
            if (!($result->rowCount() > 0)) {
                $postTables = 'CREATE TABLE Posts(
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                title VARCHAR(255),
                content TEXT,
                created_at DATETIME,
                is_active BOOLEAN,
                FOREIGN KEY (user_id) REFERENCES Users(id)
            )';
                $this->dbConnection->query($postTables);
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    private function insertTableData()
    {
        $apiUrl = 'https://jsonplaceholder.typicode.com/users';
        // Initialize cURL session
        $request = curl_init($apiUrl);
        //Dont print To screen the result
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($request);
        if (curl_errno($request)) {
            throw new ErrorException;
        } else {
            // Decode the JSON response into an array
            $userDataArray = json_decode($response, true);
            if ($userDataArray === null) {
                echo 'Error: Unable to decode JSON response';
            } else {
                $insertUserQuery = "INSERT INTO Users (name, email, is_active) VALUES (:name, :email, :is_active)";
                $userStmt = $this->dbConnection->prepare($insertUserQuery);

                $insertPostQuery = "INSERT INTO Posts (user_id, title, content, created_at, is_active) VALUES (:user_id, :title, :content, NOW(), :is_active)";
                $postStmt = $this->dbConnection->prepare($insertPostQuery);

                foreach ($userDataArray as $userData) {
                    $random_value = random_int(0, 1);
                    $userStmt->execute([
                        ':name' => $userData['name'],
                        ':email' => $userData['email'],
                        ':is_active' => $random_value
                    ]);
                    $userId = $this->dbConnection->lastInsertId();
                    $postStmt->execute([
                        ':user_id' => $userId,
                        ':title' => $userData['company']['bs'],
                        ':content' => $userData['company']['catchPhrase'],
                        ':is_active' => $random_value
                    ]);
                }
            }
        }
    }

    private function checkIfDBNotEmpty()
    {
        $checkUsersTable = 'SHOW TABLES LIKE "Users"';
        $result = $this->dbConnection->query($checkUsersTable);
        if (($result->rowCount() > 0)) {
            return true;
        }
        return false;
    }
}
