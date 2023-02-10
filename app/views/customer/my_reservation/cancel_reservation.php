<?php
$header = new Header("customer/cancel_reservation",$data);
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new Body('viewmyreservation', $data);
        if(isset($data['error'])){
            $error = new Prompt('toast',$data['error']);

        }
       
    ?>

    <div class="under_topbar">
        <div class="subtitle">
            <h3>Bank Details</h3>
        </div>
        <div class="middle">
        <?php

            $order_id = $data['order_id'];

            echo'<div class="detail_form">
                    <form id="bank_details_form" method="POST"  action="'.BASEURL.'/Orders/refund_bank_details/'.$data['order_id'].'" >
                        <input type="text" name="bank" placeholder="Bank Name">
                        <input type="text" name="branch" placeholder="Branch">
                        <input type="text" name="Acc_no" placeholder="Account No">
                        <button type="submit" class="submit_btn" onclick="customerprompt(\'cancelorder\',\''.BASEURL.'/Orders/customer_allreservations\'); return false;">Submit</button>
                    </form>
                
                </div>';

        ?>
        <!-- onclick="customerprompt(\'cancelorder\',\''.BASEURL.'/Orders/customer_allreservations\'); return false;" -->
            <div class="image">
                <img src="<?php echo BASEURL;?>/public/img/customer/refund.png" alt="">
            </div>
        </div>



    </div> 
</section>

<?php
$footer = new Footer("customer");
?>