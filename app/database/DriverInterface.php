<?php

namespace App\Database;

interface DriverInterface
{
    public function all($table, $order = ['id', 'ASC']);
    public function find($table, $id);
    public function insert($table, $values);
    public function update($table, $where, $values);
    public function delete($table, $id);
    public function findByEmailPass($email, $password);
    public function contactsOf($user_id);
    public function findContact($id);
    public function conn();
}