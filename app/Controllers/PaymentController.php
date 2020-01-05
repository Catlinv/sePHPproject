<?php


namespace App\Controllers;

use App\Database\Database;
use App\Utility\Session;

\Stripe\Stripe::setApiKey('sk_test_ooercmchLT1eUF7z37wLtJW900znqiXJ3B');

class PaymentController extends BaseController
{
    public function index(){
        $order_id = Session::get('order_id');
        $database = new Database();
        $price = $database->select('orders',['total_price'], "id = $order_id")[0]['total_price'];
        $intent = \Stripe\PaymentIntent::create([
            'amount' => intval($price) * 100,
            'currency' => 'ron',
        ]);
        ($database)->update("orders",["payment_intent" => $intent->id],"id = $order_id");
        $userData = array(
            'clientId' => Session::get('user')['id'],
            'clientKey' => "Client" . Session::get('user')['id'],
            'storeKey' => "Store",
            'sum' => $price,
        );
        $this->bladeResponse(["userData" => $userData],"payment/payment");
    }

    public function getStripeResponse(){
        //var_dump($this->request->getParameters()['data']['object']['id']);

        $database = new Database();
        $order = ($database)->select("orders",null,"payment_intent LIKE \"" . $this->request->getParameters()['data']['object']['payment_intent'] ."\"")[0];
        $clientEmail = $database->select("users",['email'],'id = ' . Session::get('user')['id']);

        if($this->request->getParameters()['data']['object']['status'] === "succeeded"){
            $filename = basePath() . '\public\ordersPDFs\order-'. $order['id'] .'.pdf';
            sendEmailWithTitleAndBody($clientEmail, "Order payment successful", "Order has been payed for", $filename);
        } else {
            echo "error";
            sendEmailWithTitleAndBody($clientEmail, "Order payment failed", "An error has occured");
        }

    }

    public function succ(){

        $clientEmail = Session::get('user')['email'];
        $order_id = Session::get('order_id');

        $filename = basePath() . '\public\ordersPDFs\order-'. $order_id .'.pdf';
        sendEmailWithTitleAndBody($clientEmail, "Order payment successful", "Order has been payed for", $filename);

        header("Location: http://ecommerce");
        die();
    }

    public function noFunds(){
       $clientEmail = Session::get('user')['email'];

        echo "error";
        sendEmailWithTitleAndBody($clientEmail, "Order payment failed", "Not enough funds");
        header("Location: http://ecommerce");
        die();
    }

    public function noAcc(){
        $clientEmail = Session::get('user')['email'];

        echo "error";
        sendEmailWithTitleAndBody($clientEmail, "No bank account was found", "An error has occured");
        header("Location: http://ecommerce");
        die();
    }

    public function wrongKey(){
        $clientEmail = Session::get('user')['email'];

        echo "error";
        sendEmailWithTitleAndBody($clientEmail, "A suspicious payment was tried from your account. Please check your passwords.", "An error has occured");
        header("Location: http://ecommerce");
        die();
    }
}