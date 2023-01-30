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
    public function getDeliveryVehicle($delivery_id){
        $result = $this->read('delivery_person', "delivery_id = $delivery_id");
        return $result;
    }
    public function getPoolDetails(){
        $result = $this->Query("SELECT reservation.order_id,reservation.place_date,reservation.place_time,customer.customer_id,customer.city,customer.street,customer.contact_no,users.first_name,users.last_name FROM reservation INNER JOIN customer ON reservation.customer_id=customer.customer_id AND reservation.order_state='pending' AND reservation.collecting_method='delivery' INNER JOIN users ON users.user_id=customer.customer_id");
        return $result;
    }
    public function getCurrentDeliveries(){
        $result=$this->Query("SELECT reservation.order_id,reservation.place_date,reservation.place_time,customer.customer_id,customer.city,customer.street,customer.contact_no,users.first_name,users.last_name FROM reservation INNER JOIN customer ON reservation.customer_id=customer.customer_id AND reservation.order_state='ongoing' AND reservation.collecting_method='delivery' AND reservation.delivery_id='{$_SESSION['user_id']}' INNER JOIN users ON users.user_id=customer.customer_id");
        return $result;
    }
    
    
}