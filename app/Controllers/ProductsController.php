<?php

namespace App\Controllers;

use App\Database\Database;
use App\Utility\Config;
use App\Utility\Session;
use App\Utility\Sorter;

setcookie("sessionTime", date('g:ia l jS F o'), time() + 1 * 60 * 60);

class ProductsController extends BaseController
{
    public function displayProducts()
    {
        $products = getProducts();
        $userData = Session::get('user');
        $sort = (isset($_GET['sort'])) ? $_GET['sort'] : null;
        if (isset($sort)) $products = Sorter::sort($products, $sort);
        $this->bladeResponse(['products' => $products,
            'userData' => $userData], 'products/list');
    }
}