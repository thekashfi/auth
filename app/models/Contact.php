<?php


namespace App\Models;


use App\Database\DB;


class Contact
{
    public function imagePath($image)
    {
        return asset("/images/{$image}");
    }

    public function all()
    {
        return db()->all('contacts', ['updated_at', 'desc']);
    }

    public function update($where, $contact)
    {
        return db()->update('contacts', $where, $contact);
    }

    public function create($contact)
    {
        return db()->insert('contacts', $contact); //TODO: duplicate use case :D
    }

    public function delete($id)
    {
        return db()->delete('contacts', $id);
    }

    public function find($id)
    {
        return db()->findContact($id);
    }

    public function of($user_id)
    {
        return db()->contactsOf($user_id, ['updated_at', 'desc']); // TODO: ordering this for json also
    }
}