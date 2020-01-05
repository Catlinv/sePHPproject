<?php


namespace App\Exceptions;


use App\Utility\Session;
use Exception;
use Throwable;

class ProductInCartException extends Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = "User tried to add already existing product in cart";
    }

    public function __toString()
    {
        return "Product already in cart";
    }

}