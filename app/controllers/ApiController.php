<?php


namespace App\Controllers;


use App\Models\Contact;

class ApiController
{
    public function list()
    {
        if (auth()) {
            $user_id = user()->id;
            $contacts = (new Contact)->of($user_id);
        } else {
            $page = $_GET['page'] ?? 1; // TODO: improve pagination.
            $contacts = (new Contact)->all($page, conf('per_page'));
        }

        $contacts = $this->jsonFormat($contacts);

        header('Content-Type: application/json; charset=utf-8');
        echo $contacts;
    }

    private function jsonFormat($contacts)
    {
        foreach ($contacts as $c) {
            $array[] = [
                'name' => [
                    'title' => $c->gender === 'male' ? 'Mr' : 'Ms',
                    'first' => $c->first_name,
                    'last' => $c->last_name,
                ],
                'phone' => $c->phone,
                'email' => $c->email,
                'gender' => $c->gender,
                'picture' => [
                    'large' => (new Contact)->imagePath($c->image),
                ],
                'id' => [
                    'value' => $c->id,
                ]
            ];
        }
        return json_encode(['results' => $array]);
    }
}