<?php


namespace App\Controllers;


use App\Models\Contact;

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
        if (user()->id !== $contact->user->id) {
            die("OO oo! you can\'t edit this contact. go edit your contacts :|");
        }

        return view('edit', ['contact' => $contact]);
    }

    public function update($contact_id)
    {
        // TODO: validation all inputs
        // TODO: json error return validation!

        $contact = (new Contact)->find($contact_id);

        if (user()->id !== $contact->user->id) {
            header('HTTP/1.1 403 Forbidden');
            die("OO oo! you can\'t edit this contact. go edit your contacts :|");
        }

        $record['image'] = $contact->image;

        if ($this->hasFile('image') &&
            $this->maxSize('image', 2) &&
            $this->isImage('image')) {
                $record['image'] = $this->replaceImage($contact->image);
        }

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
        $contact = (new Contact)->find($id);

        if (user()->id !== $contact->user->id) {
            header('HTTP/1.1 403 Forbidden');
            die("OO oo! you can\'t delete this contact. go delete your contacts :|");
        }

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

    private function hasFile($name)
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