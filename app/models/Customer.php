<?php

class Customer extends Model{

    public function __construct()
    {
        parent::__construct();
    }

    //get customer profile image
    public function getCustomerImage($customer_id){
        $result = $this->read('customer', "customer_id = $customer_id");
        return $result;
    }

    //get company brands in dashboard
    public function getCompanyBrand(){
        $result = $this->Query("SELECT name,logo FROM company");
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

    //display one reservation details which is selected from all reservations
    public function ViewMyreservation($order_id,$customer_id){

            $myreservation = array();

          //take dealer name using dealer and reservation tables
            $result1 = $this->Query("SELECT reservation.order_id,reservation.order_state,reservation.place_date,dealer.name as dealer_name
            FROM reservation
            INNER JOIN dealer ON reservation.dealer_id = dealer.dealer_id
            WHERE reservation.customer_id = '{$customer_id}' and reservation.order_id = '{$order_id}'");

            // $result1 = mysqli_query($conn,$sql1);

            // $output = '<div class="subtitle">
            // <h3>Order Details</h3>
            // </div><div class="card">';
            if(mysqli_num_rows($result1) > 0){
                while($row1=mysqli_fetch_assoc($result1)){
                        
                    //     $output.='<div class="order_card">
                    //     <div class="card_top">';

                        //    $order_id= $row1['order_id'] ;
                        // $status= $row1['order_state'] ;
                    //     $placed_date= $row1['place_date'] ;
                    //     $dealer= $row1['name'] ;
                    
                        
                        
                    //     $output .= '<div class="top_content">
                    //     <div>
                    //         <strong>Order ID</strong>
                    //     </div>
                    //     <div>
                    //         '.$orderid.'
                    //     </div>
                    // </div>
                    // <div class="top_content">
                    //     <div>
                    //         <strong>Placed Date</strong>
                    //     </div>
                    //     <div>
                    //         '.$placed_date.'
                    //     </div>
                    // </div>';

                    //select products' product_id which include relavant reservation and product names relavant product ids include relavant reservation
                    // $result2 = $this->Query("SELECT * FROM reservation_include WHERE order_id = '{$order_id}'");
                    $result2 = $this->Query("SELECT p.name as product_name, c.name as company_name, r.quantity as quantity, r.unit_price as unit_price,p.image as product_image,p.weight as product_weight 
                            FROM reservation_include r 
                            INNER JOIN product p ON r.product_id = p.product_id 
                            INNER JOIN company c ON p.company_id = c.company_id 
                            WHERE r.order_id = '{$order_id}'");
                    $total_amount = 0;
                    // $document = '';
                    $products = array();
                    while($row2 = mysqli_fetch_assoc($result2)){
                    
                        //select product names relavant product ids include relavant reservation
                        // $result3 = $this->Query()"SELECT p.name as product_name, c.name as company_name,p.image as product_image,p.weight as product_weight FROM product p INNER JOIN company c ON p.company_id = c.company_id WHERE product_id = '{$row2['product_id']}'");
                        
                        //print items and their quantity
                        // while($row3 = mysqli_fetch_assoc($result3)){
                            $quantity = $row2['quantity'];
                            $unit_price = $row2['unit_price'];
                            // $product_img = $row3['product_image'];
                            $amount = $quantity * $unit_price;
                            $total_amount = $total_amount + $amount;
                        //     $document .= '<div class="item">
                        //     <div class="item_img">
                        //         <img src="../../model/Company/images/'.$product_img.'" alt="">
                        //     </div>
                        //     <div class="item_content">
                        //         <h5>'.$row3['company_name'].'</h5>
                        //         <h4>'.$row3['product_weight'].'Kg '.$row3['product_name'].'</h3>
                        //         <div><p>Unit Price:<strong> RS.'.number_format($unit_price).'.00</strong></p><p>Qty:<strong>'.$quantity.'</strong></p></div>
                        //     </div>
                        // </div>';
                        
                    
                        array_push($products,$row2);
                    
                        
                    }
        
                    //     $output .= '<div class="top_content">
                    //     <div>
                    //         <strong>Total Amount</strong>
                    //     </div>
                    //     <div>
                    //         Rs.'.number_format($total_amount).'.00
                    //     </div>
                    // </div>
                    // <div class="top_content">
                    //     <div>
                    //         <strong>Status</strong>
                    //     </div>
                    //     <div>
                    //         '.$status.'
                    //     </div>
                    // </div>
                    // <div class="top_content">
                    //     <div>
                    //         <strong>Dealer</strong>
                    //     </div>
                    //     <div>
                    //         '.$dealer.'
                    //     </div>
                    // </div>

                    // </div>';

                    // $output .= '</div>';


                    //check status is Pending or Accepted then active cancel option
                    // if($status == "Pending" || $status == "Accepted"){
                    //     $output .= '<div class="cancel_card_bottom">
                    //     <div class="cancel_item_side">';
                    //     $output .= $document;
                    //     $output .= '<div class="cancel_btn"><button>Cancel Reservation</button></div>
                    //                 <div class="back_btn"><a href="allmyreservation.php"><button class="bbtn">Back</button></a></div>
                    //             </div>'; //item_side div close tag
                    // }
                
                    //check status is Completed or Delivered then display already added reviews and reviews count<3 then active add review option
                    // else if($status == "Completed" || $status == "Delivered"){
                        $reviews = array();
                        $result3 = $this->Query("SELECT * FROM review WHERE  order_id = '{$order_id}' ORDER BY date DESC LIMIT 3");
                        while($row3 = mysqli_fetch_assoc($result3)){
                            array_push($reviews,$row3);
                        }
                    //     //check there is previous reviews or not
                    //     if(mysqli_num_rows($result4)==0){
                    //         $output .= '<div class="card_bottom">
                    //         <div class="item_side">';
                    //         $output .= $document;
                    //         $output .= '</div><div class="review_side"><strong>Reviews</strong>
                    //         <div class="review_box">
                    //             <div class="content"><p><center>Add your reviews!</center></p></div>
                    //         </div>
                    //         <div class="review_btn"><button class="rbtn" onclick="openreview('.$orderid.')">Write Review</button></div>
                    //         <div class="back_btn"><a href="allmyreservation.php"><button class="bbtn">Back</button></a></div>
                    //         </div>';
                    //     }else{
                    //         // $output .= '<table class="review_table"><tr><td><b>Review:</b></td><td>';
                    //         $output .= '<div class="card_bottom">
                    //         <div class="item_side">';
                    //         $output .= $document;
                    //         $output .= '</div><div class="review_side"><strong>Reviews</strong>';
                    //         //display previous added review
                    //         while($row4 = mysqli_fetch_assoc($result4)){
                    //             $output .= '<div class="review_box">
                    //             <div class="date"><h5>'.$row4['date'].'</h5></div>
                    //             <div class="content"><p>'.$row4['message'].'</p></div>
                    //             </div>';
                    //         }

                    //         $output .= '<div class="review_btn"><button class="rbtn" onclick="openreview('.$orderid.')">Write Review</button></div>
                    //         <div class="back_btn"><a href="allmyreservation.php"><button class="bbtn">Back</button></a></div>
                    //         </div>';
                    //     }

                    
                
                    // }
                        array_push($myreservation,['order'=>$row1,'products'=>$products,'total_amount'=>$total_amount,'reviews'=> $reviews]);
                }
            // $output .= '</div>
            // </div>
            // </div>';
            
            // echo $output;
        }
    
        return $myreservation;
    }

    //add new review for selected reservation
    public function AddReviw($order_id,$customer_id){

        $review = array();
        
        $result1 = $this->Query("SELECT collecting_method FROM reservation WHERE order_id = '{$order_id}'");
        while($row1=mysqli_fetch_assoc($result1)){
             $collecting_method = $row1['collecting_method'] ;
             array_push($review,['collecting_methods'=>$collecting_method]);
        }
       
      
       

        //check collecting method , Pick up orders only has review_type 'Dealer'
        if($collecting_method == 'Pick up'){
            $type = 'Dealer';

            //check fields are empty
            if(!empty($message)){
                //add review to review table relavant customer relavant order
                $result2 =  $this->Query("INSERT INTO review(order_id, date, time, message, review_type) VALUES('{$order_id}','{$date}','{$time}','{$message}','{$type}')");
                
                if($result2){
                    $result3 = $this->Query("SELECT * FROM review WHERE order_id = '{$order_id}'");
                    $row = mysqli_fetch_assoc($result3);
                    $_SESSION['customer_id'] = $customer_id; 
                    echo "success";
                
                }else{
                    echo "Something went wrong!";
                }
            }
            else{
                echo "Write your review!";
            }
        }
        //collecting method delivery then have both review_type Delivery and Dealer 
        else{
            if(isset($_POST['review_type'])){
                $type = mysqli_real_escape_string($conn,$_POST['review_type']);
            }

            //check fields are empty
            if(!empty($message) && !empty($type)){
                //add review to review table relavant customer relavant order
                $result2 = mysqli_query($conn, "INSERT INTO review(order_id, date, time, message, review_type) VALUES('{$orderid}','{$date}','{$time}','{$message}','{$type}')");
                
                if($result2){
                    $result3 = mysqli_query($conn,"SELECT * FROM review WHERE order_id = '{$orderid}'");
                    $row = mysqli_fetch_assoc($result3);
                    $_SESSION['customer_id'] =$customer_id; 
                    echo "success";
                
                }else{
                    echo "Something went wrong!";
                }
                
            }
            else{
                echo "All input fields are required!";
            }
        
        }

        return $review;

    }
    

        

    
}





?>