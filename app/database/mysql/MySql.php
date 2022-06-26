<?php

namespace App\Database\MySql;

class MySql
{
    private $pdo;

    public function __construct()
    {
        $pdo = Connection::getInstance();
        $this->pdo = $pdo->connection();
    }

    public function all($table, $order = ['id', 'ASC'])
    {
        if (is_string($order)) {
            $order = [$order, "ASC"];
        }

        $sql = "SELECT * FROM {$table} ORDER BY {$order[0]} {$order[1]}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ); // TODO: write fetch::obj mode once in the connecting time.
    }

    public function find($table, $id)
    {
        $sql = "SELECT * FROM" . $table . "WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject();
    }

    public function insert($table, $values)
    {
        [$keys, $vals] = ['', ''];
        foreach ($values as $k => $v) {
            $keys .= "{$k}, ";
            $vals .= ":{$k}, ";
        }
        $keys = rtrim($vals, ' ,');
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
        return $stmt->fetchObject();
    }


    public function contactOf($user_id)
    {
        $sql = "SELECT * FROM contacts WHERE user_id = ? ORDER BY updated_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
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
        $row = $stmt->fetch(\PDO::FETCH_OBJ);
        if (! $row)
            return false;
        return $this->arrangeContact($row);
    }

    private function arrangeContact($row)
    {
        $a = [
            'id' => $row->id,
            'user_id' => $row->user_id,
            'first_name' => $row->first_name,
            'last_name' => $row->last_name,
            'phone' => $row->phone,
            'email' => $row->email,
            'gender' => $row->gender,
            'image' => $row->image,
            'created_at' => $row->created_at,
            'updated_at' => $row->updated_at,
            'user' => [
                'id' => $row->uid,
                'name' => $row->name,
                'email' => $row->uemail,
                'created_at' => $row->ucreated_at,
            ],
        ];
        return json_decode(json_encode($a, false));
    }
}