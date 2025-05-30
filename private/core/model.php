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
        if (!isset($this->table) || empty($this->table)) {
            $this->table = strtolower($this::class) . "s";
        }
    }

    protected function get_primary_key($table)
    {
        $query = "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'";
        $db = new Database();
        $result = $db->query($query);

        if (!empty($result)) {
            $result = $result[0];
            if (isset($result->Column_name)) {
                return $result->Column_name;
            }
        }
        return 'id';
    }

    public function where($column, $value, $orderBy = 'DESC', $col = 'date', $limit = 10, $offset = 0)
    {
        $column = addslashes($column);
        $query = "SELECT * FROM $this->table WHERE $column = :value ORDER BY $col $orderBy LIMIT $limit OFFSET $offset";


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

    public function whereOne($column, $value, $orderBy = 'DESC', $col = 'date')
    {
        $column = addslashes($column);
        $query = "SELECT * FROM $this->table WHERE $column = :value ORDER BY $col $orderBy";

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
        if (is_array($data)) {
            $data = $data[0];
        }
        return $data;
    }


    public function findAll($column = 'date', $orderBy = 'DESC', $limit = 10, $offset = 0)
    {
        $query = "SELECT * FROM $this->table ORDER BY $column $orderBy LIMIT $limit OFFSET $offset";
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
