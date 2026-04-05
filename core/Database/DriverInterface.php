<?php
namespace Core\Database;

interface DriverInterface
{
    /**
     * Find multiple records
     * 
     * @param string $table Entity name (e.g. 'products')
     * @param array $conditions Key-value pairs to match
     * @param array $options limit, offset, order_by, etc.
     * @return array List of associative arrays matching criteria
     */
    public function find(string $table, array $conditions = [], array $options = []): array;

    /**
     * Find a single record
     * 
     * @param string $table Entity name
     * @param array $conditions Key-value pairs to match
     * @return array|null Record associative array or null if not found
     */
    public function findOne(string $table, array $conditions = []): ?array;

    /**
     * Insert a new record
     * 
     * @param string $table Entity name
     * @param array $data Data to insert
     * @return string|int The newly created ID (must be unique)
     */
    public function insert(string $table, array $data);

    /**
     * Update an existing record
     * 
     * @param string $table Entity name
     * @param mixed $id The unique identifier
     * @param array $data Data mapping to update
     * @return bool Success status
     */
    public function update(string $table, $id, array $data): bool;

    /**
     * Delete a record
     * 
     * @param string $table Entity name
     * @param mixed $id The unique identifier
     * @return bool Success status
     */
    public function delete(string $table, $id): bool;

    /**
     * Raw query execution
     * Note: FileDriver will throw an exception. This is reserved for SQL drivers and migrations.
     * 
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function query(string $sql, array $params = []);
}
