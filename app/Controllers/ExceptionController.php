<?php


namespace App\Controllers;


class ExceptionController extends BaseController
{

    private $errorCode;
    private $errorMessage;

    public function __construct($errorCode, $errorMessage)
    {
        parent::__construct();
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }

    public function displayException()
    {
        //var_dump($this);
        $this->bladeResponse(['code' => $this->errorCode,
            'message' => $this->errorMessage], 'exception/exception');
    }
}