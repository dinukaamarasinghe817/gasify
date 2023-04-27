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
        $result = $this->Query("SELECT * FROM users u INNER JOIN delivery_person d ON u.user_id = d.delivery_id WHERE u.user_id = '$delivery_id' ");
        // $result = $this->read('delivery_person', "delivery_id = $delivery_id");
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
        $result=$this->Query("SELECT reservation.order_id,reservation.place_date,reservation.place_time,customer.customer_id,customer.city,customer.street,customer.contact_no,users.first_name,users.last_name FROM reservation INNER JOIN customer ON reservation.customer_id=customer.customer_id AND reservation.order_state='Dispatched' AND reservation.collecting_method='delivery' AND reservation.delivery_id='{$_SESSION['user_id']}' INNER JOIN users ON users.user_id=customer.customer_id");
        return $result;
    }
    public function getPendingDeliveryCount(){
        $result=$this->Query("SELECT COUNT(reservation.order_id) AS count FROM reservation WHERE reservation.order_state='Dispatched' AND reservation.delivery_id='{$_SESSION['user_id']}'");
        $info=mysqli_fetch_assoc($result);
        return $info;
    }
    public function getDeliveredOrdersCount(){
        $result=$this->Query("SELECT COUNT(reservation.order_id) AS count FROM reservation WHERE reservation.order_state='Completed' AND reservation.delivery_id='{$_SESSION['user_id']}'");
        $info=mysqli_fetch_assoc($result);
        return $info;
    }
    public function getReviewDetails(){
        $result=$this->Query("SELECT review.order_id,review.date,review.time,review.message,reservation.delivery_id FROM review INNER JOIN reservation ON review.order_id=reservation.order_id AND review.review_type='Delivery' AND reservation.order_state='Completed' AND reservation.delivery_id='{$_SESSION['user_id']}'");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['order_id'=>$row['order_id'],'date'=>$row['date'],'time'=>$row['time'],'message'=>$row['message']]);
            }
            return $info;
        }
    
    }
    public function getReviewCount(){
        $result=$this->Query("SELECT COUNT(review.order_id) AS count FROM review INNER JOIN reservation ON review.order_id=reservation.order_id AND review.review_type='Delivery' AND reservation.order_state='Completed' AND reservation.delivery_id='{$_SESSION['user_id']}'");
        $info=mysqli_fetch_assoc($result);
        return $info;
    }
    public function acceptDelivery($orderID,$delivery_id){
        if($this->Query(("UPDATE `reservation` SET order_state='Dispatched',delivery_id=$delivery_id WHERE order_id=$orderID;"))){
            return 1;
        }else{
            return 0;
        }
    }
    public function cancelDelivery($orderID){
        if($this->Query(("UPDATE `reservation` SET order_state='Pending' WHERE order_id=$orderID;"))){
            return 1;
        }else{
            return 0;
        }
    }public function setReservationStateDelivered($orderID){
        if($this->Query(("UPDATE `reservation` SET order_state='Completed' WHERE order_id=$orderID;"))){
            return 1;
        }else{
            return 0;
        }
    }public function getRegisteredDate($delivery_id){
        $result=$this->Query("SELECT date_joined AS date FROM users WHERE users.user_id=$delivery_id");
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                return explode("-",$row['date']);
            }
        }
    }public function getDeliveredOrders($delivery_id){
        $result=$this->Query("SELECT place_date AS date FROM reservation WHERE reservation.order_state='completed' AND reservation.delivery_id=$delivery_id ORDER BY date ");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,$row['date']);
            }
           return $info;
        }
        //print_r($info);
    }
    
    
}