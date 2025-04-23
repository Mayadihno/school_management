<?php

class Model extends Database
{
    protected $table;
    public $errors = array();
    protected $allowedColumns = [];
    protected $beforeInsert = [];
    protected $afterSelect = [];


    public function __construct()
    {
        if (property_exists($this, 'table')) {
            $this->table = strtolower($this::class) . 's';
            //print_r($this->table);
        }
    }

    public function where($column, $value,)
    {
        $column = addslashes($column);
        $query = "SELECT * FROM $this->table WHERE $column = :value";

        $data = $this->query($query, [
            'value' => $value
        ]);

        //run this after selecting from db
        if (is_array($data)) {
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $data = $this->$func($data);
                }
            }
        }
        return $data;
    }

    public function findAll()
    {
        $query = "SELECT * FROM $this->table";
        $data = $this->query($query);

        //run this after selecting from db
        if (is_array($data)) {
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $data = $this->$func($data);
                }
            }
        }
        return $data;
    }
    public function insert($data)
    {
        //remove unwanted columns
        if (property_exists($this, 'allowedColumns')) {
            foreach ($data as $key => $column) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }
        //run this before insert to db
        if (property_exists($this, 'beforeInsert')) {
            foreach ($this->beforeInsert as $func) {
                $data = $this->$func($data);
            }
        }

        $keys = array_keys($data);
        $column = implode(', ', $keys);
        $values = implode(',:', $keys);

        $query = "INSERT INTO $this->table ($column) VALUES (:$values)";

        return $this->query($query, $data);
    }

    public function update($id, $data)
    {
        $str = '';
        foreach ($data as $key => $value) {
            $str .= $key . "=:" . $key . ","; // $str = "name=:name,age=:age";
        }
        $str = trim($str, ',');
        $data['id'] = $id;
        $query = "UPDATE $this->table SET $str WHERE id = :id";
        return $this->query($query, $data);
    }

    public function delete($id)
    {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $data['id'] = $id;
        return $this->query($query, $data);
    }
}
