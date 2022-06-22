<?php


namespace Controllers;


use Models\Contact;

class ApiController
{
    public function list()
    {
        $this->middleware();

        $user_id = $_SESSION['user']->id;
        $contacts = (new Contact)->of($user_id);
        $contacts = $this->jsonFormat($contacts); // TODO: add pagination.

        header('Content-Type: application/json; charset=utf-8');
        echo $contacts;
    }

    private function middleware()
    {
        if (!isset($_SESSION['user'])) {
            $href= url('/login');
            die("please <a href='{$href}'>login</a> first. and then visit this page.");
        }
    }

    private function jsonFormat($contacts)
    {
        foreach ($contacts as $c) {
            $array[] = [
                'name' => [
                    'title' => $c === 'male' ? 'Mr' : 'Ms',
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
                ],
                'location' => [
                    'country' => 'n/a',
                    'city' => 'n/a',
                ],
            ];
        }
        return json_encode(['results' => $array]);
    }
}