<?php

class Admin extends Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getAdmin($user_id){
        $data = [];
        $result = $this->Query("SELECT * FROM users u INNER JOIN admin a ON u.user_id = a.admin_id WHERE a.admin_id = $user_id");
        return $result;
    }
    public function companies(){
        $data['company'] = 5;
        return $data;
    }
    public function distributors(){
        $data['company'] = 5;
        return $data;
    }
    public function dealers(){
        $data['company'] = 5;
        return $data;
    }
    public function deliveries(){
        $data['company'] = 5;
        return $data;
    }
    public function customers(){
        $data['customers'] = $this->Query("SELECT * FROM users u INNER JOIN customer c ON u.user_id = c.customer_id");
        return $data;
    }
}