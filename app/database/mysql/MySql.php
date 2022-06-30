<?php

namespace App\Database\MySql;

use App\Database\DriverInterface;
use App\Database\FormatRelations;

class MySql implements DriverInterface
{
    use FormatRelations;

    private $pdo;

    public function __construct()
    {
        $pdo = Connection::getInstance();
        $this->pdo = $pdo->connection();
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
    }

    public function all($table, $order = ['id', 'ASC'])
    {
        if (is_string($order)) {
            $order = [$order, "ASC"];
        }

        $sql = "SELECT * FROM {$table} ORDER BY {$order[0]} {$order[1]}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($table, $id)
    {
        $sql = "SELECT * FROM {$table} WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function insert($table, $values)
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

    public function update($table, $where, $values)
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

    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id = :id";
        if ($this->pdo->prepare($sql)->execute(['id' => $id])) {
            return true;
        }
        return false;
    }

    public function findByEmailPass($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email, $password]);
        return $stmt->fetch();
    }
    
    public function contactsOf($user_id, $order = ['id', 'ASC'])
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

    public function findContact($id)
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

    public function conn()
    {
        return $this->pdo;
    }
}