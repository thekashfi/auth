<?php

namespace App\Database\Json;

use App\Database\DriverInterface;
use App\Database\FormatRelations;
use Jajo\JSONDB;

class Json implements DriverInterface
{
    use FormatRelations;

    private $json, $id;

    public function __construct()
    {
        $this->json = new JSONDB(ROOT . '/app/database/json/jsons');
        $this->id = ['id' => rand(1, 1000)];
    }

    public function all($table, $order = ['id', 'ASC'])
    {
        if (is_string($order)) {
            $order = [$order, "ASC"];
        }
        $order[1] = strtoupper($order[1]) === 'ASC' ? JSONDB::ASC : JSONDB::DESC;

        $users = $this->json->select('*')
            ->from("{$table}.json")
            ->order_by($order[0], $order[1])
            ->get();
        return $this->format($users ?? false);
    }

    public function find($table, $id)
    {
        $row = $this->json->select('*')
            ->from("{$table}.json")
            ->where(['id' => $id])
            ->get();
        return $this->format($row[0] ?? false);
    }

    public function insert($table, $values)
    {
        $timestamps = $table == 'users' ? ['created_at' => time()] : ['created_at' => time(), 'updated_at' => time()];
        $this->json->insert("{$table}.json",
            array_merge($this->id, $values, $timestamps)
        );
        return $this->id['id'];
    }

    public function update($table, $where, $values)
    {
        $values = array_merge($values, ['updated_at' => time()]);
        $this->json->update($values)
            ->from("{$table}.json")
            ->where([$where[0] => $where[2]])
            ->trigger();
        return true;
    }

    public function delete($table, $id)
    {
        $this->json->delete()
            ->from("{$table}.json")
            ->where(['id' => $id])
            ->trigger();
    }

    public function findByEmailPass($email, $password)
    {
        $user = $this->json->select('*')
            ->from("users.json")
            ->where(['email' => $email, 'password' => $password], 'AND')
            ->get();
        return $this->format($user[0] ?? false);
    }

    public function contactsOf($user_id, $order = ['id', 'ASC']) // TODO: fix code duplication in these two method. (ask)
    {
        if (is_string($order)) {
            $order = [$order, "ASC"];
        }
        $order[1] = strtoupper($order[1]) === 'ASC' ? JSONDB::ASC : JSONDB::DESC;

        $contacts = $this->json->select('*')
            ->from("contacts.json")
            ->where(['user_id' => $user_id])
            ->order_by($order[0], $order[1])
            ->get();

        if (! $contacts)
            return false;

        foreach ($contacts as $contact) {
            $user = $this->json->select('*')
                ->from("users.json")
                ->where(['id' => $contact['user_id']])
                ->get();

            if (! $user)
                return false;
            $user = $user[0];

            $u['uid'] = $user['id'];
            $u['name'] = $user['name'];
            $u['uemail'] = $user['email'];
            $u['password'] = $user['password'];
            $u['ucreated_at'] = $user['created_at'];

            $c[] = array_merge($contact, $u);
        }
        return $this->arrangeContacts($this->format($c));
    }

    public function findContact($id)
    {
        $contact = $this->json->select('*')
            ->from("contacts.json")
            ->where(['id' => $id])
            ->get();

        if (! $contact)
            return false;
        $contact = $contact[0];

        $user = $this->json->select('*')
            ->from("users.json")
            ->where(['id' => $contact['user_id']])
            ->get();

        if (! $user)
            return false;
        $user = $user[0];

        $u['uid'] = $user['id'];
        $u['name'] = $user['name'];
        $u['uemail'] = $user['email'];
        $u['password'] = $user['password'];
        $u['ucreated_at'] = $user['created_at'];

        return $this->arrangeContacts($this->format(array_merge($contact, $u)));
    }

    public function conn()
    {
        return new JSONDB(ROOT . '/app/database/json/jsons');
    }

    private function format($users)
    {
        return json_decode(json_encode($users));
    }

}