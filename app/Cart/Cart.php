<?php

namespace App\Cart;
require_once "CartInterface.php";

class Cart implements CartInterface
{

    private $cart;

    public function __construct($cart)
    {
        $this->cart = $cart;
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function addToCart($product)
    {
        if ($product === null) return null;

        foreach ($this->cart as $e) {
            if ($e['id'] == $product['id']) {
                return null;
            }
        }

        $product['units'] = 1;
        $product['price'] = doubleval($product['price']);
        $this->cart[] = $product;
        return $this->cart;
    }

    public function removeFromCart($product)
    {

        if ($product === null) return null;
        $key = null;
        for ($i = 0; $i < count($this->cart); $i++) {
            if ($this->cart[$i]['id'] == $product['id']) {
                $key = $i;
                break;
            }
        }

        array_splice($this->cart, $key, 1);

        return $product;
    }

    public function modifyUnits($product, $amount)
    {
        if ($product === null || $amount === null) return null;

        $key = null;
        for ($i = 0; $i < count($this->cart); $i++) {
            if ($this->cart[$i]['id'] == $product['id']) {
                $key = $i;
                break;
            }
        }

        $this->cart[$key]['units'] = ($this->cart[$key]['units'] + $amount <= 0) ? $this->cart[$key]['units'] : $this->cart[$key]['units'] + $amount;

        return $this->cart[$key];
    }

    public function getProductsFromCart()
    {
        return $this->cart;
    }
}