<?php
$header = new Header("customer/customer_allmyreservation");
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new Body('allmyreservation', $data);
        
    ?>

    <div class="under_topbar">
        <div class="subtitle">
            <h3>My Reservations</h3>
        </div>
        <div class="table">
            <?php   
                //display all reservations
                $allmyreservations = $data['allmyreservations'];
            
                if(count($allmyreservations)==0){
                    // echo '<table><tr id="first_row"><th><h3><center>No reservations Found!</center></h3></td></tr></table>';
                    echo '<table><div class="table_header">
                        <tr id="first_row"><th>Order ID</th><th id="place_date_header">Placed Date</th><th id="tot_amount_header">Total Amount</th><th>Status</th><th></th></tr></div>';
                        echo'<tr><td></td><td><img src="../img/placeholders/1.png"></td><td></td></tr></table>';

                }else{
                    if(isset($data['allmyreservations'])){
                        echo '<table><div class="table_header">
                        <tr id="first_row"><th>Order ID</th><th id="place_date_header">Placed Date</th><th id="tot_amount_header">Total Amount</th><th>Status</th><th></th></tr></div>';
                        
                        foreach($allmyreservations as $order){
                            $row1 = $order['order'];
                            $url = BASEURL.'/Orders/customer_myreservation/'.$row1['order_id'];
                            echo'<tr><td>'.$row1['order_id'].'</td><td id="place_date">'.$row1['place_date'].'</td><td id="tot_amount">Rs .'.number_format($order['total_amount']).'.00</td><td>'.$row1['order_state'].'</td><td><a><button type="submit" class="More_details" onclick="location.href=\''.$url.'\'">More Details</button></a></td></tr>';

                        }
                    }
                }
           
            ?>
        </div>
    </div>
    
</section>

<?php
$footer = new Footer();
?>