<?php


namespace Controllers;


use Models\Contact;

class ContactsController
{
    use MiddlewaresTrait, Validators;

    public $middleware = 'loggedIn';

    public function edit($contact_id)
    {
        $contact = (new Contact)->find($contact_id);
        if (! ($user_id = $_SESSION['user']->id) === $contact->user->id) {
            die('OO oo! you can\'t edit this contact. go edit your contacts :/');
        }

        return view('edit', ['contact' => $contact]);
    }

    public function update($contact_id)
    {
        $contact = (new Contact)->find($contact_id);
        // dd(array_merge($_POST, ['user_id' => $_SESSION['user']->id]));

        $record['image'] = $contact->image;

        if ($this->hasFile('image') &&
            $this->maxSize('image', 2) &&
            $this->isImage('image')) {
                $record['image'] = $this->replaceImage($contact->image);
        }

        // TODO: validation all inputs

        $record['id'] = $contact->id;
        $record['first_name'] = $_POST['first_name'];
        $record['last_name'] = $_POST['last_name'];
        $record['phone'] = $_POST['phone'];
        $record['email'] = $_POST['email'];
        $record['gender'] = $_POST['gender'];

        (new Contact)->update($record);
        echo 'updated';
    }

    private function replaceImage($oldImage)
    {
        $path = $_FILES['image']['tmp_name'];
        $name = $_FILES['image']['name'];
        $name = basename($name);
        // $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $dir = ROOT . '/public/images';
        $newPath = $dir . '/' . $name/* . '.' . $ext*/;

        if (! copy($path, $newPath)) {
            flashBack('image upload problem :(');
        }
        unlink($path);

        if (file_exists($oldImage = $dir . '/' . $oldImage)) {
            unlink($oldImage);
        }
        return $name;
    }

    public function hasFile($name)
    {
        return (isset($_FILES) && ! empty($_FILES[$name]['tmp_name']));
    }
}