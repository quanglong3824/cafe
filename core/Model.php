<?php
// ============================================================
// Base Model — Aurora Restaurant
// ============================================================

abstract class Model
{

    protected PDO $db;
    protected string $table = '';

    public function __construct()
    {
        $this->db = getDB();
    }

    protected function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $type = PDO::PARAM_STR;
            if (is_int($value)) {
                $type = PDO::PARAM_INT;
            } elseif (is_bool($value)) {
                $type = PDO::PARAM_BOOL;
            } elseif (is_null($value)) {
                $type = PDO::PARAM_NULL;
            }
            
            // PDO parameters can be 1-indexed (int) or string named
            $paramKey = is_int($key) ? $key + 1 : $key;
            $stmt->bindValue($paramKey, $value, $type);
        }
        $stmt->execute();
        return $stmt;
    }

    protected function findAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    protected function findOne(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params)->fetch();
        return $result !== false ? $result : null;
    }

    protected function execute(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    protected function lastInsertId(): string
    {
        return $this->db->lastInsertId();
    }
}
