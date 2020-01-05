<?php

use App\Core\Router;

$router = new Router();

$router->get('/home', 'ProductsController@displayProducts');

$router->get('/cart', 'CartController@displayCart')->filter('user');
$router->post('/addToCart', 'CartController@addToCart')->filter('user');
$router->post('/removeFromCart', 'CartController@removeFromCart')->filter('user');
$router->post('/modifyUnits', 'CartController@modifyUnits')->filter('user');
$router->post('/order', 'CartController@placeOrder')->filter('user');

$router->get('/login', 'AuthentificatorController@displayLogin');
$router->post('/loginUser', 'AuthentificatorController@attemptLogin');
$router->get('/confirm', 'AuthentificatorController@confirmUser');

$router->get('/register', 'AuthentificatorController@displayRegister');
$router->post('/registerUser', 'AuthentificatorController@attemptRegister');

$router->get('/remind', 'AuthentificatorController@displayRemind');
$router->post('/remindUser', 'AuthentificatorController@attemptRemind');

$router->get('/reset', 'AuthentificatorController@displayReset');
$router->post('/resetUser', 'AuthentificatorController@attemptReset');

$router->get('/category', 'CategoryController@getCategories')->filter('admin');;

$router->get('/categories', 'CategoryController@index')->filter('admin');;
$router->get('/categories/create', 'CategoryController@create')->filter('admin');;
$router->post('/categories', 'CategoryController@store')->filter('admin');;

$router->get('/categories/{id}', 'CategoryController@show')->filter('admin');;
$router->get('/categories/{id}/edit', 'CategoryController@edit')->filter('admin');;
$router->post('/categories/{id}/update', 'CategoryController@update')->filter('admin');;
$router->get('/categories/{id}/delete', 'CategoryController@delete')->filter('admin');;

$router->get('/product', 'ResourceController@getProducts')->filter('admin');;

$router->get('/products', 'ResourceController@index')->filter('admin');
$router->get('/products/create', 'ResourceController@create')->filter('admin');
$router->get('/products/export', 'ResourceController@exportProducts')->filter('admin');
$router->get('/products/template', 'ResourceController@getTemplate')->filter('admin');
$router->post('/products/import', 'ResourceController@addProductsFromCSV')->filter('admin');
$router->post('/products', 'ResourceController@store')->filter('admin');

$router->get('/products/{id}', 'ResourceController@show')->filter('user');;
$router->get('/products/{id}/edit', 'ResourceController@edit')->filter('admin');
$router->post('/products/{id}/update', 'ResourceController@update')->filter('admin');
$router->get('/products/{id}/delete', 'ResourceController@delete')->filter('admin');

$router->get('/order', 'OrderController@getOrders')->filter('admin');
$router->get('/order/history', 'OrderController@getOrderHistory')->filter('user');

$router->get('/orders', 'OrderController@index')->filter('admin');
$router->get('/orders/history', 'OrderController@historyIndex')->filter('user');
$router->get('/orders/{id}', 'OrderController@show')->filter('owner');
$router->get('/orders/{id}/delete', 'OrderController@delete')->filter('admin');
$router->get('/orders/{id}/download', 'OrderController@downloadPDF')->filter('admin');

$router->get('/payment', 'PaymentController@index')->filter('user');
$router->get('/nullC', 'PaymentController@noAcc');
$router->get('/succ', 'PaymentController@succ');
$router->get('/noFunds', 'PaymentController@noFunds');
$router->get('/wrongKey', 'PaymentController@wrongKey');

return $router;
