<?php

class Customer extends Model{

    public function __construct()
    {
        parent::__construct();
    }

    //get customer details
    public function getCustomer($customer_id){
        $result = $this->Query("SELECT c.city ,c.street,c.image,c.contact_no,c.ebill_no,c.ebill_verification_state,c.type as c_type  
        FROM customer c INNER JOIN users u ON u.user_id = c.customer_id WHERE c.customer_id = $customer_id");
        return $result;
    }



    /*......................................................Customer Dashboard...............................................................*/

    //display customer profile image
    public function getCustomerImage($customer_id){
        $result = $this->Query("SELECT * FROM users u INNER JOIN customer c ON u.user_id = c.customer_id WHERE u.user_id = '$customer_id' ");
        return $result;
    }

    //display company brands in dashboard
    public function getCompanyBrand(){
        $result = $this->Query("SELECT company_id,name,logo FROM company");
        return $result;
    }

    //display relavant company products
    public function getCompanyProducts($company_id){
        $result1 = $this->Query("SELECT c.name as c_name,p.name as p_name,p.product_id as p_id,p.type,p.weight,p.image,p.unit_price 
        FROM company c 
        INNER JOIN product p ON c.company_id = p.company_id 
        WHERE c.company_id = '{$company_id}'");

        return $result1;
    }
    
    //display most recent 3 reservations in dashboard
    public function getRecentorders($customer_id){
        $result1 = $this->Query("SELECT order_id,order_state,place_date
            FROM reservation
            WHERE customer_id = '{$customer_id}'
            ORDER BY place_date DESC , place_time DESC LIMIT 3");
        
               
        $orders = array();
        if(mysqli_num_rows($result1)>0){
           while($row1 = mysqli_fetch_assoc($result1)){
                $order_id = $row1['order_id'];
                $products = array();

                //query for get reservation products details for recent orders 
                $result2 = $this->Query("SELECT p.name as product_name, c.name as company_name, r.quantity as quantity, r.unit_price as unit_price 
                FROM reservation_include r 
                INNER JOIN product p ON r.product_id = p.product_id 
                INNER JOIN company c ON p.company_id = c.company_id 
                WHERE r.order_id = '{$order_id}'");

                $total_amount = 0;
                while($row2=mysqli_fetch_assoc($result2)){
                    $quantity = $row2['quantity'];
                    $unit_price = $row2['unit_price'];
                    $amount = $quantity * $unit_price;      
                    $total_amount = $total_amount + $amount;    //calculate total amount
                    array_push($products,$row2);
                }

                array_push($orders,['order'=>$row1,'products'=>$products, 'total_amount'=>$total_amount]);

           }
        }

        return $orders;
    }

    //display most popular 4 products sold through system in dashboard 
    public function getPopularProducts(){

        $popular_products = array();
        $result1 = $this->Query("SELECT reservation.order_state,reservation.order_id,SUM(reservation_include.quantity) as p_count ,product.name as p_name,product.weight,product.unit_price,product.image,company.name as c_name 
        FROM reservation_include
        JOIN reservation ON reservation.order_id = reservation_include.order_id
        JOIN product ON reservation_include.product_id = product.product_id
        Join company ON product.company_id = company.company_id
        WHERE order_state != 'Canceled'
        GROUP BY product.product_id
        ORDER BY SUM(reservation_include.quantity) DESC LIMIT 4");

        if(mysqli_num_rows($result1)>0){
            while($row1=mysqli_fetch_assoc($result1)){
                array_push($popular_products,$row1);
            }
        }

        return $popular_products;
       
    }




    /*......................................................Customer My Reservation tab......................................................*/

    //display all past reservations in my reservation tab
    public function getAllmyreservations($customer_id){
        $allmyreservations = array();

        //query for get all past reservations
        $result1 = $this->Query("SELECT order_id,order_state,place_date
            FROM reservation
            WHERE customer_id = '{$customer_id}'
            ORDER BY (CASE order_state
             WHEN 'Pending' THEN 1
             WHEN 'Accepted' THEN 2
             WHEN'Dispatched' THEN 3
             WHEN 'Delivered' THEN 4
             WHEN 'Completed' THEN 5
             WHEN 'Refunded' THEN 6
             ELSE 100 END) ASC, place_date DESC ,place_time DESC");
     
        if(mysqli_num_rows($result1)>0){
           while($row1 = mysqli_fetch_assoc($result1)){
                $order_id = $row1['order_id'];

                $products = array();  //array to hold product details

                //query for get all past orders products details
                $result2 = $this->Query("SELECT p.name as product_name, c.name as company_name, r.quantity as quantity, r.unit_price as unit_price 
                FROM reservation_include r 
                INNER JOIN product p ON r.product_id = p.product_id 
                INNER JOIN company c ON p.company_id = c.company_id 
                WHERE r.order_id = '{$order_id}'");

                $total_amount = 0;
                while($row2=mysqli_fetch_assoc($result2)){
                    $quantity = $row2['quantity'];
                    $unit_price = $row2['unit_price'];
                    $amount = $quantity * $unit_price;
                    $total_amount = $total_amount + $amount;    //calculate total amount
                    array_push($products,$row2);
                }

                array_push( $allmyreservations,['order'=>$row1,'products'=>$products, 'total_amount'=>$total_amount]);

           }
        }

        return  $allmyreservations;

    }

    //display selected reservation details from all reservations
    public function ViewMyreservation($order_id,$customer_id){

            $myreservation = array();
            $reviews = array();

            //query for get details about selected reservation
            $result1 = $this->Query("SELECT r.order_id,r.order_state,r.place_date,r.place_time,r.collecting_method, r.dealer_id,r.delivery_id,
            r.cancel_date,r.cancel_time,r.payment_method,r.deliver_city,r.deliver_street,r.deliver_charge,r.deliver_date,r.deliver_time,r.bank,r.acc_no,r.refund_date,r.refund_time,r.refund_verification,d.name as dealer_name,d.city as dealer_city,d.street as dealer_street
            FROM reservation r
            INNER JOIN dealer d ON r.dealer_id = d.dealer_id
            WHERE r.customer_id = '{$customer_id}' and r.order_id = '{$order_id}'");

            if(mysqli_num_rows($result1) > 0){
                $row1=mysqli_fetch_assoc($result1);
                //get products details for selected order
                $result2 = $this->Query("SELECT p.name as product_name, c.name as company_name, r.quantity as quantity, r.unit_price as unit_price,p.image as product_image,p.weight as product_weight 
                FROM reservation_include r 
                INNER JOIN product p ON r.product_id = p.product_id 
                INNER JOIN company c ON p.company_id = c.company_id 
                WHERE r.order_id = '{$order_id}'");

                $total_amount = 0;
                $sum_of_weights = 0;
                $products = array();
                while($row2 = mysqli_fetch_assoc($result2)){
                    $quantity = $row2['quantity'];
                    $unit_price = $row2['unit_price'];
                    $item_weight = $row2['product_weight'];
                    $amount = $quantity * $unit_price;
                    $total_amount = $total_amount + $amount;
                    $product_total_weight = $quantity * $item_weight;
                    $sum_of_weights = $sum_of_weights + $product_total_weight;
                    array_push($products,$row2);
                
                    
                }


                //get reviews for selected order
                $result3 = $this->Query("SELECT * FROM review WHERE  order_id = '{$order_id}' ORDER BY date DESC LIMIT 3");
                while($row3 = mysqli_fetch_assoc($result3)){
                    array_push($reviews,$row3);
                }

                //get delivery person details for selected order
                $result4 =$this->Query("SELECT concat(users.first_name,' ' ,users.last_name ) as delivery_name
                FROM reservation
                INNER JOIN dealer ON reservation.dealer_id = dealer.dealer_id
                INNER JOIN users ON reservation.delivery_id = users.user_id
                WHERE reservation.customer_id = '{$customer_id}' and reservation.order_id = '{$order_id}'");

                $delivery = array();
                while($row4 = mysqli_fetch_assoc($result4)){
                    array_push($delivery,$row4);
                }
                
                
                array_push($myreservation,['order'=>$row1,'products'=>$products,'total_amount'=>$total_amount,'reviews'=> $reviews,'delivery'=>$delivery]);
                
        
            }

        return $myreservation;
    }

    //get collecting method of selected reservation to display review type in review form
    public function getcollecting_method($order_id,$customer_id){
        $collecting_methods = "";
        $result1 = $this->Query("SELECT collecting_method FROM reservation WHERE order_id = '{$order_id}'");
       
        if(mysqli_num_rows($result1)>0){
            $row1=mysqli_fetch_assoc($result1);
            $collecting_methods = $row1['collecting_method'] ;
        }
        return $collecting_methods;
    }

    //insert added new review for selected reservation
    public function AddReview($order_id,$customer_id,$reviews,$review_type){
        $add_review_errors =array();
        $error = "";
        
        //get collecting method to check review type
        $result1 = $this->Query("SELECT collecting_method FROM reservation WHERE order_id = '{$order_id}'");
        if(mysqli_num_rows($result1)>0){
            $row1=mysqli_fetch_assoc($result1);
            $collecting_method = $row1['collecting_method'] ;
        }
       
        //set current date and time
        date_default_timezone_set("Asia/Colombo");
        $time = date('H:i:s');
        $date = date('Y-m-d');
        $result2 = "";

        //check collecting method , Pick up orders only has review_type 'Dealer' and Delivery orders have both review types
        if($collecting_method == 'Pickup'){
            $review_type = 'Dealer';

            //check fields are empty
            if(!empty($reviews)){
                $result2 = $this->insert('review',['order_id'=> $order_id,'date' => $date,'time'=>$time,'message'=>$reviews,'review_type'=>$review_type]);
            }
            else{
                $error = "Write your review!";
            }
        }

        //collecting method delivery then have both review_type Delivery and Dealer 
        else{

            //check fields are empty
            if(!empty($reviews) && !empty($review_type)){
                $result2 = $this->insert('review',['order_id'=> $order_id,'date' => $date,'time'=>$time,'message'=>$reviews,'review_type'=>$review_type]);  
            }
            else{
                $error = "All input fields are required!";
            }
        
        }
        return $error;

    }

    //cancel reservation option(insert refund details and update reservation status)
    public function add_refund_details($order_id, $bank,$branch,$Acc_no){
       
        $error = "";
        //set current transaction
        date_default_timezone_set("Asia/Colombo");
        $cancel_time = date('H:i:s');
        $cancel_date = date('Y-m-d');
       
        //check bank,branch and acc no fields are empty or not
        if($bank != -1 && !empty($branch) && !empty($Acc_no)){
            //update reservation table with status and refund details relevant order
            $this->update('reservation',['bank'=>$bank,'branch'=>$branch,'acc_no'=>$Acc_no,'order_state'=>"Canceled",'cancel_date'=>$cancel_date,'cancel_time'=>$cancel_time,'refund_verification'=>'Pending'],
            'order_id='.$order_id);

            //check and update the quota if it is active and canceled reservation is placed during this month
            $result1 = $this->Query("SELECT place_date FROM reservation WHERE order_id = '{$order_id}'");
            $row1  = mysqli_fetch_assoc($result1);
            $place_date = $row1['place_date'];
            $current_month = date('m');    //current month and year
            $current_year = date('Y'); 

            $customer_id = $_SESSION['user_id'];
            $row3 = mysqli_fetch_assoc($this->read('customer',"customer_id = $customer_id"));
            $customer_type = $row3['type'];

            //if the reservation is placed during the current month
            if (date('m-Y', strtotime($place_date)) === $current_month . '-' . $current_year) {
                $result2 = $this->Query("SELECT r.quantity,r.product_id,p.company_id,p.weight FROM reservation_include r INNER JOIN product p ON p.product_id = r.product_id WHERE r.order_id = '{$order_id}' AND p.type = 'cylinder'");
     
                $total_weight = 0;
                while( $row2 = mysqli_fetch_assoc($result2)){
                    $company_id = $row2['company_id'];
                    $qty = $row2['quantity'];
                    $item_weight = $row2['weight'];
                    $total_weight = $total_weight + $item_weight*$qty;

                    $result4 = $this->Query("SELECT state FROM quota WHERE company_id = '{$company_id}' AND customer_type='{$customer_type}'");
                    $row4 = mysqli_fetch_assoc($result4);
                    $quota_state = $row4['state'];

                        //if quota is active then increase remaining amount according to reservation cylinder weight
                        if($quota_state == "ON"){
                        $result5 = $this->Query("SELECT remaining_amount FROM customer_quota WHERE customer_id = '{$customer_id}' AND company_id = '{$company_id}'");
                        $row5 = mysqli_fetch_assoc($result5);
                        $remaining_amount = $row5['remaining_amount'];
                        $new_remaining_amount =  $remaining_amount + $total_weight;

                        $this -> update('customer_quota',['remaining_amount'=>$new_remaining_amount],'customer_id=' .$customer_id , 'company_id=' .$company_id); 
                    }
                }
                        
            }
        }
    

        // sending a mail notification
        // order information
        $order = mysqli_fetch_assoc($this->read('reservation',"order_id = $order_id"));
        // customer information
        $customer = mysqli_fetch_assoc($this->read('users',"user_id = ".$order['customer_id']));
        // get template
        $mailbody = file_get_contents('./emailTemplates/ordercanceled.php');
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
        $mail = new Mail('admin@gasify.com',$customer['email'],$customer['first_name'].' '.$customer['last_name'],'Gasify: Your order has been canceled!',$mailbody,$link=null);
        $mail->send();
       
    }




    
    /*...........................................................Customer dealers tab .......................................................*/

    //display  dealers details according to selected brand and city
    function getdealersDetails($company_id=null,$city_name = null) {
        if($company_id == 'null'){
            $company_id = null;
        }
       
        //not all cities or all brands options select(default use customer city)
        if($city_name != -1 &&  $company_id != -1){
            //both brand and city selected by customer
            if($company_id != null && $city_name != null){
                $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,CONCAT(d.street,' , ',d.city) as address ,d.contact_no,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE c.company_id = '$company_id' AND d.city = '$city_name'");
            }
            //only brand selected by customer
            else if($company_id!= null && $city_name == null){
                $customer_id = $_SESSION['user_id'];
                $row = mysqli_fetch_assoc($this->read('customer',"customer_id = $customer_id"));
                $mycity = $row['city'];
                $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,CONCAT(d.street,' , ',d.city) as address ,d.contact_no,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE c.company_id = '$company_id' AND d.city = '$mycity'");
            }
            // only city selected by customer
            else if($company_id == null && $city_name != null){
                $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,CONCAT(d.street,' , ',d.city) as address ,d.contact_no ,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE  d.city = '$city_name'");
            }
            //both city and brand not selected by customer
            else if($company_id == null &&  $city_name == null){
                $customer_id = $_SESSION['user_id'];
                $row = mysqli_fetch_assoc($this->read('customer',"customer_id = $customer_id"));
                $mycity = $row['city'];
                $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,CONCAT(d.street,' , ',d.city) as address ,d.contact_no,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE d.city = '$mycity'");
            }
        }
        //both all cities and all brands option selected(display all dealers)
        else if($company_id == -1 && $city_name == -1){
            $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,CONCAT(d.street,' , ',d.city) as address ,d.contact_no ,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id");
        }
        //either all cities or all brands option selected
        else{
            //display all brands dealers in all cities
            if($company_id == null && $city_name == -1){
                $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,CONCAT(d.street,' , ',d.city) as address ,d.contact_no,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id");
            }
            //display selected brand  dealers in all cities 
            else if($company_id != null && $city_name == -1){
                $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,CONCAT(d.street,' , ',d.city) as address ,d.contact_no,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE c.company_id = '$company_id'");
            }
            //display all brand dealers in selected city
            elseif($company_id == -1 && $city_name != null ){
                $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,CONCAT(d.street,' , ',d.city) as address ,d.contact_no ,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE  d.city = '$city_name'");
            }
        }

        return $result1;
        
    }




    /*.......................................................customer help tab.............................................................. */
    
    //get admin id as a other user in chat box
    public function getAdminId(){
        $result = $this->Query("SELECT * FROM users u INNER JOIN admin a ON u.user_id = a.admin_id where type='admin'");
        return $result;

    }

    //display send and recieved messages in chat box according to relavant customer
    public function getMessages($customer_id,$admin_id){
        $result = $this->Query("SELECT * FROM customer_support WHERE sender = '$customer_id' OR reciever = '$customer_id' 
        ORDER BY time AND date ASC");
        return $result;
    }

    //insert customer sending messages to admin
    public function sendMessage($customer_id, $admin_id, $message){
        //set current date and time
        date_default_timezone_set("Asia/Colombo");
        $time = date('H:i:s');
        $date = date('Y-m-d');
    
        $result = $this->insert('customer_support',['customer_id'=> $customer_id,'admin_id'=>$admin_id,'date' => $date,
        'time'=>$time,'sender'=>$customer_id,'reciever'=>$admin_id
        ,'description'=>$message]);

        return $result;

    }




    /*............................................................Quota tab..................................................................*/
    
    //display customer quota according to relavant company 
    function getcustomerquota($customer_id){
        //get all companies
        $companies = array();
        $query = $this->read('company');
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                $company_id = $row['company_id'];
                $row3 = mysqli_fetch_assoc($this->read('customer',"customer_id = $customer_id"));
                $user_type = $row3['type'];

                // see whether the quota for your customer type available
                $query4 = $this->read('quota',"company_id = $company_id AND customer_type = '$user_type' AND state = 'ON'");
                if(mysqli_num_rows($query4) > 0){
                    $row4 = mysqli_fetch_assoc($query4);
                    $total_quota = $row4['monthly_limit'];

                    $query5 = $this->read('customer_quota',"customer_id = $customer_id AND company_id = $company_id");
                    $row5 = mysqli_fetch_assoc($query5);
                    $remaining_quota = $row5['remaining_amount'];

                    $allproducts = array();
                
                    //check whether there is any selected product on that company
                    if(isset($_POST[$company_id])){
                        $selected_pid = $_POST[$company_id];
                    }else{
                        $selected_pid = null;
                        $query2 = $this->read('product',"company_id = $company_id  AND type = 'cylinder'",null,1);
    
                        // if that comapny have products
                        if(mysqli_num_rows($query2) > 0){
                            $row2 = mysqli_fetch_assoc($query2);
                            $selected_pid = $row2['product_id'];
                        }else{
                            // means no product selected and no product to select at random
                            //think
                        }
                    }
    
                    if($selected_pid != null){
                        $row6 = mysqli_fetch_assoc($this->read('product',"product_id = $selected_pid"));
                        $selected_product_weight = $row6['weight'];
    
                        $total_cyl = floor($total_quota/$selected_product_weight);
                        $remaining_cyl = floor($remaining_quota/$selected_product_weight);
                    }else{
                        // think 
                    }
    
                    // get all the products belongs to that company to put it in select
                    $query7 = $this->read('product',"company_id = $company_id AND type = 'cylinder'");
    
                    if(mysqli_num_rows($query7) > 0){
                        while($row7 = mysqli_fetch_assoc($query7)){
                            array_push($allproducts,['product_id'=> $row7['product_id'],'product_name'=>$row7['name'],'product_weight'=>$row7['weight']]);
                        }
                    }
    
                    // now push all attributes needed in companies array
                    $element = ['company_id'=>$company_id, 'name'=>$row['name'], 'logo'=>$row['logo'],'selected_pid'=>$selected_pid, 'total_cyl'=>$total_cyl, 'remaining_cyl'=>$remaining_cyl,'all_products'=>$allproducts,'quota_state'=>'ON'];
                    array_push($companies,$element);
                    
                
                 }
             
            }

               
        }

        return $companies;
    }





    /*............................................................customer place reservation.................................................*/
    
    /*==========================================select brand,city,dealer,page================================================================*/
    //display  dealers according to selected brand and city
    function getdealers($company_id=null,$city_name = null) {
        if($company_id == 'null'){
            $company_id = null;
        }

        //check if both company and city is selected
        if($company_id != null && $city_name != null){
            $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE c.company_id = '$company_id' AND d.city = '$city_name'");
        }
        //check if only company is selected 
        else if($company_id!= null && $city_name== null){
            if(isset($_SESSION['city'])){
                $city_name = $_SESSION['city'];
                $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE c.company_id = '$company_id' AND d.city = '$city_name'");
            }
            else{
                $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE c.company_id = '$company_id'");
            }
        }
        //check if only city is selected
        else if($company_id == null && $city_name != null){
            if(isset($_SESSION['company_id'])){
                $company_id = $_SESSION['company_id'];
                $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE c.company_id = '$company_id' AND d.city = '$city_name'");
            }
            $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE  d.city = '$city_name'");
        }
        //both company and city is null
        else{
            
            if(isset($_SESSION['company_id'])){
                $company_id = $_SESSION['company_id'];

                $customer_id = $_SESSION['user_id'];
                $row = mysqli_fetch_assoc($this->read('customer',"customer_id = $customer_id"));
                $mycity = $row['city'];

                $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE c.company_id = '$company_id' AND d.city = '$mycity'");
                if(isset($_SESSION['city'])){
                    $city_name = $_SESSION['city'];
                    $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE c.company_id = '$company_id' AND d.city = '$city_name'");
                }
            }
            // else if(isset($_SESSION['city']) && isset($_SESSION['company_id'])){
            //     $company_id = $_SESSION['company_id'];
            //     $city_name = $_SESSION['city'];
            //     $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE c.company_id = '$company_id' AND d.city = '$city_name'");
            // }
            else{
                $customer_id = $_SESSION['user_id'];
                $row = mysqli_fetch_assoc($this->read('customer',"customer_id = $customer_id"));
                $mycity = $row['city'];
                $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE d.city = '$mycity'");
            }
        }
       
      return $result1;
        
    }



    /*==============================================select products and quantity page========================================================*/
    //display company products for select quantity to customer products page
    public function getDealerProducts($dealer_id){

        $dealer_products = array();
        
        //query for get customer selected dealer products
        $result1 = $this->Query("SELECT c.name as c_name,p.name as p_name,p.product_id as p_id,p.type,p.weight,p.image,p.unit_price,dk.quantity as dealer_stock FROM company c 
        INNER JOIN product p ON c.company_id = p.company_id 
        INNER JOIN dealer_keep dk  ON p.product_id = dk.product_id 
        WHERE dk.dealer_id = '{$dealer_id}'");
    
        if(mysqli_num_rows($result1)>0){
            while($row1=mysqli_fetch_assoc($result1)){
                array_push($dealer_products,$row1);
            }
        }

        return $dealer_products;
    }

    //get quota details to check if customer has enough quota to buy selected products 
    public function getQuotaDetails($customer_type){
        $company_id = $_SESSION['company_id'];
        $customer_id = $_SESSION['user_id'];

        $quota_details = array();
        
        //query to get quota details
        $result1 = $this->Query("SELECT * FROM quota WHERE company_id = '{$company_id}' AND customer_type = '{$customer_type}'");
        $row1 = mysqli_fetch_assoc($result1);
        $quota_state = $row1['state'];
        $monthly_limit = $row1['monthly_limit'];

        //query to get remaining quota for relevant customer
        $result2 = $this->Query("SELECT * FROM customer_quota WHERE company_id = '{$company_id}' AND customer_id = '{$customer_id}'");
        $row2 = mysqli_fetch_assoc($result2);
        $remaining_weight = $row2['remaining_amount'];

        array_push($quota_details,['state'=>$quota_state,'monthly_limit'=>$monthly_limit,'remaining_weight'=>$remaining_weight]);

        return $quota_details;

    }
 
    //selected products total weight(only cylinders) for check quota is exceed or not
    public function products_total_weight(){
        $order_products = $_SESSION['order_products'];      //customer selected products array in session
        $sum_of_weights = 0;

        foreach ($order_products as $order_product){
            $product_id = $order_product['product_id'];
            $qty = $order_product['qty'];

            //get details of each selected product
            $result3 = $this->Query("SELECT * FROM product WHERE product_id = $product_id AND type = 'cylinder'");
            $row3 = mysqli_fetch_assoc($result3);
            if($row3 != null){
                $item_weight = $row3['weight'];
                $product_total_weight = $item_weight * $qty;    //one product total weight
                $sum_of_weights = $sum_of_weights + $product_total_weight;  //total products weight
            }


        }

        return $sum_of_weights;
    }



    /*================================================select payment method page============================================================ */
    //display selected products details in select payment method page
    public function getSelectedProducts(){
        $order_products_details = array();
        $order_products = $_SESSION['order_products'];  //get selected products array in session
        
        foreach($order_products  as $order_product){
            $product_id  = $order_product['product_id'];
            //get product details from product table
            $row = mysqli_fetch_assoc($this->Query("SELECT * FROM product WHERE product_id = '{$product_id}'"));
            array_push($order_products_details, ['quantity'=>$order_product['qty'], 'product_details' => $row]);
        }

        return $order_products_details;
        
    }



    /*=================================================bank slip upload page================================================================ */
    //display dealer bank details for bank deposit payments slip upload page
    public function getDealerBankDetails(){
        $dealer_id = $_SESSION['dealer_id'];    //get dealer id in session
        $result = $this->Query("SELECT d.bank,d.branch,d.account_no,CONCAT(u.first_name ,'  ' ,u.last_name) as full_name FROM dealer d INNER JOIN users u ON d.dealer_id = u.user_id WHERE dealer_id = '{$dealer_id}'");
        return $result;

    }



    /*======insert reservation details and selected product details to database in Dealer controller and return order_id==================== */
  


    //check the quota status and update remaining weight after place reservation if it is active
    public function update_remaining_weight($customer_type){
        $customer_id = $_SESSION['user_id'];
        $company_id = $_SESSION['company_id'];
        $order_products = $_SESSION['order_products'];
        
        //query to get quota details
        $result2 = $this->Query("SELECT * FROM quota WHERE company_id = '{$company_id}' AND customer_type = '{$customer_type}'");
        $row2 = mysqli_fetch_assoc($result2);
        $quota_state = $row2['state'];
        

        //query to get remaining quota for relevant customer
        $result3 = $this->Query("SELECT * FROM customer_quota WHERE company_id = '{$company_id}' AND customer_id = '{$customer_id}'");
        $row3 = mysqli_fetch_assoc($result3);
        $remaining_weight = $row3['remaining_amount'];


        //check quota is active ,then reduce the remaining quota amount 
        if($quota_state == 'ON'){
             $sum_of_weights = 0;
            foreach ($order_products as $order_product){
                $product_id = $order_product['product_id'];
                $qty = $order_product['qty'];
                //get products weight
                $result1 = $this->Query("SELECT * FROM product WHERE product_id = $product_id");
                $row1 = mysqli_fetch_assoc($result1);
                $product_type = $row1['type'];
                //check product type is cylinder or not
                if($product_type == 'cylinder'){
                    $item_weight = $row1['weight'];
                    $product_total_weight = $item_weight * $qty;
                    $sum_of_weights = $sum_of_weights + $product_total_weight;  //calculate all cylinder type selected products total weight
                }
            }

            $new_remaining_weight = $remaining_weight - $sum_of_weights;  //new remainig quota amount
            //update remaining quota
            $this->update('customer_quota',['remaining_amount'=>$new_remaining_weight],'customer_id= '.$customer_id.' AND company_id='.$company_id.'');

        }   

    }



   


    /*=======================================select delivery method========================================================================= */
    //insert delivery distance ranges to reservation table and return delivery charge  
    function get_delivery_charge($order_id,$delivery_street,$delivery_city){
       
        //get dealer address as origin of delivery
        $dealer_id = $_SESSION['dealer_id'];
        $result1 = $this->Query("SELECT * FROM dealer WHERE dealer_id = $dealer_id");
        $row1 = mysqli_fetch_assoc($result1);
        $dealer_city = $row1['city'];
        $dealer_street = $row1['street'];
        $dealer_address = $dealer_street.', '.$dealer_city;

        $delivery_address = $delivery_street.', '.$delivery_city;
        $distance = getDistance($dealer_address,$delivery_address);  //take distance between customer and dealer address using google maps
       

        $order_products = $_SESSION['order_products'];

        $sum_of_weights = 0;
        foreach ($order_products as $order_product){
            $product_id = $order_product['product_id'];
            $qty = $order_product['qty'];

            //get all products weight
            $result3 = $this->Query("SELECT * FROM product WHERE product_id = $product_id");
            $row3 = mysqli_fetch_assoc($result3);
            $item_weight = $row3['weight'];

            $product_total_weight = $item_weight * $qty;
            $sum_of_weights = $sum_of_weights + $product_total_weight;  //calculate sum of selected products weights

        }
        
        //get delivery charges details from delivery_charge table
        $result2 = $this->Query("SELECT * FROM delivery_charge");
        while($row2 = mysqli_fetch_assoc($result2)){
            $min_distance = $row2['min_distance']; 
            $max_distance = $row2['max_distance'];
            $charge_per_kilo = $row2['charge_per_kg'];

            //check customer distance range
            if($distance>=$min_distance && $distance<=$max_distance){  
                $delivery_charge = $charge_per_kilo * $sum_of_weights;  //calculate delivery charge
            }
        }
        
        return $delivery_charge;
    }

     /*===================================================select collecting method=========================================================== */
    //insert collecting method in to reservation table
    public function insertcollectingmethod($order_id,$delivery_city=null,$delivery_street=null,$delivery_charge=null){
        
        $collecting_method = $_SESSION['collecting_method'];
        $delivery_charge = doubleval($delivery_charge);
        //update reservation table with collecting method
        if($collecting_method == "Delivery"){
            $this ->update('reservation',['collecting_method'=>$collecting_method,'deliver_city'=>$delivery_city,'deliver_street'=>$delivery_street,'deliver_charge'=>$delivery_charge],'order_id='.$order_id);
        }
        else{
            $this ->update('reservation',['collecting_method'=>$collecting_method],'order_id='.$order_id);
        }
        
    }

    function getdealerpubkey($dealer_id){
        $row = mysqli_fetch_assoc($this->read('dealer',"dealer_id = $dealer_id"));
        return ['pub_key'=>$row['pub_key'], 'rest_key'=>$row['rest_key']];
    }



}





?>