<?php

class Model extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function read($table, $where = null, $order = null, $limit = null)
    {
        $sql = "SELECT * FROM $table";
        if ($where != null) {
            $sql .= " WHERE $where";
        }
        if ($order != null) {
            $sql .= " ORDER BY $order";
        }
        if ($limit != null) {
            $sql .= " LIMIT $limit";
        }
        $result = $this->Query($sql);
        return $result;
    }
    public function companyInsert($table, $data)
    {
        $sql = "INSERT INTO $table SET ";
        foreach ($data as $key => $value) {
            $sql .= "$key = '$value', ";
           
        }
        $sql = substr($sql, 0, -2);
        /*$sql = "INSERT INTO $table VALUES(";
        foreach ($data as $key => $value) {
           $sql .= "$value, ";
          // print_r($value);
        }
        $sql = substr($sql, 0, -2);
        $sql.=")";*/
        //print_r($sql);
        $result = $this->Query($sql);
        return $result;
    }
    public function insert($table, $data)
    {
        $sql = "INSERT INTO $table SET ";
        foreach ($data as $key => $value) {
            $sql .= "$key = '$value', ";
           
        }
        $sql = substr($sql, 0, -2);
        $result = $this->Query($sql);
        return $result;
    }

    public function update($table, $data, $where)
    {
        //print_r($data) ;
        $sql = "UPDATE $table SET ";
        foreach ($data as $key => $value) {
            $sql .= "$key = '$value', ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE $where";
        //print_r($sql);
        $result = $this->Query($sql);
        //return $result;
    }

    public function delete($table, $where)
    {
        $sql = "DELETE FROM $table WHERE $where";
        $result = $this->Query($sql);
        return $result;
    }
    public function loadDealers(){
        $sql="SELECT dealer.name,dealer.city,dealer.street,dealer.contact_no,dealer.email,dealer.capacity FROM dealer JOIN dealer_keep ON dealer.dealer_id=dealer_keep.dealer_id AND dealer_keep.company_id='{$_SESSION['userID']}'";
        $result=$this->Query($sql);
    }
    public function loadDistributors(){
        $sql="SELECT distributor.contact_no,distributor.city,distributor.street,distributor.hold_time,users.first_name,users.last_name,users.email FROM distributor INNER JOIN users WHERE distributor.distributor_id=users.user_id AND distributor.company_id='{$_SESSION['user_id']}'";
        $result=$this->Query($sql);
        return $result;
    }

    



} 