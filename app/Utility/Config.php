<?php

namespace App\Utility;

class Config
{
    private $configArray;

    public function __construct()
    {
        $this->configArray = [];
        $path = basePath() . "/config";
        $folder = preg_grep('/^([^.])/', scandir($path));
        foreach ($folder as $file) {
            $v = require($path . "/" . $file);
            $k = substr($file, 0, strlen($file) - 4);
            $this->configArray[$k] = $v;
        }
//        var_dump($this->configArray);
    }

    public function get($str = "")
    {
        if (!is_string($str)) return null;
        if (strlen($str) == 0) return $this->configArray;

        $arr = explode(".", $str);
        $aux = $this->configArray;
        do {
            if (!is_array($aux) || !isset($aux[current($arr)])) return null;
            $aux = $aux[current($arr)];
        } while (next($arr) !== false);

        return $aux;
    }
}