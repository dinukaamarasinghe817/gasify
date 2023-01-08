<?php
$header = new Header("customer_addreview");
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new Body('addreview', $data);
        
    ?>
       
    <div class="under_topbar">
        <div class="subtitle">
           <h3>Add Review</h3>
        </div>        
        <?php
            //write a review for selected customer completed or delivered reservation

            echo '<div class="write_review">
                    <form id="write_review_form" method="POST" action="'.BASEURL.'/Orders/customer_addreview/'.$data['order_id'].'">';
            
            $collecting_method = $data['collecting_method'];
            if($collecting_method == 'Pick up'){
                echo '<div class="type_title"><h3>Add Review for Dealer:</h3></div><div class="radio"></div>';
            }else{

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
        
            $url =  BASEURL.'/Orders/customer_myreservation/'.$data['order_id'];
    
            echo '<div class="error-txt">This is error text!</div>';

            echo'<div class="write_box">
                    <textarea name="review" placeholder="Write your review here....." cols="30" rows="10"></textarea>
                </div>
                <div class="btn">
                    <button id="send" class="send" type="submit"  >Submit</button>
                    <button id="cancel" class="cancel" type="submit" onclick="location.href=\''.$url.'\'" >Cancel</button>
                    
                </div>
            </form>
            </div>';
        ?>
            
    </div>
</section>


<?php
$footer = new Footer();
?>