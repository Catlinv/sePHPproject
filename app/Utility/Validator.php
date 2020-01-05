<?php


namespace App\Utility;


use App\Database\Database;
use Exception;

error_reporting(E_ERROR);

class Validator
{
    public $data;

    public function __construct($data)
    {
        $this->data = [];
        foreach ($data as $k => $v) {
            $this->data[$k] = clean_input($v);
        }
    }

    public static function validate(array $data, array $rulesArr, array $errorsArr, array $rez = [])
    {
        $validator = new Validator($data);
        for ($i = 0; $i < count($rulesArr); $i++) {
            $field = key($rulesArr);
            $rules = current($rulesArr);
            $errors = current($errorsArr);
            $n = count($rules);
            for ($j = 0; $j < $n; $j++) {
                $aux = explode("::", $rules[$j]);
                $rule = $aux[0];
                $extra = array_slice($aux, 1);
                if ($validator->{$rule}($field, $extra) === false) {
                    $rez[$errors[$j]] = true;
                    break;
                }
            }
            next($rulesArr);
            next($errorsArr);
        }
        return $rez;
    }

    public function required($field, $extra = null)
    {
        $value = $this->data[$field];
        if (!isset($value)) return false;
        if (is_string($value))
            return strlen($value) > 0;
        return true;
    }

    public function email($field, $extra = null)
    {
        $value = $this->data[$field];
        if (!isset($value)) return false;
        if (is_string($value) && strlen($value) == 0) return false;
        return (preg_match('/[a-zA-Z0-9]+@[a-zA-Z0-9]+.[a-zA-Z0-9]{2,3}/', $value) === 1);
    }

    public function phone($field, $extra = null)
    {
        $value = $this->data[$field];
        if (!isset($value)) return false;
        if (is_string($value) && strlen($value) == 0) return false;
        return (preg_match('/(\+407)([0-9]{8})/', $value) === 1);
    }

    public function unique($field, $extra = null)
    {
        $table = $extra[0];
        $column = $extra[1];
        $value = $this->data[$field];
        if (!isset($table) || !isset($value) || !isset($value)) return false;
        $db = new Database();
        $rez = $db->select($table, null, "$column LIKE \"$value\"");
        return count($rez) === 0;
    }

    public function matching($field, $extra = null)
    {
        $field1 = $this->data[$field];
        $field2 = $this->data[$extra[0]];
        if (!isset($field1) || !isset($field2)) return false;
        return $field1 === $field2;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        return true;
    }

}