<?php

class Customer extends Model{

    public function __construct()
    {
        parent::__construct();
    }


    // public function customerSignupForm(){
    //     $data['productresult'] = $this->read('product', 'company_id = '.$company_id);
    //     $data['distributorresult'] = $this->read('distributor', "company_id = $company_id", "city");
    //     return $data;
    // }//

    public function getCustomer($customer_id){
        // $result = $this->read('dealer', "dealer_id = $dealer_id");
        $result = $this->Query("SELECT * FROM users u INNER JOIN dealer d ON u.user_id = d.dealer_id WHERE d.dealer_id = $customer_id");
        return $result;
    }//



    /*............Customer Dashboard...................*/

    //get customer profile image
    public function getCustomerImage($customer_id){
        $result = $this->Query("SELECT * FROM users u INNER JOIN customer c ON u.user_id = c.customer_id WHERE u.user_id = '$customer_id' ");

        // $result = $this->read('customer', "customer_id = $customer_id");
        return $result;
    }

    //get company brands in dashboard
    public function getCompanyBrand(){
        $result = $this->Query("SELECT company_id,name,logo FROM company");
        return $result;
    }
    
    //display most recent 3 reservations in dashboard
    public function getRecentorders($customer_id){
        $result1 = $this->Query("SELECT order_id,order_state,place_date
            FROM reservation
            WHERE customer_id = '{$customer_id}'
            ORDER BY place_date DESC LIMIT 3");
        
               
        $orders = array();
        if(mysqli_num_rows($result1)>0){
           while($row1 = mysqli_fetch_assoc($result1)){
                $order_id = $row1['order_id'];
                $products = array();

                // $result2 = $this->Query("SELECT * FROM reservation_include WHERE order_id = '{$order_id}'");
                $result2 = $this->Query("SELECT p.name as product_name, c.name as company_name, r.quantity as quantity, r.unit_price as unit_price 
                FROM reservation_include r 
                INNER JOIN product p ON r.product_id = p.product_id 
                INNER JOIN company c ON p.company_id = c.company_id 
                WHERE r.order_id = '{$order_id}'");

                $total_amount = 0;
                while($row2=mysqli_fetch_assoc($result2)){

                    // $result3 = $this->Query("SELECT p.name as product_name, c.name as company_name FROM product p INNER JOIN company c ON p.company_id = c.company_id WHERE product_id = '{$row2['product_id']}'"); 
                    // if($row3 = mysqli_fetch_assoc($result3)){
                    $quantity = $row2['quantity'];
                    $unit_price = $row2['unit_price'];
                    $amount = $quantity * $unit_price;
                    $total_amount = $total_amount + $amount;
                    array_push($products,$row2);
                    // }

                }

                array_push($orders,['order'=>$row1,'products'=>$products, 'total_amount'=>$total_amount]);

           }
        }

        return $orders;
    }

    //get most popular 4 products in dashboard
    public function getPopularProducts(){

        $popular_products = array();
        $result1 = $this->Query("SELECT SUM(reservation_include.quantity),product.name as p_name,product.weight,product.unit_price,product.image,company.name as c_name 
        FROM reservation_include
        JOIN product ON reservation_include.product_id = product.product_id
        Join company ON product.company_id = company.company_id
        GROUP BY product.product_id
        ORDER BY SUM(reservation_include.quantity) DESC LIMIT 4");

        if(mysqli_num_rows($result1)>0){
            while($row1=mysqli_fetch_assoc($result1)){
                array_push($popular_products,$row1);
            }
        }

        return $popular_products;
       
    }




    /*............Customer My Reservation tab...................*/

    //display all past reservations in my reservation tab
    public function getAllmyreservations($customer_id){

        $result1 = $this->Query("SELECT order_id,order_state,place_date
            FROM reservation
            WHERE customer_id = '{$customer_id}'
            ORDER BY place_date DESC");
        
               
        $allmyreservations = array();
        if(mysqli_num_rows($result1)>0){
           while($row1 = mysqli_fetch_assoc($result1)){
                $order_id = $row1['order_id'];
                $products = array();

                // $result2 = $this->Query("SELECT * FROM reservation_include WHERE order_id = '{$order_id}'");
                $result2 = $this->Query("SELECT p.name as product_name, c.name as company_name, r.quantity as quantity, r.unit_price as unit_price 
                FROM reservation_include r 
                INNER JOIN product p ON r.product_id = p.product_id 
                INNER JOIN company c ON p.company_id = c.company_id 
                WHERE r.order_id = '{$order_id}'");

                $total_amount = 0;
                while($row2=mysqli_fetch_assoc($result2)){

                    // $result3 = $this->Query("SELECT p.name as product_name, c.name as company_name FROM product p INNER JOIN company c ON p.company_id = c.company_id WHERE product_id = '{$row2['product_id']}'"); 
                    // if($row3 = mysqli_fetch_assoc($result3)){
                    $quantity = $row2['quantity'];
                    $unit_price = $row2['unit_price'];
                    $amount = $quantity * $unit_price;
                    $total_amount = $total_amount + $amount;
                    array_push($products,$row2);
                    // }

                }

                array_push( $allmyreservations,['order'=>$row1,'products'=>$products, 'total_amount'=>$total_amount]);

           }
        }

        return  $allmyreservations;

    }

    //display selected reservation details from all reservations
    public function ViewMyreservation($order_id,$customer_id){

            $myreservation = array();

          //take dealer name using dealer and reservation tables
            $result1 = $this->Query("SELECT reservation.order_id,reservation.order_state,reservation.place_date,dealer.name as dealer_name
            FROM reservation
            INNER JOIN dealer ON reservation.dealer_id = dealer.dealer_id
            WHERE reservation.customer_id = '{$customer_id}' and reservation.order_id = '{$order_id}'");
 
            if(mysqli_num_rows($result1) > 0){
                while($row1=mysqli_fetch_assoc($result1)){
                        
                    $result2 = $this->Query("SELECT p.name as product_name, c.name as company_name, r.quantity as quantity, r.unit_price as unit_price,p.image as product_image,p.weight as product_weight 
                            FROM reservation_include r 
                            INNER JOIN product p ON r.product_id = p.product_id 
                            INNER JOIN company c ON p.company_id = c.company_id 
                            WHERE r.order_id = '{$order_id}'");
                    
                    $total_amount = 0;
                    $products = array();
                    while($row2 = mysqli_fetch_assoc($result2)){
        
                        $quantity = $row2['quantity'];
                        $unit_price = $row2['unit_price'];
                        $amount = $quantity * $unit_price;
                        $total_amount = $total_amount + $amount;
                        array_push($products,$row2);
                    
                        
                    }
                    $reviews = array();

                    $result3 = $this->Query("SELECT * FROM review WHERE  order_id = '{$order_id}' ORDER BY date DESC LIMIT 3");
                    while($row3 = mysqli_fetch_assoc($result3)){
                        array_push($reviews,$row3);
                    }

                    array_push($myreservation,['order'=>$row1,'products'=>$products,'total_amount'=>$total_amount,'reviews'=> $reviews]);
                }
           
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

    //add new review for selected reservation
    public function AddReviw($order_id,$customer_id,$reviews,$review_type){

        // $add_review = array();
        $add_review_errors =array();
        $error = "";
        
        $result1 = $this->Query("SELECT collecting_method FROM reservation WHERE order_id = '{$order_id}'");
        if(mysqli_num_rows($result1)>0){
            $row1=mysqli_fetch_assoc($result1);
            $collecting_method = $row1['collecting_method'] ;
        }
       
      
        date_default_timezone_set("Asia/Colombo");
        $time = date('H:i:s');
        $date = date('Y-m-d');
        $result2 = "";

        //check collecting method , Pick up orders only has review_type 'Dealer'
        if($collecting_method == 'Pick up'){
            $review_type = 'Dealer';

            //check fields are empty
            if(!empty($reviews)){
                $result2 = $this->insert('review',['order_id'=> $order_id,'date' => $date,'time'=>$time,'message'=>$reviews,'review_type'=>$review_type]);
            }
            else{
                $error = "Write your review!";
                // array_push($add_review_errors,$error); 
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
                // array_push($add_review_errors,$error); 
            }
        
        }
        return $error;

    }



    /*..................customer place reservation..................*/

    //get company products for select quantity to customer
    public function getCompanyProducts($company_id){

        $company_products = array();
        $result1 = $this->Query("SELECT c.name as c_name,p.name as p_name,p.product_id as p_id,p.type,p.weight,p.image,p.unit_price FROM company c 
        INNER JOIN product p ON c.company_id = p.company_id 
        WHERE c.company_id = '{$company_id}'");

        if(mysqli_num_rows($result1)>0){
            while($row1=mysqli_fetch_assoc($result1)){
                array_push($company_products,$row1);
            }
        }

        return $company_products;
    }


    //get dealer bank details for bank deposit payments
    public function getDealerBankDetails($dealer_id){
    
    }


    /*.........................Customer dealers tab ....................*/

    //get  dealers details and display in view dealers tab according to selected brand and city
    public function getdealers($brand_name = null,$city_name = null) {
        if($brand_name!= null && $city_name!= null){
            $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,CONCAT(d.street,' , ',d.city) as address ,d.contact_no,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE c.name = '$brand_name' AND d.city = '$city_name'");
        }else if($brand_name!= null && $city_name== null){

            $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,CONCAT(d.street,' , ',d.city) as address ,d.contact_no,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE c.name = '$brand_name'");
        }else if($city_name!= null && $brand_name== null){

            $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,CONCAT(d.street,' , ',d.city) as address ,d.contact_no,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id WHERE  d.city = '$city_name'");
        
        }else{
            $result1 = $this->Query("SELECT d.dealer_id,d.name as d_name,d.city,CONCAT(d.street,' , ',d.city) as address ,d.contact_no,c.name as c_name FROM dealer d INNER JOIN company c ON  d.company_id = c.company_id ");
        }
       
        return $result1;
    }


    
}





?>