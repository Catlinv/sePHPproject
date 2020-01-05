<?php


namespace App\Filters;


use App\Database\Database;
use App\Exceptions\UnauthentificatedUserException;
use App\Exceptions\UnauthorizedAccessException;
use App\Utility\Session;

class AdminFilter
{
    public function handle($arg = null)
    {
        $user = Session::get('user');
        if (!isset($user)) throw new UnauthentificatedUserException();

        $database = new Database();
        $userRight = $database->select('users',['role'],'email LIKE "' . $user['email'] . '"')[0];
        if ($userRight['role'] != 'admin') throw new UnauthorizedAccessException("unauthoried site");
    }
}