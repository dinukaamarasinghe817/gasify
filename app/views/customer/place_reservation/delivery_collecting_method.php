<?php
$header = new Header("customer/select_collecting_method",$data);
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        
    ?>

    <div class="under_topbar">
         
        <div class="subtitle">
            <h3>Delivery Charges</h3>
        </div> 
        <div class="delivery_middle">
            <div class="delivery_middle_content">
                <label for=""><h4>Your Delivery Address :</h4></label>
                <div class="deliver_address"><h3><?php echo $data['street'] ,' , ', $data['city']; ?></h3> <button onclick="customerprompt('deliveryaddress','<?php echo BASEURL;?>/Orders/select_delivery_method','<?php echo $data['selected_city']; ?>'); return false;" class="edit_btn">edit</button></div>

                <div class="delivery_fee">
                    <h4>Delivery Fee :</h4><h3>RS.<?php  echo $data['delivery_charge'];?>.00</h3>
                    
                </div>
                <div class="content_bottom">
                    <h4>You must pay delivery fee to the delivery person when he deliver your reservation to your door step.</h4>
                    <div class="button_bottom">
                        <button  id="cancel_btn" onclick="location.href='<?php echo BASEURL;?>/Orders/select_collecting_method'" class="btn">Cancel</button>
                        <button  id="confirm_btn" onclick="customerprompt('thankyou','<?php echo BASEURL;?>/Orders/getcollecting_method/Delivery'); return false;" class="btn">Confirm</button>
                        
                    </div>
                </div>
                
            </div>
            <div class="deliver_image">
                <img src="<?php echo BASEURL?>/public/img/customer/delivery.jpg" alt="">
            </div>
            
            
        </div>
        
    </div>
</section>

<?php
$footer = new Footer("customer");
?>



