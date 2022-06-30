<?php

namespace App\Database;

interface DriverInterface
{
    public function all($table, $page, $per_page, $order = ['id', 'ASC']);
    public function find($table, $id);
    public function insert($table, $values);
    public function update($table, $where, $values);
    public function delete($table, $id);
    public function findByEmailPass($email, $password);
    public function contactsOf($user_id, $order = ['id', 'ASC']);
    public function findContact($id);
    public function conn();
}