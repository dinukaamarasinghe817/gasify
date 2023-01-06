<?php

class Delivery extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDistributors($delivery_id){  
        $result = $this->read('distributor', "company_id = $delivery_id", "city");
        return $result;
    }

    public function getAllCompanies(){  
        $result = $this->Query("SELECT c.name AS name, u.email AS email, CONCAT(c.street,', ',c.city) AS address FROM company c INNER JOIN users u ON c.company_id = u.user_id");
        $data = [];
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['name'=>$row['name'], 'email'=>$row['email'], 'address'=>$row['address']]);
            }
            $data['company'] = $info;
        }
        return $data['company'];
    }
    public function getDeliveryImage($delivery_id){
        $result = $this->read('delivery_person', "delivery_id = $delivery_id");
        return $result;
    }
    
    
}