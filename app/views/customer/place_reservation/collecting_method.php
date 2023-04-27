<?php
$header = new Header("customer/select_collecting_method",$data);
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        $order_id = $_SESSION['order_id'];
        
    ?>

    <div class="under_topbar">
    <script>
        window.onload = function() {
            customerprompt('deliverymethod');
        };
    </script>
        <div class="subtitle">
            <h3>Collecting Method</h3>
        </div> 
        <div class="middle">
            <?= $data['delivery_charge'] ?>
            <!-- take hidden inputs as city,street and delivery charge -->
            <input type="text" class="home_city" name="city" value="<?= $data['city'] ?>" hidden>
            <input type="text" class="home_street" name="street" value="<?= $data['street'] ?>" hidden>
            <input type="number"  class="d_charge" name="d_charge" step= 0.01 value="<?= $data['delivery_charge'] ?>" hidden>
            <input type="text" class="cities" name="cities" value='<?=json_encode(CITIES); ?>' hidden>
           
            <!-- background-image -->
            <div class="middle_img"><img src="<?php echo BASEURL;?>/public/img/banner/collecting_method.jpg" alt=""></div>
                 
        </div>
    </div>
</section>

<?php
$footer = new Footer("customer");
?>