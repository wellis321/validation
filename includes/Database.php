<?php
class Database {
    private static $instance = null;
    private $connection;
    private $connectionError = null;

    private function __construct() {
        try {
            // Load database configuration
            $config = require __DIR__ . '/../config/database.php';

            $dsn = "mysql:host=" . $config['host'] .
                   ";dbname=" . $config['database'] .
                   ";charset=" . $config['charset'];

            // Add port if specified
            if (isset($config['port'])) {
                $dsn .= ";port=" . $config['port'];
            }

            $this->connection = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            $this->connectionError = $e->getMessage();
            // Don't throw exception - allow app to work without database
            // Error will be checked when trying to use connection
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function isConnected() {
        return $this->connection !== null && $this->connectionError === null;
    }

    public function getConnectionError() {
        return $this->connectionError;
    }

    public function getConnection() {
        if (!$this->isConnected()) {
            throw new Exception("Database not connected: " . ($this->connectionError ?: "Unknown error"));
        }
        return $this->connection;
    }

    public function query($sql, $params = []) {
        if (!$this->isConnected()) {
            throw new Exception("Database not connected: " . ($this->connectionError ?: "Unknown error"));
        }
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Query failed: " . $e->getMessage());
        }
    }

    public function insert($table, $data) {
        // Clean and normalize data for MySQL compatibility
        $cleanedData = [];
        foreach ($data as $key => $value) {
            // Convert boolean to integer (0 or 1) - always include in insert
            if (is_bool($value)) {
                $cleanedData[$key] = $value ? 1 : 0;
            }
            // Keep null values as-is (for optional fields)
            else if ($value === null) {
                $cleanedData[$key] = null;
            }
            // Convert empty strings to null only if not a required field
            else if ($value === '' && !in_array($key, ['email', 'password'])) {
                $cleanedData[$key] = null;
            }
            // Keep all other values as-is
            else {
                $cleanedData[$key] = $value;
            }
        }

        $fields = implode(', ', array_keys($cleanedData));
        $placeholders = implode(', ', array_fill(0, count($cleanedData), '?'));
        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array_values($cleanedData));
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Insert failed: " . $e->getMessage());
        }
    }

    public function update($table, $data, $where, $whereParams = []) {
        // Convert boolean values to integers (0 or 1) for MySQL compatibility
        $data = array_map(function($value) {
            if (is_bool($value)) {
                return $value ? 1 : 0;
            }
            return $value;
        }, $data);

        $set = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE {$table} SET {$set} WHERE {$where}";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array_merge(array_values($data), $whereParams));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Update failed: " . $e->getMessage());
        }
    }

    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM {$table} WHERE {$where}";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Delete failed: " . $e->getMessage());
        }
    }

    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }

    public function commit() {
        return $this->connection->commit();
    }

    public function rollback() {
        return $this->connection->rollBack();
    }
}