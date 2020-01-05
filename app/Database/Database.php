<?php

namespace App\Database;

use App\Utility\Config;
use mysqli;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\MySQL;

class Database
{
    private $conn;

    public function __construct($loginInfo = null)
    {
        if ($loginInfo === null) $loginInfo = (new Config())->get('database');

        $this->conn = new mysqli($loginInfo['server'], $loginInfo['username'], $loginInfo['password'], $loginInfo['name']);
        if ($this->conn->connect_error) {
            var_dump($this->conn->connect_error);
        }
    }

    private function convertResult($result, $columns)
    {
        $rez = [];
        while ($row = $result->fetch_assoc()) {
            $aux = [];
            foreach ($columns as $v) {
                $aux[$v] = $row[$v];
            }
            $rez[] = $aux;
        }
        return $rez;
    }

    public function select($tableName, $columnNames = null, $condition = null)
    {
        if ($columnNames === null) {
            $sql = "SHOW COLUMNS FROM $tableName";
            $res = $this->conn->query($sql);

            while ($row = $res->fetch_assoc()) {
                $columnNames[] = $row['Field'];
            }
        }
        $columns = implode(", ", $columnNames);
        if (isset($condition)) {
            $stmt = $this->conn->prepare("SELECT $columns FROM $tableName WHERE $condition");
        } else {
            $stmt = $this->conn->prepare("SELECT $columns FROM $tableName");
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $this->convertResult($result, $columnNames);
    }

    public function insert($tableName, $columns)
    {
        $columnNames = [];
        $columnValues = [];
        foreach ($columns as $k => $v) {
            $columnNames[] = $k;
            if (is_string($v))
                $columnValues[] = "\"" . $v . "\"";
            else
                $columnValues[] = $v;
        }
        $columnNames = implode(", ", $columnNames);
        $columnValues = implode(", ", $columnValues);

        $stmt = $this->conn->prepare("INSERT INTO $tableName ($columnNames) VALUES ($columnValues)");

        $stmt->execute();
    }

    public function update($tableName, $columns, $condition = null)
    {
        $newValues = [];
        foreach ($columns as $k => $v) {
            if (is_string($v)) {
                if (strlen($v) != 0)
                    $newValues[] = $k . " = " . "\"" . $v . "\"";
                else
                    $newValues[] = $k . " = " . "NULL";
            } else {
                $newValues[] = $k . " = " . $v;
            }
        }
        $newValues = implode(",", $newValues);

        if (isset($condition)) {
            $stmt = $this->conn->prepare("UPDATE $tableName SET $newValues WHERE $condition");
        } else {
            $stmt = $this->conn->prepare("UPDATE $tableName SET $newValues");
        }

        return $stmt->execute();
    }

    public function delete($tableName, $condition = null)
    {
        if (isset($condition)) {
            $stmt = $this->conn->prepare("DELETE FROM $tableName WHERE $condition");
        } else {
            $stmt = $this->conn->prepare("DELETE FROM $tableName");
        }

        return $stmt->execute();
    }

    public function getLastInsertedId()
    {
        return $this->conn->insert_id;
    }

    public static function getDatatable()
    {
        $config = (new Config())->get('database');
//        $config = ['host' => 'localhost',
//            'port' => '3306',
//            'username' => 'root',
//            'password' => '',
//            'database' => 'ecommerce'];
        $config['port'] = '3306';
        $config['host'] = $config['server'];
        $config['database'] = $config['name'];

        return new Datatables(new MySQL($config));
    }


}
