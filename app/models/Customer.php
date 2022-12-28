<?php

class Customer extends Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function getCustomerImage($customer_id){
        $result = $this->read('customer', "customer_id = $customer_id");
        return $result;
    }

    public function getCompanyBrand(){
        $result = $this->Query("SELECT name,logo FROM company");
        return $result;
    }
    
    public function getRecentorders($customer_id){
        $result1 = $this->Query("SELECT order_id,order_state,place_date
            FROM reservation
            WHERE customer_id = '{$customer_id}'
            ORDER BY place_date DESC LIMIT 3");
        
        

        if($result1>0){
            $result2 = $this->Query("");
        }
    }



  

}





?>