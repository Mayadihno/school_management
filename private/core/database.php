<?php

class Database
{
    // Array to hold functions to be executed after select queries
    protected $afterSelect = [];

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

    public function query($query, $data = array(), $data_type = 'object')
    {
        $con = $this->connect();
        $stmt = $con->prepare($query);
        $results = false;


        if ($stmt) {
            $check = $stmt->execute($data);
            if ($check) {
                if ($data_type == 'object') {
                    $results = $stmt->fetchAll(PDO::FETCH_OBJ);
                } else {
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
        }
        //run this after selecting from db
        if (is_array($results)) {
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $results = $this->$func($results);
                }
            }
        }
        if (is_array($results) && count($results) > 0) {
            return $results;
        }
        return false;
    }
}
