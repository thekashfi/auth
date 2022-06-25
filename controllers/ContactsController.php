<?php


namespace Controllers;


use Models\Contact;

class ContactsController
{
    use MiddlewaresTrait, Validators;

    public $middleware = 'loggedIn';

    public function create()
    {
        return view('create');
    }

    public function store()
    {
        $this->storeValidation();

        $record['user_id'] = user()->id;
        $record['first_name'] = $_POST['first_name'];
        $record['last_name'] = $_POST['last_name'];
        $record['phone'] = $_POST['phone'];
        $record['email'] = $_POST['email'];
        $record['gender'] = $_POST['gender'];

        $record['image'] = $this->storeImage();

        $id = (new Contact)->create($record);

        $msg = "Contact <a href='" . url("show/$id") . "'><b>{$record['first_name']} {$record['last_name']}</b></a> has been created successfully!";
        return flashBack($msg);
    }

    public function edit($contact_id)
    {
        $contact = (new Contact)->find($contact_id);
        if (($user_id = user()->id) !== $contact->user->id) {
            die('OO oo! you can\'t edit this contact. go edit your contacts :/');
        }

        return view('edit', ['contact' => $contact]);
    }

    public function update($contact_id)
    {
        // TODO: check user's id with contact's user_id
        // TODO: json validation!

        $contact = (new Contact)->find($contact_id);

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

    public function delete($id)
    {
        // TODO: check if contact belong to user!
        $contact = (new Contact)->find($id);
        $image = $contact->image;
        (new Contact)->delete($id); // TODO: repository pattern needed!

        $this->deleteImage($image);

        echo 'deleted';
    }

    private function replaceImage($oldImage)
    {
        $path = $_FILES['image']['tmp_name'];
        $name = $oldImage;
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $dir = ROOT . '/public/images';
        $newPath = $dir . '/' . $name/* . '.' . $ext*/; // TODO: get uploaded image's extension.

        if (file_exists($oldImage = $dir . '/' . $oldImage)) {
            unlink($oldImage);
        }

        if (! copy($path, $newPath)) {
            die('problem');
        }
        unlink($path);

        return $name;
    }

    public function hasFile($name)
    {
        return (isset($_FILES) && ! empty($_FILES[$name]['tmp_name']));
    }

    private function storeValidation()
    {
        $this->required($_POST['first_name'], 'first_name');
        $this->maxLength($_POST['first_name'], 'first_name');

        $this->required($_POST['last_name'], 'last_name');
        $this->maxLength($_POST['last_name'], 'last_name');

        $this->required($_POST['phone'], 'phone');
        $this->maxLength($_POST['phone'], 'phone');

        $this->required($_POST['email'], 'email');
        $this->maxLength($_POST['email'], 'email');

        $this->required($_POST['gender'], 'gender');
        $this->maxLength($_POST['gender'], 'gender');

        $this->requiredFile('image');
        $this->isImage('image');
    }

    private function storeImage()
    {
        $image = $_FILES['image']['tmp_name'];
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $name = uniqid() . '.' . $ext;
        $path = ROOT . '/public/images/' . $name;

        if (! copy($image, $path)) {
            die('problem');
        }

        return $name;
    }

    private function deleteImage($image)
    {
        $image = ROOT . "/public/images/$image";
        if (file_exists($image)) {
            unlink($image);
            return true;
        }
    }
}