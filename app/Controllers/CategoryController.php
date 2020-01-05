<?php

namespace App\Controllers;

use App\Database\Database;
use App\Utility\Config;
use App\Utility\Session;
use App\Utility\Sorter;
use App\Utility\Validator;

class CategoryController extends BaseController implements ResourceControllerInterface
{
    public function getCategories()
    {
        $dataTable = Database::getDatatable();
        $dataTable->query('Select id, name, briefing from category');
        $dataTable->add('edit', function ($data) {
            // return a link in a new column

            return "<a href=/categories/" . $data['id'] . "/edit>Edit</a>";
        });
        $dataTable->add('delete', function ($data) {
            // return a link in a new column
            return "<a href='/categories/" . $data['id'] . "/delete'>Delete</a>";
        });

        echo $dataTable->generate();
    }

    public function index()
    {
        $userData = Session::get('user');
        $this->bladeResponse(['userData' => $userData], 'category/category');
    }

    public function show($id)
    {
        // TODO: Implement show() method.
        var_dump((new Database())->select("category", null, "id = $id")[0]);
    }

    public function create()
    {
        // TODO: Implement create() method.
        $this->bladeResponse([], 'category/createForm');
    }

    public function store()
    {
        // TODO: Implement store() method.
        $errors = Validator::validate($_POST,
            ['name' => ['required'],
                'briefing' => ['required']],
            ['name' => ['name'],
                'briefing' => ['briefing']]);
        if (count($errors) > 0)
            $this->bladeResponse(['error' => $errors], 'category/createForm');
        else {
            $name = (clean_input($_POST['name']));
            $briefing = clean_input($_POST["briefing"]);
            (new Database())->insert("category", ['name' => $name, 'briefing' => $briefing]);
            header("Location: ". baseURL(). "/categories");
        }
    }

    public function edit($id)
    {
        // TODO: Implement edit() method.
        $category = (new Database())->select("category", null, "id = $id")[0];
        var_dump($category['name']);
        $this->bladeResponse(['name' => $category['name'], 'briefing' => $category['briefing'], 'id' => $category['id']], 'category/editForm');
    }

    public function update($id)
    {
        // TODO: Implement update() method.
        $errors = Validator::validate($_POST,
            ['name' => ['required'],
                'briefing' => ['required']],
            ['name' => ['name'],
                'briefing' => ['briefing']]);
        $category = (new Database())->select("category", null, "id = $id")[0];
        if (count($errors) > 0)
            $this->bladeResponse(['error' => $errors, 'name' => $category['name'], 'briefing' => $category['briefing'], 'id' => $category['id']], 'category/editForm');
        else {
            $name = (clean_input($_POST['name']));
            $briefing = clean_input($_POST["briefing"]);
            $id = $_POST['id'];
            (new Database())->update("category", ['name' => $name, 'briefing' => $briefing], "id = $id");

            header("Location: ". baseURL(). "/categories");
        }
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        (new Database())->delete("category", "id = $id");
        header("Location: ". baseURL(). "/categories");
    }
}