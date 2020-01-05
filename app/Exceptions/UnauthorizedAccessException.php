<?php


namespace App\Exceptions;


use Exception;
use Throwable;

class UnauthorizedAccessException extends Exception
{
    public function __construct($path, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = "User tried to access: " . $path;
    }

    public function __toString()
    {
        return "Access denied ";
    }


}