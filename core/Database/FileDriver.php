<?php
namespace Core\Database;

class FileDriver implements DriverInterface
{
    private string $basePath;

    public function __construct()
    {
        // By standard, ANICOM data resides in /anicom-data/
        $this->basePath = __DIR__ . '/../../anicom-data/';
    }

    private function getTablePath(string $table): string
    {
        $path = $this->basePath . $table . '/';
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        return $path;
    }

    private function getFilePath(string $table, string $id): string
    {
        return $this->getTablePath($table) . $id . '.json';
    }

    public function find(string $table, array $conditions = [], array $options = []): array
    {
        $path = $this->getTablePath($table);
        $files = glob($path . '*.json');
        
        if ($files === false) {
            return [];
        }

        $results = [];
        foreach ($files as $file) {
            $content = file_get_contents($file);
            if ($content !== false) {
                $data = json_decode($content, true);
                if ($data !== null && $this->matchesConditions($data, $conditions)) {
                    $results[] = $data;
                }
            }
        }

        return $results;
    }

    public function findOne(string $table, array $conditions = []): ?array
    {
        // Aggressive path optimization for primary key ID lookup 
        // to avoid scanning all files in the directory.
        if (isset($conditions['id']) && count($conditions) === 1) {
            $filePath = $this->getFilePath($table, (string)$conditions['id']);
            if (file_exists($filePath)) {
                return json_decode(file_get_contents($filePath), true);
            }
            return null;
        }

        $path = $this->getTablePath($table);
        $files = glob($path . '*.json');
        
        if ($files === false) {
            return null;
        }

        foreach ($files as $file) {
            $content = file_get_contents($file);
            if ($content !== false) {
                $data = json_decode($content, true);
                if ($data !== null && $this->matchesConditions($data, $conditions)) {
                    return $data; // Return immediately on first match
                }
            }
        }

        return null;
    }

    public function insert(string $table, array $data)
    {
        $id = $data['id'] ?? uniqid();
        $data['id'] = $id;

        $filePath = $this->getFilePath($table, (string)$id);
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

        return $id;
    }

    public function update(string $table, $id, array $data): bool
    {
        $filePath = $this->getFilePath($table, (string)$id);
        if (!file_exists($filePath)) {
            return false;
        }

        $existing = json_decode(file_get_contents($filePath), true);
        
        // Disallow changing the ID via update
        if (isset($data['id'])) {
            unset($data['id']);
        }

        $updated = array_merge($existing, $data);
        
        return file_put_contents($filePath, json_encode($updated, JSON_PRETTY_PRINT)) !== false;
    }

    public function delete(string $table, $id): bool
    {
        $filePath = $this->getFilePath($table, (string)$id);
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    public function query(string $sql, array $params = [])
    {
        throw new \Exception("FileDriver does not support raw SQL queries. Ensure DriverInterface methods are used.");
    }

    private function matchesConditions(array $data, array $conditions): bool
    {
        foreach ($conditions as $key => $value) {
            if (!isset($data[$key]) || $data[$key] !== $value) {
                return false;
            }
        }
        return true;
    }
}
