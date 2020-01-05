<?php


namespace App\Filters;


use App\Database\Database;
use App\Exceptions\UnauthentificatedUserException;
use App\Exceptions\UnauthorizedAccessException;
use App\Utility\Session;

error_reporting(0);

class OwnerFilter
{
    public function handle($arg = null)
    {
        $order_id = intval($arg[0]);
        $user = Session::get('user');
        if (!isset($user)) throw new UnauthentificatedUserException();

        $database = new Database();
        $userData = $database->select('users',['role','id'],'email LIKE "' . $user['email'] . '"')[0];
        $orderUser = $database->select('orders',['user_id'],'id = ' . $order_id)[0];
        if ($userData['role'] != 'admin' && $userData['id'] != $orderUser['user_id']) throw new UnauthorizedAccessException("site not linked with his acc");
    }
}