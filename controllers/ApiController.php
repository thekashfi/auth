<?php


namespace Controllers;


use Models\Contact;

class ApiController
{
    public function list()
    {
        if (auth()) {
            $user_id = $_SESSION['user']->id;
            $contacts = (new Contact)->of($user_id);
        } else {
            $contacts = (new Contact)->all();
        }

        $contacts = $this->jsonFormat($contacts); // TODO: add pagination.

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