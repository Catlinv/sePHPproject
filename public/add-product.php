<?php

$config = require_once '../config.php';

// TODO - work with the $_REQUEST and $_SESSION['cart'] and update accordingly

//this is used to redirect the page back to index.php after adding product to cart
header('Location: '.$config['url']);
die();


