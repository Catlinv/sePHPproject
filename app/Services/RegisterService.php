<?php


namespace App\Services;


use App\Database\Database;
use App\Utility\Validator;

class RegisterService
{
    private $firstName;
    private $lastName;
    private $address;
    private $email;
    private $password;
    private $phone;
    private $token;

    public function validateRegisterData()
    {
        $errors = Validator::validate($_POST,
            ['emailAddress' => ['required', 'email', "unique::users::email"],
                'password' => ['required'],
                'phone' => ['required', 'phone'],
                'address' => ['required'],
                'lastName' => ['required'],
                'firstName' => ['required']],
            ['emailAddress' => ['emailAddress', 'emailAddressFormat', "alreadyUser"],
                'password' => ['password'],
                'phone' => ['phone', 'phoneFormat'],
                'address' => ['address'],
                'lastName' => ['lastName'],
                'firstName' => ['firstName']]);
        $this->firstName = clean_input($_POST['firstName']);
        $this->lastName = clean_input($_POST['lastName']);
        $this->address = clean_input($_POST['address']);
        $this->email = clean_input($_POST["emailAddress"]);
        $this->password = clean_input($_POST['password']);
        $this->phone = intval(substr(clean_input($_POST["phone"]), 3));
        $this->token = generateToken();

        return $errors;
    }

    public function registerUser()
    {
        $database = new Database();
        $database->insert("users", [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'address' => $this->address,
            'phone' => $this->phone,
            'password' => md5($this->password),
            'token' => $this->token]);

        sendConfirmationEmail($this->email, $this->token);
    }
}

