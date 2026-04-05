<?php
namespace Core\Database;

use PDO;
use PDOException;

class MysqlDriver implements DriverInterface
{
    private PDO $pdo;

    public function __construct(string $host = '127.0.0.1', string $dbname = 'anicom_dev', string $username = 'root', string $password = '')
    {
        // For zero-configuration on XAMPP, we attempt to connect without DB first to auto-create if it's missing,
        // though normally in production this just connects directly.
        try {
            $tempPdo = new PDO("mysql:host={$host};charset=utf8mb4", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            // Only runs if user has privileges (like root on XAMPP)
            $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        } catch (PDOException $e) {
            // In production without root, this might fail, so we ignore and try the main connection
        }

        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false, // Enforce real prepared statements
        ];

        try {
            $this->pdo = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            throw new \Exception("Database connection failed: " . $e->getMessage());
        }
    }

    private function sanitizeKey(string $key): string
    {
        // Enforce strict column name sanitization (alphanumeric and underscores only)
        return preg_replace('/[^a-zA-Z0-9_]/', '', $key);
    }

    private function sanitizeTable(string $table): string
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $table);
    }

    public function find(string $table, array $conditions = [], array $options = []): array
    {
        $table = $this->sanitizeTable($table);
        $sql = "SELECT * FROM `{$table}`";
        
        $params = [];
        if (!empty($conditions)) {
            $clauses = [];
            foreach ($conditions as $key => $val) {
                $safeKey = $this->sanitizeKey($key);
                $clauses[] = "`{$safeKey}` = ?";
                $params[] = $val;
            }
            $sql .= " WHERE " . implode(' AND ', $clauses);
        }

        if (isset($options['order_by'])) {
            $safeOrder = $this->sanitizeKey($options['order_by']);
            $direction = (isset($options['order_dir']) && strtoupper($options['order_dir']) === 'DESC') ? 'DESC' : 'ASC';
            $sql .= " ORDER BY `{$safeOrder}` {$direction}";
        }

        if (isset($options['limit'])) {
            $limit = (int)$options['limit'];
            $sql .= " LIMIT {$limit}";
            
            if (isset($options['offset'])) {
                $offset = (int)$options['offset'];
                $sql .= " OFFSET {$offset}";
            }
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findOne(string $table, array $conditions = []): ?array
    {
        $options = ['limit' => 1];
        $results = $this->find($table, $conditions, $options);
        return !empty($results) ? $results[0] : null;
    }

    public function insert(string $table, array $data)
    {
        $table = $this->sanitizeTable($table);
        
        // If no ID provided and table usually relies on string uuid, generator could be here.
        // However, standard MySQL uses AUTO_INCREMENT. We let MySQL handle it unless provided.
        $keys = array_keys($data);
        $safeKeys = array_map([$this, 'sanitizeKey'], $keys);
        
        $fields = implode('`, `', $safeKeys);
        $placeholders = implode(', ', array_fill(0, count($keys), '?'));
        
        $sql = "INSERT INTO `{$table}` (`{$fields}`) VALUES ({$placeholders})";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));
        
        if (isset($data['id'])) {
            return $data['id'];
        }
        
        return $this->pdo->lastInsertId();
    }

    public function update(string $table, $id, array $data): bool
    {
        $table = $this->sanitizeTable($table);
        $safeKeys = array_map([$this, 'sanitizeKey'], array_keys($data));
        
        $sets = [];
        foreach ($safeKeys as $key) {
            $sets[] = "`{$key}` = ?";
        }
        
        $params = array_values($data);
        $params[] = $id; // For WHERE id = ?
        
        $sql = "UPDATE `{$table}` SET " . implode(', ', $sets) . " WHERE `id` = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(string $table, $id): bool
    {
        $table = $this->sanitizeTable($table);
        $sql = "DELETE FROM `{$table}` WHERE `id` = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function query(string $sql, array $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        // If SELECT query, return fetched results loosely
        if (preg_match('/^\s*(SELECT|SHOW|DESCRIBE|EXPLAIN)/i', $sql)) {
            return $stmt->fetchAll();
        }
        
        return $stmt->rowCount();
    }
}
