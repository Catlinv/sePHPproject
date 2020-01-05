<?php

namespace App\Controllers;

use App\Database\Database;
use App\Utility\Config;
use App\Utility\ExcellManager;
use App\Utility\Session;
use App\Utility\Sorter;
use App\Utility\Validator;

class ResourceController extends BaseController implements ResourceControllerInterface
{
    public function getProducts()
    {
        $dataTable = Database::getDatatable();
        $dataTable->query('Select id, name, units, price, description, category_id from products');
        $dataTable->add('edit', function ($data) {
            // return a link in a new column

            return "<a href=/products/" . $data['id'] . "/edit>Edit</a>";
        });
        $dataTable->add('delete', function ($data) {
            // return a link in a new column
            return "<a href='/products/" . $data['id'] . "/delete'>Delete</a>";
        });

        echo $dataTable->generate();
    }

    public function index()
    {
        $userData = Session::get('user');
        $this->bladeResponse(['userData' => $userData], 'products/products');
    }

    public function show($id)
    {
        // TODO: Implement show() method.
        $product = ((new Database())->select("products", null, "id = $id")[0]);
        $userData = Session::get('user');
        $this->bladeResponse(['userData' => $userData,"product" => $product], 'products/details');
    }

    public function create()
    {
        // TODO: Implement create() method.
        $categories = (new Database())->select("category");
        $this->bladeResponse(["categories" => $categories], 'products/createForm');
    }

    public function store()
    {
        // TODO: Implement store() method.
        $errors = Validator::validate($_POST,
            ['name' => ['required'],
                'units' => ['required'],
                'price' => ['required'],
                'description' => ['required']],
            ['name' => ['name'],
                'briefing' => ['briefing'],
                'price' => ['price'],
                'description' => ['description']]);
        if (count($errors) > 0) {
            $categories = (new Database())->select("category");
            $this->bladeResponse(['error' => $errors, "categories" => $categories], 'products/createForm');
        } else {
            $name = (clean_input($_POST['name']));
            $units = (clean_input($_POST['units']));
            $price = (clean_input($_POST['price']));
            $description = clean_input($_POST["description"]);
            $categoryId = (clean_input($_POST['categoryId']));
            (new Database())->insert("products", ['name' => $name, 'units' => $units, 'price' => $price, 'description' => $description, 'category_id' => $categoryId]);
            header("Location: ". baseURL(). "/products");
        }
    }

    public function edit($id)
    {
        // TODO: Implement edit() method.
        $product = (new Database())->select("products", null, "id = $id")[0];
        //var_dump($product);
        $categories = (new Database())->select("category");
        $this->bladeResponse(['product' => $product, "categories" => $categories], 'products/editForm');
    }

    public function update($id)
    {
        // TODO: Implement update() method.
        $errors = Validator::validate($_POST,
            ['name' => ['required'],
                'units' => ['required'],
                'price' => ['required'],
                'description' => ['required']],
            ['name' => ['name'],
                'briefing' => ['briefing'],
                'price' => ['price'],
                'description' => ['description']]);
        if (count($errors) > 0) {
            $product = (new Database())->select("products", null, "id = $id")[0];
            $this->bladeResponse(['error' => $errors, 'product' => $product], 'products/editForm');
        } else {
            $id = $_POST['id'];
            $name = (clean_input($_POST['name']));
            $units = (clean_input($_POST['units']));
            $price = (clean_input($_POST['price']));
            $description = clean_input($_POST["description"]);
            $categoryId = (clean_input($_POST['categoryId']));
            (new Database())->update("products", ['name' => $name, 'units' => $units, 'price' => $price, 'description' => $description, 'category_id' => $categoryId], "id = $id");
            header("Location: ". baseURL(). "/products");
        }
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        (new Database())->delete("products", "id = $id");
        header("Location: ". baseURL(). "/products");
    }

    public function exportProducts()
    {
        $exporter = new ExcellManager();
        $exporter->exportTableCSV("products");
    }

    public function getTemplate()
    {
        $exporter = new ExcellManager();
        $exporter->exportCSVTemplate("import-template.csv");
    }

    public function addProductsFromCSV()
    {
        $file = $_FILES['fileToUpload'];
        $name = explode('.', $file['name']);
        $ext = end($name);
        if ($file['size'] <= 0 || $file['size'] > 2 * 1024 || !in_array($ext, ['csv', 'xml', 'xmlx'])) {
            $userData = Session::get('user');
            $this->bladeResponse(['userData' => $userData, 'error' => ['invalidFile' => true]], 'products/products');
            exit;
        }
        $exporter = new ExcellManager();
        $exporter->importCSV($file['tmp_name'], "products");
        header("Location: ". baseURL(). "/products");
    }
}