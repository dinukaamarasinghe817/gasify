<?php

class Database
{

    public $mysqli;

    public function __construct()
    {
        $this->dbConnect();
    }
    
    public function __destruct()
    {
        $this->dbClose();
    }

    private function dbConnect()
    {
        $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        return $this->mysqli;
    }

    public function numOfRows($result)
    {
        return $result->num_rows;
    }

    public function Query($sql)
    {
        $result = $this->mysqli->query($sql);
        return $result;
    }

    public function dbClose()
    {
        $this->mysqli->close();
    }

}