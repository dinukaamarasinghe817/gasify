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
       
    ?>

    <div class="under_topbar">
        <div class="subtitle">
            <h3>Bank Details</h3>
        </div>
        <div class="middle">
        <?php
        echo'<div class="detail_form">
                <form action="" >
                    <input type="text" placeholder="Bank Name">
                    <input type="text" placeholder="Branch">
                    <input type="text" placeholder="Account No">
                    <button type="submit" class="submit_btn" onclick="customerprompt(\'cancelorder\',\''.BASEURL.'/Orders/customer_allreservations/\'); return false;">Submit</button>
                </form>
                
            </div>';

        ?>
            <div class="image">
                <img src="<?php echo BASEURL;?>/public/img/customer/refund.png" alt="">
            </div>
        </div>



    </div> 
</section>

<?php
$footer = new Footer("customer");
?>