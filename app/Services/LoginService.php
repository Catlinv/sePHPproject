<?php


namespace App\Services;


use App\Database\Database;
use App\Utility\Session;
use App\Utility\Validator;

class LoginService
{
    private $id;
    private $email;
    private $password;
    private $firstName;
    private $lastName;

    public function validateLoginData()
    {
        $errors = Validator::validate($_POST,
            ['emailAddress' => ['required', 'email'],
                'password' => ['required']],
            ['emailAddress' => ['emailAddress', 'emailAddressFormat'],
                'password' => ['password']]);

        if (count($errors) == 0) {
            $this->id = null;
            $this->password = md5(clean_input($_POST['password']));
            $this->email = clean_input($_POST["emailAddress"]);

            $database = new Database();
            $result = $database->select("users", ["first_name", "last_name", "email", "password", "confirmed", "id"], "email LIKE \"$this->email\"");
            if (count($result) == 0)
                $errors['unknownUser'] = true;
            else {
                $row = current($result);
                if ($row['password'] != $this->password) {
                    $errors['wrongPassword'] = true;
                } elseif ($row["confirmed"] == 0) {
                    $errors['confirmed'] = true;
                } else {
                    $this->id = $row['id'];
                    $this->firstName = $row['first_name'];
                    $this->lastName = $row['last_name'];
                    $this->email = $row['email'];
                }
            }
        }

        return $errors;
    }

    public function setUserData()
    {
        $userData = [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
        ];
        Session::set('user', $userData);
    }
}