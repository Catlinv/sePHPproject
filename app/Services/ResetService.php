<?php


namespace App\Services;


use App\Database\Database;
use App\Utility\Validator;

class ResetService
{
    private $id;
    private $resetToken;
    private $email;
    private $password;

    public function validateResetData()
    {
        $errors = Validator::validate($_POST,
            ['password1' => ['required'],
                'password2' => ['required', 'matching::password1']],
            ['password1' => ['password1'],
                'password2' => ['password2', 'passwordMatch']]);

        if (count($errors) == 0) {
            $this->id = null;
            $this->resetToken = (isset($_POST['resetToken'])) ? clean_input($_POST['resetToken']) : null;
            $this->email = null;
            $this->password = clean_input($_POST['password1']);

            $database = new Database();
            $result = $database->select("users", ["id", "email"], "reset_token = \"" . $this->resetToken . "\"");
            if (count($result) == 0 || $this->resetToken === null)
                $errors['invalidToken'] = true;
            else {
                $this->id = $result[0]['id'];
                $this->email = $result[0]['email'];
            }
        }

        return [$errors, $this->resetToken];
    }

    public function resetPassword()
    {
        $database = new Database();
        $database->update("users", ['password' => md5($this->password), 'reset_token' => ""], "id = $this->id");
        sendEmailWithTitleAndBody($this->email, "Password reset successful", "Your password has been successfully changed");
    }
}