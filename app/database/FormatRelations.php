<?php

namespace App\Database;

trait FormatRelations
{
    private function arrangeContacts($rows)
    {
        if (is_array($rows)) {
            foreach ($rows as $row) {
                $a[] = $this->arrange($row);
            }
        } elseif ($rows) {
            $a = $this->arrange($rows);
        } else
            return false;

        return json_decode(json_encode($a, false));
    }

    private function arrange($row) {
        return [
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
    }
}