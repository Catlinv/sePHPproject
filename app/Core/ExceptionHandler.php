<?php

namespace App\Core;

use App\Controllers\ExceptionController;

class ExceptionHandler
{
    private $header;

    public function __construct($header)
    {
        $this->header = $header;
        //var_dump($header);
    }

    public function handle($e)
    {
        $this->report($e);
        $this->render($e);
    }

    protected function report($e)
    {
        //TODO - log this exception
        //echo "reporting the exception\n";
        file_put_contents(basePath() . "/logs/exceptions.log",$e->getMessage(), FILE_APPEND);
    }

    protected function render($e)
    {
        //TODO - return a custom blade for errors
        //TODO - return a custom blade for errors
        if(isset($this->header["CONTENT_TYPE"])){
            http_response_code(400);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            //echo json_encode(['text' => $this->header["CONTENT_TYPE"]]);
            echo json_encode(['text' => $e->__toString()]);
        }
        else{
            $controller = new ExceptionController($e->getCode(), $e->__toString());
            $controller->displayException();
        }
        //var_dump($e->getMessage(), $e->getLine(), $e->getFile(), $e->getTraceAsString());
        //echo "rendering the exception\n";
    }
}
