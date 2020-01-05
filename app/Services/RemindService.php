<?php


namespace App\Services;


use App\Database\Database;
use App\Utility\Validator;

class RemindService
{
    private $email;
    private $id;

    public function validateRemindData()
    {
        $errors = Validator::validate($_POST,
            ['emailAddress' => ['required', 'email']],
            ['emailAddress' => ['emailAddress', 'emailAddressFormat']]);

        if (count($errors) == 0) {
            $this->email = clean_input($_POST["emailAddress"]);
            $this->id = null;
            $database = new Database();
            $result = $database->select("users", ["first_name", "last_name", "email", "password", "confirmed", "id"], "email LIKE \"$this->email\"");
            if (count($result) == 0)
                $errors['unknownUser'] = true;
            else
                $this->id = $result[0]['id'];
        }
        return $errors;
    }

    public function remindUser()
    {
        $resetToken = generateToken();
        $database = new Database();
        $database->update("users", ["reset_token" => $resetToken], "id = " . $this->id);
        sendEmailWithTitleAndBody($this->email, "Password reset link", "Click here to reset your password: https://catalinsbera.beta.bitstone.eu/reset?token=$resetToken");
    }

}