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
        $this->json = new JSONDB(__DIR__ . '/jsons');
        $this->id = ['id' => rand(1, 1000)];
    }

    public function all($table, $order = ['id', 'ASC']) // TODO: implement ordering.
    {
        if (is_string($order)) {
            $order = [$order, "ASC"];
        }

        $users = $this->json->select('*')
            ->from("{$table}.json")
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
        return $this->id;
    }

    public function update($table, $where, $values) // TODO: timestamp here...!
    {
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

    public function contactsOf($user_id) // TODO: fix code duplication in these two method.
    {
        $contacts = $this->json->select('*')
            ->from("contacts.json")
            ->where(['user_id' => $user_id])
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

    private function format($users)
    {
        return json_decode(json_encode($users));
    }
}