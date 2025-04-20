<?php

class Database
{

    private function connect()
    {
        $string = 'mysql:host=localhost;dbname=school_db';
        $root = 'root';
        $pass = '';

        $con = new PDO($string, $root, $pass);
        if (!$con) {
            echo "Connection failed";
            die("Connection failed: " . $con->error);
        }
        return $con;
    }

    public function run($query, $data = [], $data_type = 'object')
    {
        $con = $this->connect();
        $stmt = $con->prepare($query);
        if ($stmt) {
            $check = $stmt->execute($data);
            if ($check) {
                if ($data_type == 'object') {
                    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
                } else {
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                if (is_array($data) && count($data) > 0) {
                    return $data;
                }
            }
        }
        return false;
    }
}
