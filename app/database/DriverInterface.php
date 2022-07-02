<?php

namespace App\Database;

use App\Models\Contact;
use Jajo\JSONDB;

interface DriverInterface
{
    public function all(string $table, int $page, int $per_page, mixed $order = ['id', 'ASC']): array | \stdClass | false;
    public function find(string$table, int $id): array | \stdClass | false;
    public function insert(string $table, array $values): int | false;
    public function update(string $table, array $where, array $values): bool;
    public function delete(string $table, int $id): bool;
    public function findByEmailPass(string $email, string $password): \stdClass | false;
    public function contactsOf(int $user_id, mixed $order = ['id', 'ASC']): iterable | false;
    public function findContact(int $id): \stdClass | false;
    public function conn(): JSONDB | \PDO;
}