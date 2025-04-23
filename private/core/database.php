<?php

class Database
{

    private function connect()
    {
        $string = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME;
        $root = DB_USER;
        $pass = DB_PASS;

        $con = new PDO($string, $root, $pass);
        if (!$con) {
            echo "Connection failed";
            die("Connection failed: " . $con->error);
        }
        return $con;
    }

    public function query($query, $data = [], $data_type = 'object')
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
