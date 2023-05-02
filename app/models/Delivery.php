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
    public function getMyDetails($delivery_id){
        $result=$this->Query("SELECT * FROM delivery_person WHERE delivery_id=$delivery_id");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['city'=>$row['city']]);
            }
            return $info;
        }

    }
    public function getPoolDetails(){
        $delivery_id=$_SESSION['user_id'];
        $result = $this->getMyDetails($delivery_id);
        $city='';
        $dis = getDistance('Boralesgamuwa,No 175,Abeyrathna Mawatha','Athurugiriya,Temple Rd');
        //print_r($dis);
        foreach($result as $row){
            $city=$row['city'];
        }
        //print_r(gettype($city));
        $result = $this->Query("SELECT reservation.order_id,reservation.place_date,reservation.place_time,customer.customer_id,customer.city,customer.street,customer.contact_no,users.first_name,users.last_name,dealer.city AS dcity,dealer.street AS dstreet FROM reservation INNER JOIN customer ON reservation.customer_id=customer.customer_id AND reservation.order_state='Pending' AND reservation.collecting_method='delivery' AND reservation.deliver_city='$city' INNER JOIN users ON users.user_id=customer.customer_id INNER JOIN dealer ON reservation.dealer_id=dealer.dealer_id;");
        return $result;
    }
    public function getCurrentDeliveries(){
        $delivery_id=$_SESSION['user_id'];
        $result = $this->getMyDetails($delivery_id);
        $city='';
        $dis = getDistance('Boralesgamuwa,No 175,Abeyrathna Mawatha','Athurugiriya,Temple Rd');
        //print_r($dis);
        foreach($result as $row){
            $city=$row['city'];
        }
        $result=$this->Query("SELECT reservation.order_id,reservation.place_date,reservation.place_time,customer.customer_id,customer.city,customer.street,customer.contact_no,users.first_name,users.last_name,dealer.city AS dcity,dealer.street AS dstreet FROM reservation INNER JOIN customer ON reservation.customer_id=customer.customer_id AND reservation.order_state='Dispatched' AND reservation.collecting_method='delivery' AND reservation.deliver_city='$city' INNER JOIN users ON users.user_id=customer.customer_id INNER JOIN dealer ON reservation.dealer_id=dealer.dealer_id;");
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
        date_default_timezone_set("Asia/Colombo");
        $date = date('Y-m-d');
        $time = date('H:i:s');
        //echo($date);
        $this->update('reservation',['order_state'=>"Completed",'deliver_date'=>$date,'deliver_time'=>$time],'order_id='.$orderID);
        /*if($this->Query(("UPDATE `reservation` SET order_state='Completed',deliver_date=$date WHERE order_id=$orderID;"))){
            return 1;
        }else{
            return 0;
        }*/
    }public function getRegisteredDate($delivery_id){
        $result=$this->Query("SELECT date_joined AS date FROM users WHERE users.user_id=$delivery_id");
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                return explode("-",$row['date']);
            }
        }
    }public function getDeliveredOrders($delivery_id){
        $result=$this->Query("SELECT deliver_date AS date FROM reservation WHERE reservation.order_state='completed' AND reservation.delivery_id=$delivery_id ORDER BY date ");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,$row['date']);
            }
           return $info;
        }
        //print_r($info);
    }public function getRevenue($delivery_id){
        $result=$this->Query("SELECT reservation.order_id,reservation.max_distance,reservation_include.product_id,reservation_include.quantity,product.weight,delivery_charge.charge_per_kg FROM reservation INNER JOIN reservation_include ON reservation.order_id=reservation_include.order_id AND reservation.delivery_id=$delivery_id AND reservation.order_state='Completed' INNER JOIN product ON reservation_include.product_id=product.product_id INNER JOIN delivery_charge ON reservation.min_distance=delivery_charge.max_distance;");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['order_id'=>$row['order_id'],'max_distance'=>$row['max_distance'],'product_id'=>$row['product_id'],'quantity'=>$row['quantity'],'weight'=>$row['weight'],'charge_per_kg'=>$row['charge_per_kg']]);
            }
            return $info;
        }
    
    
    }public function getDeliveredProducts($delivery_id){
        $result=$this->Query("SELECT reservation.order_id,reservation.deliver_date,reservation_include.product_id,reservation_include.quantity,product.name FROM reservation INNER JOIN reservation_include ON reservation.order_id=reservation_include.order_id AND reservation.delivery_id=$delivery_id AND reservation.order_state='Completed' INNER JOIN product ON reservation_include.product_id=product.product_id;");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['order_id'=>$row['order_id'],'deliver_date'=>$row['deliver_date'],'product_id'=>$row['product_id'],'quantity'=>$row['quantity'],'name'=>$row['name']]);
            }
            return $info;
        }

    }public function getRevenueForAnalysis($delivery_id){
        $result=$this->Query("SELECT reservation.deliver_date,reservation.max_distance,reservation_include.product_id,reservation_include.quantity,product.weight,delivery_charge.charge_per_kg FROM reservation INNER JOIN reservation_include ON reservation.order_id=reservation_include.order_id AND reservation.delivery_id=$delivery_id AND reservation.order_state='Completed' INNER JOIN product ON reservation_include.product_id=product.product_id INNER JOIN delivery_charge ON reservation.min_distance=delivery_charge.max_distance ORDER BY deliver_date");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['deliver_date'=>$row['deliver_date'],'max_distance'=>$row['max_distance'],'product_id'=>$row['product_id'],'quantity'=>$row['quantity'],'weight'=>$row['weight'],'charge'=>$row['charge_per_kg']]);
            }
            return $info;
        }
    }
    
    
}