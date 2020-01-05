<?php

namespace App\Controllers;

use App\Cart\Cart;
use App\Database\Database;
use App\Exceptions\ProductInCartException;
use App\Services\CartService;
use App\Utility\Session;
use App\Utility\Sorter;
use mysqli;


class CartController extends BaseController
{

    public function addToCart()
    {

        $cart = new Cart(Session::get('cart', []));
        $data = (isset($_POST['product'])) ? $_POST['product'] : null;
        if (isset($data))
            $data = $cart->addToCart($data);
        if ($data === null) {
            throw new ProductInCartException();
        }
        Session::set('cart', $data);
        $this->jsonResponse($data, 200);
    }

    public function displayCart()
    {
        $cart = Session::get('cart', []);
        $userData = Session::get('user');
        $sort = (isset($_GET['sort'])) ? $_GET['sort'] : null;
        if (isset($sort)) $cart = Sorter::sort($cart, $sort);
        $this->bladeResponse(['products' => $cart,
            'userData' => $userData], 'cart/cart');
    }

    public function removeFromCart()
    {
        $cart = new Cart(Session::get('cart'));
        $product = (isset($_POST['product'])) ? $_POST['product'] : null;
        var_dump($product);
        $product = $cart->removeFromCart($product);
        Session::set('cart', $cart->getCart());
        $this->jsonResponse($product,200);
    }

    public function modifyUnits()
    {
        $cart = new Cart(Session::get('cart'));
        $product = (isset($_POST['product'])) ? $_POST['product'] : null;
        $units = (isset($_POST['inc'])) ? $_POST['inc'] : null;
        $product = $cart->modifyUnits($product, $units);
        Session::set('cart', $cart->getCart());
        $this->jsonResponse($product);
    }

    public function placeOrder()
    {
        $userData = Session::get('user');
        if (!isset($userData)) {
            $this->bladeResponse([
                'userData' => $userData,
                'products' => Session::get('cart', []),
                'error' => ['login' => true]
            ], 'cart/cart');
            exit;
        }

        $service = new CartService();
        $error = $service->checkOrderStock();

        if (count($error) > 0) {
            $service->generateInsuficientStockMessage($error, $userData['email']);
            $this->bladeResponse([
                'userData' => $userData,
                'products' => $service->getCart(),
                'stock' => $service->getProducts(),
                'error' => ['stock' => true, 'missing' => $error]
            ], 'cart/cart');
            exit;
        }

        $service->placeOrder($userData);

        Session::forget('cart');

        header("Location: ". baseURL(). "/payment");
    }
}