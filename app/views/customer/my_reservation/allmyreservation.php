<?php
$header = new Header("customer/customer_allmyreservation",$data);
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        
    ?>

    <div class="under_topbar">
        <div class="subtitle">
            <h3>My Reservations</h3>
        </div>
            <?php 
            $search = new Search([1,2,4]);
            ?>
        <div class="table">
            <?php   
                //display all reservations
                $allmyreservations = $data['allmyreservations'];
                if(count($allmyreservations)==0){
                    // echo '<table><tr id="first_row"><th><h3><center>No reservations Found!</center></h3></td></tr></table>';
                    echo '<table class="styled-table"><div class="table_header">
                        <thead><tr id="first_row"><th>Order ID</th><th id="place_date_header">Placed Date</th><th id="tot_amount_header">Total Amount</th><th>Status</th><th></th></tr></thead></div>';
                        echo'<tbody><tr><td></td><td></td><td><strong>No Reservations Found!</strong></td><td></td><td></td></tr></tbody></table>';

                }else{
                    if(isset($data['allmyreservations'])){
                        echo '<table class="styled-table"><div class="table_header">
                        <thead>
                            <tr id="first_row">
                                <th></th>
                                <th>Order ID</th>
                                <th id="place_date_header">Placed Date</th>
                                <th id="tot_amount_header">Total Amount</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead></div><tbody>';
                        
                        foreach($allmyreservations as $order){
                            $row1 = $order['order'];
                            $url = BASEURL.'/Orders/customer_myreservation/'.$row1['order_id'];
                            if($row1['order_state']=='Canceled'){
                                echo'<tr><td><div style="height: 20px; width: 20px; border-radius: 50%; background-color:#f20202;"></div></td><td>'.$row1['order_id'].'</td><td id="place_date">'.$row1['place_date'].'</td><td id="tot_amount">Rs .'.number_format($order['total_amount']).'.00</td><td style="color:#f20202  ;">  '.$row1['order_state'].'</td><td><a><button type="submit" class="More_details" onclick="location.href=\''.$url.'\'">More Details</button></a></td></tr>';
                            }else if($row1['order_state']=='Pending'){
                                echo'<tr><td><div style="height: 20px; width: 20px; border-radius: 50%; background-color: #F1C40F;"></div></td><td>'.$row1['order_id'].'</td><td id="place_date">'.$row1['place_date'].'</td><td id="tot_amount">Rs .'.number_format($order['total_amount']).'.00</td><td style="color:#F1C40F;">  '.$row1['order_state'].'</td><td><a><button type="submit" class="More_details" onclick="location.href=\''.$url.'\'">More Details</button></a></td></tr>';
                            }else if($row1['order_state']=='Accepted'){
                                echo'<tr><td><div style="height: 20px; width: 20px; border-radius: 50%; background-color: #F39C12;"></div></td><td>'.$row1['order_id'].'</td><td id="place_date">'.$row1['place_date'].'</td><td id="tot_amount">Rs .'.number_format($order['total_amount']).'.00</td><td style="color:#F39C12 ;">  '.$row1['order_state'].'</td><td><a><button type="submit" class="More_details" onclick="location.href=\''.$url.'\'">More Details</button></a></td></tr>';
                            }else if($row1['order_state']=='Dispatched'){
                                echo'<tr><td><div style="height: 20px; width: 20px; border-radius: 50%; background-color: #3498DB;"></div></td><td>'.$row1['order_id'].'</td><td id="place_date">'.$row1['place_date'].'</td><td id="tot_amount">Rs .'.number_format($order['total_amount']).'.00</td><td style="color:#3498DB;">  '.$row1['order_state'].'</td><td><a><button type="submit" class="More_details" onclick="location.href=\''.$url.'\'">More Details</button></a></td></tr>';
                            }else if($row1['order_state']=='Delivered'){

                                echo'<tr><td><div style="height: 20px; width: 20px; border-radius: 50%; background-color: #2980B9;"></div></td><td>'.$row1['order_id'].'</td><td id="place_date">'.$row1['place_date'].'</td><td id="tot_amount">Rs .'.number_format($order['total_amount']).'.00</td><td style="color:#2980B9;">  '.$row1['order_state'].'</td><td><a><button type="submit" class="More_details" onclick="location.href=\''.$url.'\'">More Details</button></a></td></tr>';
                            }else if($row1['order_state']=='Completed'){
                                echo'<tr><td><div style="height: 20px; width: 20px; border-radius: 50%; background-color: #239B56;"></div></td><td>'.$row1['order_id'].'</td><td id="place_date">'.$row1['place_date'].'</td><td id="tot_amount">Rs .'.number_format($order['total_amount']).'.00</td><td style="color:#239B56;">  '.$row1['order_state'].'</td><td><a><button type="submit" class="More_details" onclick="location.href=\''.$url.'\'">More Details</button></a></td></tr>';
                            }
                            elseif($row1['order_state']=='Refunded'){
                                echo'<tr><td><div style="height: 20px; width: 20px; border-radius: 50%; background-color: #f20202;"></div></td><td>'.$row1['order_id'].'</td><td id="place_date">'.$row1['place_date'].'</td><td id="tot_amount">Rs .'.number_format($order['total_amount']).'.00</td><td style="color:#f20202;">'.$row1['order_state'].'</td><td><a><button type="submit" class="More_details" onclick="location.href=\''.$url.'\'">More Details</button></a></td></tr>';
                            }
                        }
                        echo '</tbody></table>';

                    }
                }
           
            ?>
        </div>
    </div>
    
</section>

<?php
$footer = new Footer();
?>