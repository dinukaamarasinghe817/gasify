<?php
$header = new Header("customer/customer_viewmyreservation",$data);
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new Body('viewmyreservation', $data);
        // if(isset($data['verification'])){
        //     $prompt = new Prompt('verification',$data);
        // }
    ?>

     <div class="under_topbar">
        <div class="subtitle">
            <h3>Order Details</h3>
        </div>
        <div class="card">

        <?php
            //display all details customer selected reservtion in my reservation tab
            $myreservation = $data['myreservation'];
        
            if(isset($data['myreservation'])){
                foreach($myreservation as $order){
                    $row1 = $order['order'];
                    $products = $order['products'];
                    $total_amount = $order['total_amount'];
                    
                    $place_time = $row1['place_time'];
                    $new_time = date('H:i:s', strtotime($place_time . ' + 1 hour')); // Add 1 hour to the place time and format the result as a time string
                    $current_time = date('H:i:s');
                    
                    $reviews = $order['reviews'];
                    $deliveries = $order['delivery'];
                    $url_dealer = BASEURL.'/profile/preview/dealer/'.$row1['dealer_id'].'/profile/customer/viewdealerprofile';
                    $url_delivery = BASEURL.'/profile/preview/delivery/'.$row1['delivery_id'].'/profile/customer/viewdeliveryprofile';
                    $url_cancel = BASEURL.'/Orders/customer_cancelreservation/'.$row1['order_id'].'';
                    $url_pay_slip_upload = BASEURL.'/Orders/reject_bank_slip_upload/'.$row1['order_id'].'/'.$row1['dealer_id'].'';
                   
                    //display order_id,order_state,place_date,Total Amount,collecting_method,payment_method
                    echo '<div class="order_card">
                            <div class="card_top">
                                <div class="top_content">
                                    <div>
                                        <strong>Order ID</strong>
                                    </div>
                                    <div>
                                        '.$row1['order_id'].'
                                    </div>
                                </div>
                                <div class="top_content">
                                    <div>
                                        <strong>Placed Date</strong>
                                    </div>
                                    <div>
                                        '.$row1['place_date'].'
                                    </div>
                                </div>
                                <div class="top_content">
                                    <div>
                                        <strong>Total Amount</strong>
                                    </div>
                                    <div>
                                        Rs.'.number_format($total_amount,2).'
                                    </div>
                                </div>
                                <div class="top_content">
                                    <div>
                                        <strong>Status</strong>
                                    </div>
                                    <div>
                                        '.$row1['order_state'].'
                                    </div>
                                </div>
                                <div class="top_content">
                                    <div>
                                        <strong>Payment Method</strong>
                                    </div>
                                    <div>
                                        '.$row1['payment_method'].'
                                    </div>
                                </div>
                                <div class="top_content">
                                    <div>
                                        <strong>Collecting Method</strong>
                                    </div>
                                    <div>
                                        '.$row1['collecting_method'].'
                                    </div>
                                </div>';
                                //if collecting method is delivery then display delivery charge
                                if($row1['collecting_method']== "Delivery"){
                                    echo  '<div class="top_content">
                                            <div>
                                                <strong>Delivery Charge</strong>
                                            </div>
                                            <div>
                                            Rs.'.number_format($row1['deliver_charge'],2).'   
                                            </div>
                                        </div>';

                                }

                            echo '</div><div class="bottom_all">';

                              //take delivery persons name 
                             $delivery_person_details = " ";
                            foreach ($deliveries as $delivery){
                                $delivery_person_details.= '<div class="profile_details">
                                                                <strong>Delivery Person: </strong>
                                                                <a href="'.$url_delivery.'"><strong>'.$delivery['delivery_name'].'</strong></a>
                                                            </div>';                  
                            }

                            //take delivered date and delivered time to display only completed and delivered orders
                            $delivery_details = " ";
                            foreach ($deliveries as $delivery){
                                $delivery_details .= '<div class="delivery_details">
                                                        <div>
                                                            <strong>Delivered Date: </strong>
                                                            '.$row1['deliver_date'].'
                                                        </div>
                                                        <div>
                                                            <strong>Delivered Time: </strong>
                                                            '.$row1['deliver_time'].'
                                                        </div>
                                                    </div>';
                            }
                   
                           
                            //display dealer details and delivery person details(only delivery orders)
                            echo '<div class="after_card_top">';
                                if($row1['collecting_method']== "Delivery"){
                                    echo '<div class = "dealer_details">
                                             <div  class="profile_details">
                                                <strong>Dealer : </strong>
                                                <a href="'.$url_dealer.'"><strong>'.$row1['dealer_name'].'</strong></a>
                                                
                                            </div>
                                         </div>
                                         <div class="delivery_person_details">
                                            '.$delivery_person_details.'
                                        </div>
                                        <div>
                                            <strong>Deliverey Address: </strong>
                                            '.$row1['deliver_street'].', '.$row1['deliver_city'].'
                                        </div>';
                                        if($row1['order_state'] == "Delivered" || $row1['order_state'] == "Completed"){
                                            echo '<div>'.$delivery_details.'</div>';
                                        }
                                }
                                else{
                                    echo '<div class = "dealer_details">
                                             <div  class="profile_details">
                                                <strong>Dealer : </strong>
                                                <a href="'.$url_dealer.'"><strong>'.$row1['dealer_name'].'</strong></a>
                                            </div>
                                         </div>';
                                }
                            echo '</div>';

                            
                          
                            
                            //display delivery details and canceled details(cancelled orders) and refund details(refunded orders)
                            echo'<div class = "after_dealer_delivery_details">';
                                if($row1['order_state'] == "Canceled" || $row1['order_state'] == "Refunded"){
                                    echo '<div class="cancel_details">
                                            <div>
                                                <strong>Cancelled Date : </strong> 
                                                '.$row1['cancel_date'].'
                                            </div>
                                            <div>
                                                <strong>Cancelled Time : </strong> 
                                            '.$row1['cancel_time'].'
                                            </div>';
                                            if($row1['refund_verification'] == "Pending"){
                                                echo '<div>
                                                        <strong style="color:#f20202" >Refund is processing</strong>
                                                    </div>';
                                            }else{
                                                echo '
                                                <div>
                                                    <strong>Refunded Date : </strong> 
                                                    '.$row1['refund_date'].'
                                                </div>
                                                <div>
                                                    <strong>Refunded Time : </strong> 
                                                    '.$row1['refund_time'].'
                                                </div>
                                                <div>
                                                    <strong>Refunded Bank : </strong> 
                                                    '.$row1['bank'].'
                                                </div>';
                                            }
                                    echo '</div>';
                                }
                                //display pay slip upload button only for payment rejected 
                                if($row1['order_state'] == "Pending" && $row1['payment_verification'] == "rejected"){
                                    echo '<div class="cancel_details">
                                            <div>
                                                <strong style="color:#f20202">Your Payment Slip was rejected.Please upload clear payslip again !</strong> 
                                            </div>
                                            <div>
                                                <button class="reject_payslip_uploadbtn" onclick="location.href=\''.$url_pay_slip_upload.'\'">Upload payslip</button>
                                            </div>';
                                            
                                    echo '</div>';
                                }
                            echo '</div>';

                    //display the products included in the order
                    $output = "";
                    foreach($products as $product){
                        $output .= '<div class="item">
                                        <div class="item_img">
                                            <img src="'.BASEURL.'/public/img/products/'.$product['product_image'].'" alt="">
                                        </div>
                                        <div class="item_content">
                                            <h5>'.$product['company_name'].'</h5>
                                            <h4>'.$product['product_weight'].'Kg  '.$product['product_name'].'</h3>
                                            <div><p>Unit Price:<strong> RS.'.number_format($product['unit_price']).'.00</strong></p><p>Qty:<strong>'.$product['quantity'].'</strong></p></div>
                                        </div>
                                    </div>';

                    }
                    
                    
                  

                    //check status is Pending or Accepted and during one hour duration from the place time then active cancel option
                    if($row1['order_state'] == "Pending" || $row1['order_state']=="Accepted"){
                        
                            echo'<div class="cancel_card_bottom">
                                    <div class="cancel_item_side">
                                        '.$output.'';
                                        if($row1['place_date'] == date('Y-m-d')){
                                            if($current_time <= $new_time){
                                                echo    '<div class="cancel_btn"><button onclick = "location.href=\''.$url_cancel.'\'">Cancel Reservation</button></div>';
                                            }else{
                                                if($row1['place_time'] >= '23:00:00'){  
                                                    echo    '<div class="cancel_btn"><button onclick = "location.href=\''.$url_cancel.'\'">Cancel Reservation</button></div>';
                                                }
                                            }
                                        }
                                        else{
                                            if($row1['place_date'] == date('Y-m-d', strtotime('-1 day'))){
                                                if($row1['place_time'] >= '23:00:00'){
                                                    if($current_time <= $new_time){
                                                        echo    '<div class="cancel_btn"><button onclick = "location.href=\''.$url_cancel.'\'">Cancel Reservation</button></div>';
                                                    }
                                                }
                                            }
                                        }
                                    echo '<div class="back_btn"><a href="'.BASEURL.'/Orders/customer_allreservations"><button class="bbtn">Back</button></a></div>
                                    </div>
                                </div>
                                </div>';
                        
                    }

                    //check status is Completed or Delivered then display already added reviews 
                    else if($row1['order_state'] == "Completed" || $row1['order_state']=="Delivered" ){
                        
                        $url = BASEURL.'/Orders/customer_reviewform/'.$row1['order_id'];
                        
                            //if there is no exists reviews
                            if(count($reviews)==0){
                                echo '<div class="card_bottom">
                                        <div class="item_side">
                                        '.$output.'
                                        </div>
                                        <div class="review_side"><strong>Reviews</strong>
                                            <div class="review_box">
                                                <div class="content"><p><center>Add your reviews!</center></p></div>
                                            </div>
                                            <div class="review_btn"><button class="rbtn" onclick="location.href=\''.$url.'\'" )">Write Review</button></div>
                                             <div class="back_btn"><a href="'.BASEURL.'/Orders/customer_allreservations"><button class="bbtn">Back</button></a></div>
                                        </div>';
    
                            }
                            //if there already exists reviews
                            else{
                                if( $row1['collecting_method']=="Delivery"){
                                    echo '<div class="card_bottom">
                                            <div class="item_side">  
                                            '.$output.'
                                            </div>
                                            <div class="review_side"><strong>Reviews</strong>';
                                }else{
                                    echo '<div class="card_bottom">
                                    <div class="item_side">
                                        
                                    '.$output.'
                                    </div>
                                    <div class="review_side"><strong>Reviews</strong>';
                                }
                                //display the already exist reviews
                                foreach($reviews as $review){
                                    echo '<div class="review_box">
                                            <div class="date">
                                                <div><h5>To:'.$review['review_type'].'</h5></div>
                                                <div><h5>'.$review['date'].'</h5></div>
                                            </div>
                                            <div class="content"><p>'.$review['message'].'</p></div>
                                        </div>';
                                }
    
                                echo '  <div class="review_btn"><button class="rbtn" onclick="location.href=\''.$url.'\'">Write Review</button></div>
                                        <div class="back_btn"><a href="'.BASEURL.'/Orders/customer_allreservations"><button class="bbtn">Back</button></a></div>
                                    </div>';
                            }
                        
                

                    }
                    //check status is dispatched or cancelled or refunded ,there is no cancel and review options
                    else if($row1['order_state'] == "Dispatched" || $row1['order_state'] == "Canceled" || $row1['order_state'] == "Refunded"){
                        echo'<div class="cancel_card_bottom">
                                <div class="cancel_item_side">
                                    '.$output.' 
                                    <div class="back_btn"><a href="'.BASEURL.'/Orders/customer_allreservations"><button class="bbtn">Back</button></a></div>
                                </div>
                            </div>';
                    }

                }

            
            }
        ?>
    </div>
</section>

<?php
$footer = new Footer("customer");
?>