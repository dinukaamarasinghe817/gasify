<?php
$header = new Header("customer/customer_addreview",$data);
$sidebar = new Navigation('customer',$data['navigation']);

?>

<section class="body">
    <?php
        // call the default header for interface
        $bodyheader = new BodyHeader($data);
    ?>
       
    <div class="under_topbar">
        <div class="subtitle">
           <h3>Add Review</h3>
        </div>        
        <?php
            //write a review for selected customer completed or delivered reservation
            echo '<div class="write_review">
                    <form id="write_review_form" method="POST" action="'.BASEURL.'/Orders/customer_addreview/'.$data['order_id'].'">';
            
            //check order collecting method delivery or pick up
            $collecting_method = $data['collecting_method'];
            //pick up orders only can give reviews for dealers
            if($collecting_method == 'Pickup'){
                echo '<div class="type_title"><h3>Add Review for Dealer:</h3></div><div class="radio"></div>';
            }
            //delivery orders can give reviews for dealer and delivery person
            else{
                echo '<div class="type_title"><h3>Select Review Type:</h3></div>
                        <div class="radio">
                            <div>
                                <input type="radio" value="Dealer" id="Dealer" name="review_type" >
                                <label for="Dealer">Delaer</label>
                            </div>
                            <div>
                                <input type="radio" value="Delivery" id="Delivery"  name="review_type" >
                                <label for="Delivery">Delivery</label>
                            </div>
                        </div>';

            }
            
            echo'<div class="write_box">
                    <textarea name="review" placeholder="Write your review here....." cols="30" rows="10"></textarea>
                </div>
                <div class="btn">
                    <button id="send" class="send" type="submit" >Submit</button>
                </div>
            </form>';
        ?>
            <div class="btn">
                <button id="cancel" class="cancel" onclick= "document.location.href = '<?php echo BASEURL;?>/Orders/customer_myreservation/<?php echo $data['order_id']?>'" >Cancel</button>
            </div>
        </div>
            
    </div>
</section>


<?php
$footer = new Footer();
?>