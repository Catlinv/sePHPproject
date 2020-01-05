<?php


namespace App\Controllers;


use App\Database\Database;
use App\Utility\Session;
use Dompdf\Dompdf;
use Dompdf\Options;

class OrderController extends BaseController
{
    public function getOrders()
    {
        $dataTable = Database::getDatatable();
        $dataTable->query('Select id, user_id, order_date, total_price from orders');

        $dataTable->add('delete', function ($data) {
            // return a link in a new column
            return "<a href='/orders/" . $data['id'] . "/delete'>Delete</a>";
        });

        echo $dataTable->generate();
    }

    public function getOrderHistory()
    {
        $userEmail = Session::get('user')['email'];
        $userID = (new Database())->select("users",['id'],"email LIKE \"". $userEmail . "\"")[0]['id'];
        $dataTable = Database::getDatatable();
        $dataTable->query('Select id, user_id, order_date, total_price from orders WHERE user_id = ' . $userID);

        echo $dataTable->generate();
    }

    public function index()
    {
        $userData = Session::get('user');
        $this->bladeResponse(['userData' => $userData], 'order/order');
    }

    public function historyIndex()
    {
        $userData = Session::get('user');
        $this->bladeResponse(['userData' => $userData], 'order/history');
    }

    public function show($id)
    {
        // TODO: Implement show() method.
        $blade = $this->generateOrderBlade($id,'details');
        echo $blade;
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        $database = new Database();
        $database->delete("orders", "id = $id");
        $database->delete("order_items", "order_id = $id");
        header("Location: ". baseURL(). "/orders");
    }

    public function downloadPDF($id){
        $blade = $this->generateOrderBlade($id,'detailsPDF');
        $dompdf = $this->getDomPDF($blade);
        $dompdf->render();
        $dompdf->stream();
    }

    public function getDomPDF($blade){
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($blade);
        return $dompdf;
    }

    public function generateOrderBlade($id,$view){
        $database = new Database();
        $order = ($database->select("orders", null, "id = $id")[0]);
        $orderItems = $database->select('order_items',null,"order_id = $id");
        $client = $database->select('users',null,"id = ". $order['user_id'])[0];
        $products = $database->select('products');
        $productNames = [];
        foreach ($orderItems as $item){
            foreach($products as $product){
                if($product['id'] == $item['product_id']){
                    $productNames[$product['id']] = $product['name'];
                    break;
                }
            }
        }
        return $this->getBladeResponse(['client' => $client,"order" => $order,'items' => $orderItems,'products' => $productNames], 'order/' . $view);
    }

}