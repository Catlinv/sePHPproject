<?php


namespace App\Utility;

session_start();

class Session
{
    static public function get($attr = null, $alt = null)
    {
        if ($attr === null) return $_SESSION;
        return (isset($_SESSION[$attr])) ? $_SESSION[$attr] : $alt;
    }

    static public function set($attr, $val)
    {
        $_SESSION[$attr] = $val;
    }

    static public function forget($attr)
    {
        if ($attr !== null && (is_string($attr) ? strlen($attr) > 0 : true))
            unset($_SESSION[$attr]);
    }

}