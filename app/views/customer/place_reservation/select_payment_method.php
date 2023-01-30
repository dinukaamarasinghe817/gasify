<?php
$header = new Header("customer/select_payment_method");
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        
    ?>

<div class="under_topbar">
        <div class="subtitle">
           <h3>Payment Method</h3>
        </div> 
        
        <div class="middle">
            <div class="order_detail_card">
                <div class="order_details">
                    <div class="p_img">
                        <img src="<?php echo 'BASEURL'; ?>/public/img/products/12.5kglitro.png" alt="">
                    </div>
                    <div class="p_name"></div>
                    <div class=""></div>
                    <div class="qty"></div>
                </div>
                <div class="total">

                </div>
            </div>
        </div>

        <div class="bottom">
            <a href="<?php echo BASEURL; ?>/Products/select_products/2" class="btn">Next</a>
        </div>

</section>