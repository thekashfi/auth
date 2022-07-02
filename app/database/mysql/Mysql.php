<?php

namespace App\Database\Mysql;

use App\Database\DriverInterface;
use App\Database\FormatRelations;

class Mysql implements DriverInterface
{
    use FormatRelations;

    private $pdo;

    public function __construct()
    {
        $pdo = Connection::getInstance();
        $this->pdo = $pdo->connection();
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
    }

    public function all(string $table, int $page, int $per_page, mixed $order = ['id', 'ASC']): array | false
    {
        if (is_string($order)) {
            $order = [$order, "ASC"];
        }

        $start = ($page-1) * $per_page;

        $sql = "SELECT * FROM {$table} ORDER BY {$order[0]} {$order[1]} LIMIT :offset, :per_page";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':offset', (int) $start, \PDO::PARAM_INT);
        $stmt->bindValue(':per_page', (int) $per_page, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find(string $table, int $id): array | false
    {
        $sql = "SELECT * FROM {$table} WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function insert(string $table, array $values): int | false
    {
        [$keys, $vals] = ['', ''];
        foreach ($values as $k => $v) {
            $keys .= "{$k}, ";
            $vals .= ":{$k}, ";
        }
        $keys = rtrim($keys, ' ,');
        $vals = rtrim($vals, ' ,');

        $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$vals})";
        if ($this->pdo->prepare($sql)->execute($values))
            return $this->pdo->lastInsertId();
        return false;
    }

    public function update(string $table, array $where, array $values): bool
    {
        $str = '';
        foreach ($values as $k => $v) {
            $str .= "{$k} = :{$k}, ";
        }
        $str = rtrim($str, ' ,');

        $sql = "UPDATE {$table} SET updated_at = CURRENT_TIMESTAMP, {$str} WHERE {$where[0]} {$where[1]} :{$where[0]}";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array_merge([$where[0] => $where[2]], $values));
    }

    public function delete(string $table, int $id): bool
    {
        $sql = "DELETE FROM {$table} WHERE id = :id";
        if ($this->pdo->prepare($sql)->execute(['id' => $id])) {
            return true;
        }
        return false;
    }

    public function findByEmailPass(string $email, string $password): \stdClass | false
    {
        $sql = "SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email, $password]);
        return $stmt->fetch();
    }
    
    public function contactsOf(int $user_id, mixed $order = ['id', 'ASC']): iterable
    {
        if (is_string($order)) {
            $order = [$order, "ASC"];
        }

        $sql = "SELECT users.*,
                        contacts.*,
                        users.id as uid,
                        users.email as uemail,
                        users.created_at as ucreated_at
                FROM contacts INNER JOIN users ON contacts.user_id = users.id WHERE user_id = ?  ORDER BY contacts.{$order[0]} {$order[1]}, contacts.id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $rows = $stmt->fetchAll();
        return $this->arrangeContacts($rows);
    }

    public function findContact(int $id): \stdClass | false
    {
        $sql = "SELECT users.*,
                        contacts.*,
                        users.id as uid,
                        users.email as uemail,
                        users.created_at as ucreated_at
                FROM contacts INNER JOIN users ON contacts.user_id = users.id WHERE contacts.id = ? ORDER BY contacts.updated_at DESC, contacts.id DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (! $row)
            return false;
        return $this->arrangeContacts($row);
    }

    public function conn(): \PDO
    {
        return $this->pdo;
    }
}