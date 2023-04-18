<?php
$header = new Header("admin",$data);
$sidebar = new Navigation('admin','delivery');
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new ProfileHTML($data);
    ?>
    <section class="body-content deliverycharges">
            <div class="top-panel">
                <ul>
                <li><a href="<?php echo BASEURL; ?>/users/deliveries" class="current">Delivery People</a></li>
                <li><a href="<?php echo BASEURL; ?>/users/deliveries/charges" class="current active">Delivery Charges</a></li>
                </ul>
            </div>
            <div class="content-data">
                <img src="<?php echo BASEURL;?>/public/img/placeholders/delivery.jpg" alt="">
                <form action="<?php echo BASEURL?>/users/deliveries/charges" method="post">
                    <h2>Distances and charges</h2>
                    <?php $delivery_charges = $data['delivery_charges'];?>
                    <?php $row = mysqli_fetch_assoc($delivery_charges); ?>
                    <div><label for="">00-10 km : </label><label class="currency" data-currency="Rs."><input name="0" type="number" value=<?php echo number_format($row['charge_per_kg'],2)?> step=0.01 min=0.00></label></div>
                    <?php $row = mysqli_fetch_assoc($delivery_charges); ?>
                    <div><label for="">10-20 km : </label><label class="currency" data-currency="Rs."><input name="10" type="number" value=<?php echo number_format($row['charge_per_kg'],2)?> step=0.01 min=0.00></label></div>
                    <?php $row = mysqli_fetch_assoc($delivery_charges); ?>
                    <div><label for="">20-30 km : </label><label class="currency" data-currency="Rs."><input name="20" type="number" value=<?php echo number_format($row['charge_per_kg'],2)?> step=0.01 min=0.00></label></div>
                    <?php $row = mysqli_fetch_assoc($delivery_charges); ?>
                    <div><label for="">30-40 km : </label><label class="currency" data-currency="Rs."><input name="30" type="number" value=<?php echo number_format($row['charge_per_kg'],2)?> step=0.01 min=0.00></label></div>
                    <?php $row = mysqli_fetch_assoc($delivery_charges); ?>
                    <div><label for="">40-50 km : </label><label class="currency" data-currency="Rs."><input name="40" type="number" value=<?php echo number_format($row['charge_per_kg'],2)?> step=0.01 min=0.00></label></div>
                    <?php $row = mysqli_fetch_assoc($delivery_charges); ?>
                    <div><label for="">more than 50 km : </label><label class="currency" data-currency="Rs."><input name="50" type="number" value=<?php echo number_format($row['charge_per_kg'],2)?> step=0.01 min=0.00></label></div>
                    <button type="submit" class="button">Save</button>
                </form>
            </div>
    </section>
</section>

<?php
$footer = new Footer("admin");
?>