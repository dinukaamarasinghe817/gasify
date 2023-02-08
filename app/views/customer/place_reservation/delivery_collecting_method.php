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
            <h3>Collecting Method</h3>
        </div> 
        
        <div class="bottom">
            <a href="<?php echo BASEURL; ?>/Orders/select_collecting_method" class="btn" id="back_btn">Back</a>
            <!-- <a href="<?php echo BASEURL; ?>/Orders/select_payment_method" class="btn" id="next_btn">Next</a> -->
        </div>
    </div>
</section>

<?php
$footer = new Footer("customer");
?>



