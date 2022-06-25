<?php


namespace Models;


use Database\DB;


class Contact
{
    public function of($user_id)
    {
        $sql = "SELECT * FROM contacts WHERE user_id = ? ORDER BY updated_at DESC LIMIT 10";
        $stmt = pdo()->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function imagePath($image)
    {
        return asset("/images/{$image}");
    }

    public function all()
    {
        $sql = "SELECT * FROM contacts ORDER BY updated_at DESC LIMIT 10";
        $stmt = pdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function find($id)
    {
        $sql = "SELECT users.*,
                        contacts.*,
                        users.id as uid,
                        users.email as uemail,
                        users.created_at as ucreated_at
                FROM contacts INNER JOIN users ON contacts.user_id = users.id WHERE contacts.id = ? ORDER BY contacts.updated_at DESC, contacts.id DESC LIMIT 1";
        $stmt = pdo()->prepare($sql);
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

    public function update($contact)
    {
        $sql = "UPDATE contacts SET first_name = :first_name,
                    last_name = :last_name,
                    phone = :phone,
                    email = :email,
                    gender = :gender,
                    image = :image,
                    updated_at = CURRENT_TIMESTAMP
                    WHERE id = :id";
        $stmt = pdo()->prepare($sql);
        $stmt->execute([
            'id' => $contact['id'],
            'first_name' => $contact['first_name'],
            'last_name' => $contact['last_name'],
            'phone' => $contact['phone'],
            'email' => $contact['email'],
            'gender' => $contact['gender'],
            'image' => $contact['image'],
        ]);
    }

    public function create($contact)
    {
        $sql = "INSERT INTO contacts (user_id, first_name, last_name, phone, email, gender, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
        // TODO: repository pattern: everytime i say pdo(). give me back that existing connection. don't create new one.
        if (pdo()->prepare($sql)->execute(array_values($contact))) {
            return pdo()->lastInsertId();
        }
        return false;
    }

    public function delete($id)
    {
        // db()->delete($id);
        // function db() {
        //     DBFactory()->getConnection('mysql')->delete();
        // }
        $sql = "DELETE FROM contacts WHERE id = ?";
        if (pdo()->prepare($sql)->execute([$id])) {
            return true;
        }
        return false;
    }
}