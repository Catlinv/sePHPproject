<?php


namespace App\Exceptions;


use Exception;
use Throwable;

class UnknownPathException extends Exception
{
    private $path;

    public function __construct($path, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = "User tried to access: " . $path;
    }

    public function __toString()
    {
        return "“The unhappy people of the known paths must certainly try the unknown paths in their search of happiness!” (Mehmet Murat ildan) Unfortunatly the path \"" . $this->path .
            "\" is known to be a wrong one. ";
    }

}