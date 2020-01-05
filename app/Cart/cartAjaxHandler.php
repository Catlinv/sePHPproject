<?php

namespace App\Cart;
require_once "Cart.php";

session_start();

$cart = new Cart(isset($_SESSION['cart']) ? $_SESSION['cart'] : []);

$operation = (isset($_POST['operation'])) ? $_POST['operation'] : null;

switch ($operation) {
    case "addToCart":
        $aux = $cart->addToCart(isset($_POST['product']) ? $_POST['product'] : null);
        setHttpResponse($aux, $cart->getCart());
        break;
    case "modifyUnits":
        $aux = $cart->modifyUnits(isset($_POST['product']) ? $_POST['product'] : null, isset($_POST['inc']) ? $_POST['inc'] : null);
        setHttpResponse($aux, $cart->getCart());
        break;
    case "removeFromCart":
        $aux = $cart->removeFromCart(isset($_POST['product']) ? $_POST['product'] : null);
        setHttpResponse($aux, $cart->getCart());
        break;
    default:
        setHttpResponse(null, null);
}

function setHttpResponse($jsonObject, $cart)
{
    if ($jsonObject !== null)
        $_SESSION['cart'] = $cart;
    http_response_code($jsonObject === null ? 200 : 400);
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo $jsonObject;
    exit;
}
