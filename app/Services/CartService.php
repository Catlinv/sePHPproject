<?php


namespace App\Services;


use App\Controllers\OrderController;
use App\Database\Database;
use App\Utility\Session;

class CartService
{
    private $products;
    private $cart;

    public function checkOrderStock()
    {
        $this->products = getProducts();
        $this->cart = Session::get('cart', []);
        $error = [];

        foreach ($this->cart as $e) {
            if ($e['units'] > $this->products[$e['id']]['units']) {
                $error[$e['id']] = $e['units'] - $this->products[$e['id']]['units'];
            }
        }

        return $error;
    }

    public function generateInsuficientStockMessage($error, $email)
    {
        $errorText = "The following items exceed our stock: \n";
        foreach ($error as $k => $v) {
            $errorText .= $this->products[$k]['name'] . " - $v\n";
        }
        sendEmailWithTitleAndBody($email, "Order placed failed. Items out of stock", $errorText);
    }

    public function placeOrder($userData)
    {
        $db = new Database();
        $totalPrice = array_reduce($this->cart, function ($c, $i) {
            $c += $i['units'] * $i['price'];
            return $c;
        }, 0);
        $db->insert("orders", ["user_id" => $userData['id'], "order_date" => date("Y-m-d H:i:s"), "total_price" => $totalPrice]);

        $order_id = $db->getLastInsertedId();

        $totalUnits = 0;
        foreach ($this->cart as $e) {
            $productId = $e['id'];
            $units = $e['units'];
            $totalUnits += $units;
            $remainingUnits = $this->products[$productId]['units'] - $units;
            $unitPrice = $e['price'];
            $totalItemPrice = $unitPrice * $units;

            $db->insert("order_items", ["order_id" => $order_id, "product_id" => $productId, "units" => $units, "unit_price" => $unitPrice, "total_price" => $totalItemPrice]);
            $db->update("products", ["units" => $remainingUnits], "id = $productId");
        }

        $orderFile = fopen(basePath() . "\\data\\orders.txt", "a+");
        $orderText = $userData['firstName'] . " " . $userData['lastName'] . " $totalPrice Lei, $totalUnits units " . date('g:ia l jS F o') . "\n";
        fwrite($orderFile, $orderText);
        fclose($orderFile);
        $dompdf = (new OrderController())->getDomPDF((new OrderController())->generateOrderBlade($order_id,'detailsPDF'));
        $dompdf->render();
        $output = $dompdf->output();
        $filename = basePath() . '\public\ordersPDFs\order-'. $order_id .'.pdf';
        file_put_contents($filename, $output);
        sendEmailWithTitleAndBody($userData['email'], "Order placed successfully", $orderText,$filename);
        Session::set('order_id',$order_id);
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function getProducts()
    {
        return $this->products;
    }
}