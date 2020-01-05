<?php

namespace App\Utility;

class Sorter
{

    static public function sort($products, $field)
    {
        $order = Session::get('order');
        if ($order == 'asc') {
            usort($products, function ($a, $b) use ($field) {
                if (is_string($a[$field]))
                    return strcmp($a[$field], $b[$field]);
                else
                    return $a[$field] - $b[$field];
            });
            Session::set('order', 'desc');
        } else {
            usort($products, function ($a, $b) use ($field) {
                if (is_string($a[$field]))
                    return -(strcmp($a[$field], $b[$field]));
                else
                    return -($a[$field] - $b[$field]);
            });
            Session::set('order', 'asc');
        }
        return $products;
    }
}