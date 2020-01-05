<?php


namespace App\Filters;


use App\Database\Database;
use App\Exceptions\UnauthentificatedUserException;
use App\Exceptions\UnauthorizedAccessException;
use App\Utility\Session;

class UserFilter
{
    public function handle($arg = null)
    {
        $user = Session::get('user');
        if (!isset($user)) throw new UnauthentificatedUserException("without being authentificated");
    }

}