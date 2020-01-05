<?php


namespace App\Core;


class ParameterBag
{
    private $values;

    public function __construct($arr = null)
    {
        $this->values = $arr;
    }

    public static function getParameterBag($arr, $type)
    {
        switch ($type) {
            case 'parameters':
                return new ParameterBag(($arr['REQUEST_METHOD'] === 'GET') ? $_GET : $_POST);
                break;
            case 'server':
                return new ParameterBag($arr);
                break;
            case 'files':
            case 'headers':
                $headers = [];
                $contentHeaders = ['CONTENT_LENGTH' => true, 'CONTENT_TYPE' => true];
                foreach ($arr as $key => $value) {
                    // headers that are prefixed with HTTP_
                    if (0 === strpos($key, 'HTTP_')) {
                        $headers[substr($key, 5)] = $value;
                    } elseif (isset($contentHeaders[$key])) {
                        $headers[$key] = $value;
                    }
                }
                return new ParameterBag($headers);
                break;
            default:
                return null;
        }
    }

    public function get($str = "")
    {
        if (!is_string($str)) return null;
        if (strlen($str) == 0) return $this->values;

        $arr = explode(".", $str);
        $aux = $this->values;
        do {
            if (!is_array($aux) || !isset($aux[current($arr)])) return null;
            $aux = $aux[current($arr)];
        } while (next($arr) !== false);

        return $aux;
    }

    public function getValues()
    {
        return $this->values;
    }

}