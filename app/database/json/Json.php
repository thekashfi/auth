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

    public function all(string $table, int $page, int $per_page, mixed $order = ['id', 'ASC']): \stdClass | false
    {
        if (is_string($order)) { // TODO: implement pagination in json also
            $order = [$order, "ASC"];
        }
        $order[1] = strtoupper($order[1]) === 'ASC' ? JSONDB::ASC : JSONDB::DESC;

        $users = $this->json->select('*')
            ->from("{$table}.json")
            ->order_by($order[0], $order[1])
            ->get();
        return $this->format($users ?? false);
    }

    public function find(string $table, int $id) : \stdClass | false
    {
        $row = $this->json->select('*')
            ->from("{$table}.json")
            ->where(['id' => $id])
            ->get();
        return $this->format($row[0] ?? false);
    }

    public function insert(string $table, array $values) : int
    {
        $timestamps = $table == 'users' ? ['created_at' => time()] : ['created_at' => time(), 'updated_at' => time()];
        $this->json->insert("{$table}.json",
            array_merge($this->id, $values, $timestamps)
        );
        return $this->id['id'];
    }

    public function update(string $table, array $where, array $values): bool
    {
        $values = array_merge($values, ['updated_at' => time()]);
        $this->json->update($values)
            ->from("{$table}.json")
            ->where([$where[0] => $where[2]])
            ->trigger();
        return true;
    }

    public function delete(string $table, int $id): bool
    {
        $this->json->delete()
            ->from("{$table}.json")
            ->where(['id' => $id])
            ->trigger();
        return true;
    }

    public function findByEmailPass(string $email, string $password): \stdClass | false
    {
        $user = $this->json->select('*')
            ->from("users.json")
            ->where(['email' => $email, 'password' => $password], 'AND')
            ->get();
        return $this->format($user[0] ?? false);
    }

    public function contactsOf(int $user_id, mixed $order = ['id', 'ASC']): iterable | false // TODO: fix code duplication in these two method. (ask)
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
            $user = $this->getUser($contact['user_id']);
            $c[] = array_merge($contact, $user);
        }
        return $this->arrangeContacts($this->format($c));
    }

    public function findContact(int $id): \stdClass | false
    {
        $contact = $this->json->select('*')
            ->from("contacts.json")
            ->where(['id' => $id])
            ->get();

        if (! $contact)
            return false;
        $contact = $contact[0];

        $user = $this->getUser($contact['user_id']);

        return $this->arrangeContacts($this->format(array_merge($contact, $user)));
    }

    public function conn(): JSONDB
    {
        return new JSONDB(ROOT . '/app/database/json/jsons');
    }

    private function format($users)
    {
        return json_decode(json_encode($users));
    }

    private function getUser(int $user_id): array | false
    {
        $user = $this->json->select('*')
            ->from("users.json")
            ->where(['id' => $user_id])
            ->get();

        if (! $user)
            return false;
        $user = $user[0];

        $u['uid'] = $user['id'];
        $u['name'] = $user['name'];
        $u['uemail'] = $user['email'];
        $u['password'] = $user['password'];
        $u['ucreated_at'] = $user['created_at'];
        return $u;
    }

}