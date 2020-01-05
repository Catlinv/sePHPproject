<?php

namespace App\Controllers;

use App\Database\Database;
use App\Services\LoginService;
use App\Services\RegisterService;
use App\Services\RemindService;
use App\Services\ResetService;
use App\Utility\Session;
use App\Utility\Validator;
use mysqli;

class AuthentificatorController extends BaseController
{
    public function displayLogin()
    {
        $this->bladeResponse([], 'login/login');
    }

    public function attemptLogin()
    {

        $service = new LoginService();
        $errors = $service->validateLoginData();

        if (count($errors) != 0) {
            $this->bladeResponse(['error' => $errors], 'login/login');
        } else {
            $service->setUserData();
            header("Location: ". baseURL(). "/home");
            exit;
        }
    }

    public function displayRegister()
    {
        $this->bladeResponse([], 'login/register');
    }

    public function attemptRegister()
    {

        $service = new RegisterService();
        $errors = $service->validateRegisterData();

        if (count($errors) != 0) {
            $this->bladeResponse(['error' => $errors], 'login/register');
        } else {
            $service->registerUser();
            header("Location: ". baseURL(). "/home");
            exit;
        }
    }

    public function confirmUser()
    {
        $token = (isset($_GET['token'])) ? clean_input($_GET['token']) : null;
        $database = new Database();
        $result = $database->select("users", ["id"], "token LIKE \"" . $token . "\"");
        if (count($result) > 0) {
            $database->update("users", ["confirmed" => "1"], "id = " . $result[0]['id']);
        }
        header("Location: ". baseURL(). "/home");
        exit;
    }

    public function displayRemind()
    {
        $this->bladeResponse([], 'login/remind');
    }

    public function attemptRemind()
    {

        $service = new RemindService();
        $errors = $service->validateRemindData();

        if (count($errors) != 0) {
            $this->bladeResponse(['error' => $errors], 'login/remind');
        } else {
            $service->remindUser();
            header("Location: ". baseURL(). "/home");
            exit;
        }
    }

    public function displayReset()
    {
        $resetToken = (isset($_GET['token'])) ? $_GET['token'] : null;
        $this->bladeResponse(['resetToken' => $resetToken], 'login/reset');
    }

    public function attemptReset()
    {

        $service = new ResetService();
        list($errors, $resetToken) = $service->validateResetData();

        if (count($errors) != 0) {
            $this->bladeResponse(['error' => $errors, 'resetToken' => $resetToken], 'login/reset');
        } else {
            $service->resetPassword();
            header("Location: ". baseURL(). "/home");
            exit;
        }
    }
}