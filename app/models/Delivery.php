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
        $result = $this->Query("SELECT reservation.order_id,reservation.place_date,reservation.place_time,customer.customer_id,reservation_include.product_id,reservation_include.quantity,product.weight,customer.city,customer.street,customer.contact_no,users.first_name,users.last_name,dealer.city AS dcity,dealer.street AS dstreet FROM reservation INNER JOIN reservation_include ON reservation.order_id=reservation_include.order_id INNER JOIN product ON reservation_include.product_id=product.product_id INNER JOIN customer ON reservation.customer_id=customer.customer_id AND reservation.order_state='Accepted' AND reservation.collecting_method='Delivery' INNER JOIN users ON users.user_id=customer.customer_id INNER JOIN dealer ON reservation.dealer_id=dealer.dealer_id AND dealer.city='$city'");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['order_id'=>$row['order_id'], 'place_date'=>$row['place_date'], 'place_time'=>$row['place_time'],'customer_id'=>$row['customer_id'],'product_id'=>$row['product_id'],'quantity'=>$row['quantity'],'weight'=>$row['weight'],'city'=>$row['city'],'street'=>$row['street'],'contact_no'=>$row['contact_no'],'first_name'=>$row['first_name'],'last_name'=>$row['last_name'],'dcity'=>$row['dcity'],'dstreet'=>$row['dstreet']]);
            }
            return $info;
        }
        //return $result;
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
        $result = $this->Query("SELECT reservation.order_id,reservation.place_date,reservation.place_time,customer.customer_id,reservation_include.product_id,reservation_include.quantity,product.weight,customer.city,customer.street,customer.contact_no,users.first_name,users.last_name,dealer.city AS dcity,dealer.street AS dstreet  FROM reservation INNER JOIN reservation_include ON reservation.order_id=reservation_include.order_id AND reservation.delivery_id=$delivery_id INNER JOIN product ON reservation_include.product_id=product.product_id INNER JOIN customer ON reservation.customer_id=customer.customer_id AND reservation.order_state='Dispatched' AND reservation.collecting_method='Delivery' INNER JOIN users ON users.user_id=customer.customer_id INNER JOIN dealer ON reservation.dealer_id=dealer.dealer_id AND dealer.city='$city'");
        //print_r($result);
        if(mysqli_num_rows($result)>0){
            //print_r('yes');
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                //print_r($row);
                array_push($info,['order_id'=>$row['order_id'], 'place_date'=>$row['place_date'], 'place_time'=>$row['place_time'],'customer_id'=>$row['customer_id'],'product_id'=>$row['product_id'],'quantity'=>$row['quantity'],'weight'=>$row['weight'],'city'=>$row['city'],'street'=>$row['street'],'contact_no'=>$row['contact_no'],'first_name'=>$row['first_name'],'last_name'=>$row['last_name'],'dcity'=>$row['dcity'],'dstreet'=>$row['dstreet']]);
            }
            return $info;
        }
    }
    public function getPendingDeliveryCount(){
        $delivery_id=$_SESSION['user_id'];
        $result = $this->getMyDetails($delivery_id);
        $city='';
        foreach($result as $row){
            $city=$row['city'];
        }
        $result=$this->Query("SELECT COUNT(reservation.order_id) AS count FROM reservation WHERE reservation.order_state='Dispatched' AND reservation.delivery_id='{$_SESSION['user_id']}'");
        $info=mysqli_fetch_assoc($result);
        return $info;
    }
    public function getDeliveredOrdersCount(){
        $date = date('Y-m-d');
        $result=$this->Query("SELECT COUNT(reservation.order_id) AS count FROM reservation WHERE reservation.order_state='Completed' AND reservation.delivery_id='{$_SESSION['user_id']}' AND reservation.deliver_date='$date'");
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
            // order information
            $order = mysqli_fetch_assoc($this->read('reservation',"order_id = $orderID"));
            // customer information
            $customer = mysqli_fetch_assoc($this->read('users',"user_id = ".$order['customer_id']));
            
            // sending email notification
            // get template
            $mailbody = file_get_contents('./emailTemplates/orderdispatched.php');
            // prepare replacements
            $swap_reorder = array(
                "{RECIEVER_NAME}"=> $customer['first_name'].' '.$customer['last_name'],
                "{ORDER_ID}"=> $order_id,
                "{ORDER_LINK}"=> BASEURL.'/orders/customer_myreservation/'.$order_id
            );
            // replace
            foreach(array_keys($swap_reorder) as $key){
                if(strlen($key) > 2 && trim($key) != ""){
                    $mailbody = str_replace($key,$swap_reorder[$key],$mailbody);
                }
            }
            // create mail instance
            $mail = new Mail('admin@gasify.com',$customer['email'],$customer['first_name'].' '.$customer['last_name'],'Gasify : Order Status',$mailbody,$link=null);
            $mail->send();
            return 1;
        }else{
            return 0;
        }
    }
    public function cancelDelivery($orderID){
        if($this->Query(("UPDATE `reservation` SET order_state='Accepted' WHERE order_id=$orderID;"))){
            return 1;
        }else{
            return 0;
        }
    }public function setReservationStateDelivered($orderID,$charge){
        date_default_timezone_set("Asia/Colombo");
        $date = date('Y-m-d');
        $time = date('H:i:s');
        //echo($date);
        $this->update('reservation',['order_state'=>"Completed",'deliver_date'=>$date,'deliver_time'=>$time,'deliver_charge'=>$charge],'order_id='.$orderID);
        // order information
        $order = mysqli_fetch_assoc($this->read('reservation',"order_id = $orderID"));
        // customer information
        $customer = mysqli_fetch_assoc($this->read('users',"user_id = ".$order['customer_id']));
        
        // sending email notification
        // get template
        $mailbody = file_get_contents('./emailTemplates/orderdelivered.php');
        // prepare replacements
        $swap_reorder = array(
            "{RECIEVER_NAME}"=> $customer['first_name'].' '.$customer['last_name'],
            "{ORDER_ID}"=> $order_id,
            "{ORDER_LINK}"=> BASEURL.'/orders/customer_myreservation/'.$order_id
        );
        // replace
        foreach(array_keys($swap_reorder) as $key){
            if(strlen($key) > 2 && trim($key) != ""){
                $mailbody = str_replace($key,$swap_reorder[$key],$mailbody);
            }
        }
        // create mail instance
        $mail = new Mail('admin@gasify.com',$customer['email'],$customer['first_name'].' '.$customer['last_name'],'Gasify : Order Status',$mailbody,$link=null);
        $mail->send();
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
    }
    public function getTodayRevenue($delivery_id){
        $date = date('Y-m-d');
        $result=$this->Query("SELECT reservation.order_id,reservation.place_date,reservation.place_time,reservation.deliver_charge,customer.customer_id,reservation_include.product_id,reservation_include.quantity,product.weight,customer.city,customer.street,customer.contact_no,users.first_name,users.last_name,dealer.city AS dcity,dealer.street AS dstreet FROM reservation INNER JOIN reservation_include ON reservation.order_id=reservation_include.order_id INNER JOIN product ON reservation_include.product_id=product.product_id INNER JOIN customer ON reservation.customer_id=customer.customer_id AND reservation.order_state='Completed' AND reservation.collecting_method='delivery' AND reservation.delivery_id='{$_SESSION['user_id']}' AND reservation.deliver_date='$date' INNER JOIN users ON users.user_id=customer.customer_id INNER JOIN dealer ON reservation.dealer_id=dealer.dealer_id;");
        return $result;
    }
    
    public function getRevenue($delivery_id){
        $result=$this->Query("SELECT reservation.order_id,reservation.place_date,reservation.place_time,customer.customer_id,reservation_include.product_id,reservation_include.quantity,product.weight,customer.city,customer.street,customer.contact_no,users.first_name,users.last_name,dealer.city AS dcity,dealer.street AS dstreet FROM reservation INNER JOIN reservation_include ON reservation.order_id=reservation_include.order_id INNER JOIN product ON reservation_include.product_id=product.product_id INNER JOIN customer ON reservation.customer_id=customer.customer_id AND reservation.order_state='Completed' AND reservation.collecting_method='delivery' AND reservation.delivery_id='{$_SESSION['user_id']}' INNER JOIN users ON users.user_id=customer.customer_id INNER JOIN dealer ON reservation.dealer_id=dealer.dealer_id;");
        return $result;
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
        $result=$this->Query("SELECT reservation.deliver_date,reservation.deliver_charge FROM reservation WHERE reservation.order_state='Completed' AND reservation.delivery_id=$delivery_id ORDER BY deliver_date");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['deliver_date'=>$row['deliver_date'],'deliver_charge'=>$row['deliver_charge']]);
            }
            return $info;
        }
    }public function getDeliveryCharges(){
        $result=$this->Query("SELECT * FROM delivery_charge;");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['min_distance'=>$row['min_distance'],'max_distance'=>$row['max_distance'],'charge_per_kg'=>$row['charge_per_kg']]);
            }
            return $info;
        }
    }
    
    
}