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
                    $reviews = $order['reviews'];
                    $deliveries = $order['delivery'];
                    $url_dealer = BASEURL.'/profile/preview/dealer/'.$row1['dealer_id'].'/profile/customer/viewdealerprofile';
                    $url_delivery = BASEURL.'/profile/preview/dealer/'.$row1['delivery_id'].'/profile/customer/viewdealerprofile';
                    // echo $row1['delivery_name'];
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
                                        Rs.'.number_format($total_amount).'.00
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
                                
                            </div>';

                       
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
                                    // echo $output;
                    }
                    
                    //take delivery persons name
                    $output1 = " ";
                    foreach ($deliveries as $delivery){
                        $output1 .= ' <div class="d_details">
                                        <div>
                                            <strong>Delivery : </strong>
                                        </div>
                                        <div>
                                            '.$delivery['delivery_name'].'
                                        </div>
                                        <div>
                                            <button class="d_btn" onclick = "location.href=\''.$url_delivery.'\'">More details</button>
                                        </div>

                                    </div>';
                    }
                   

                    //check status is Pending or Accepted then active cancel option
                    if($row1['order_state'] == "Pending" || $row1['order_state']=="Accepted"){
                        echo'<div class="cancel_card_bottom">
                                <div class="cancel_item_side">
                                    <div class="d_details">
                                        <div>
                                            <strong>Dealer : </strong>
                                        </div>
                                        <div>
                                            '.$row1['dealer_name'].'
                                        </div>
                                        <div>
                                            <button class="d_btn" onclick = "location.href=\''.$url_dealer.'\'">More details</button>
                                        </div>
                                    </div>

                                    '.$output.' 
                                    <div class="cancel_btn"><button onclick="customerprompt(\'confirmcancellation\',\''.BASEURL.'/Orders/customer_cancelreservation/'.$row1['order_id'].'\',\''.BASEURL.'/Orders/customer_myreservation/'.$row1['order_id'].'\'); return false;" >Cancel Reservation</button></div>
                                    <div class="back_btn"><a href="'.BASEURL.'/Orders/customer_allreservations"><button class="bbtn">Back</button></a></div>
                                </div>
                            </div>';
                    }

                    //check status is Completed or Delivered then display already added reviews and reviews count<3 then active add review option
                    else if($row1['order_state'] == "Completed" || $row1['order_state']=="Delivered"){
                        
                        $url = BASEURL.'/Orders/customer_reviewform/'.$row1['order_id'];
                            
                        
                            if(count($reviews)==0){
                                echo '<div class="card_bottom">
                                        <div class="item_side">
                                            <div class="d_details">
                                                <div>
                                                    <strong>Dealer : </strong>
                                                </div>
                                                <div>
                                                    '.$row1['dealer_name'].'
                                                </div>
                                                <div>
                                                    <button class="d_btn" onclick = "location.href=\''.$url_dealer.'\'">More details</button>
                                                </div>
                                            </div>
                                            '.$output1.'
    
                                        '.$output.'
                                        </div>
                                        <div class="review_side"><strong>Reviews</strong>
                                            <div class="review_box">
                                                <div class="content"><p><center>Add your reviews!</center></p></div>
                                            </div>
                                            <div class="review_btn"><button class="rbtn" onclick="location.href=\''.$url.'\'" )">Write Review</button></div>
                                             <div class="back_btn"><a href="'.BASEURL.'/Orders/customer_allreservations"><button class="bbtn">Back</button></a></div>
                                        </div>';
    
                            }else{
                                echo '<div class="card_bottom">
                                        <div class="item_side">
                                            <div class="d_details">
                                                <div>
                                                    <strong>Dealer : </strong>
                                                </div>
                                                <div>
                                                    '.$row1['dealer_name'].'
                                                </div>
                                                <div>
                                                    <button class="d_btn" onclick = "location.href=\''.$url_dealer.'\'">More details</button>
                                                </div>
                                            </div>'.$output1.'
    
                                        '.$output.'
                                        </div>
                                        <div class="review_side"><strong>Reviews</strong>';
    
                                foreach($reviews as $review){
                                    echo '<div class="review_box">
                                            <div class="date"><h5>'.$review['date'].'</h5></div>
                                            <div class="content"><p>'.$review['message'].'</p></div>
                                        </div>';
                                }
    
                                        echo '  <div class="review_btn"><button class="rbtn" onclick="location.href=\''.$url.'\'">Write Review</button></div>
                                                <div class="back_btn"><a href="'.BASEURL.'/Orders/customer_allreservations"><button class="bbtn">Back</button></a></div>
                                            </div>';
                            }
                        
                        

                    }
                    //check status is dispatched
                    else if($row1['order_state'] == "Dispatched"){
                        echo'<div class="cancel_card_bottom">
                                <div class="cancel_item_side">
                                    <div class="d_details">
                                        <div>
                                            <strong>Dealer : </strong>
                                        </div>
                                        <div>
                                            '.$row1['dealer_name'].'
                                        </div>
                                        <div>
                                            <button class="d_btn" onclick = "location.href=\''.$url_dealer.'\'">More details</button>
                                        </div>
                                    </div>'.$output1.'

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