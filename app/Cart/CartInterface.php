<?php

namespace App\Cart;
interface CartInterface
{
    public function addToCart($product);

    public function removeFromCart($product);

    public function modifyUnits($product, $amount);

    public function getProductsFromCart();
}
