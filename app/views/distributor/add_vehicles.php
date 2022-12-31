<?php
$header = new Header("vehicles");
$sidebar = new Navigation('distributor',$data['navigation']);
?>

<section class="body">
    <?php 
    // call the default header for your interface
    $bodyheader = new BodyHeader($data);
    // $bodycontent = new Body('vehicles_comp', $data);
    ?>

    <section class="body-content">
          <h2>Vehicles</h2> <br>

          <?php 
          $result = new Vehicles_Comp("add");
          ?>

          <div class="main2">

            <!-- <form action=BASEURL."/vehicles/addvehicle" method="POST"> -->
            <form action="<?php echo BASEURL;?>/vehicles/addvehicle" method="POST">
                <div class="err-txt1"><p>This is an error message!</p></div>

                <div class="part1">
                    <label>Vehicle Number </label>               
                    <input type="text" name="vehiclenum" placeholder="Vehicle Number" required>
                </div>
                
                <div class="part1">
                    <label>Vehicle Type  </label>
                    <input type="text" name="type" placeholder="Vehicle Type" required>
                </div>

                <div class="part2">
                    <label>Weight Limit - </label>
                    <?php 
                        $result = $data['vehicles'];
                        while($product = mysqli_fetch_assoc($result)) {
                            $productid = $product['product_id'];
                            $productname = $product['name'];
                            echo '<div class="capinput"> 
                                    <p>'.$productname.':</p>
                                    <input name="'.$productid.'" type= "number" min="0" placeholder="capacity">
                                </div>';
                        }
                    ?>
                </div>

                <div class="part1">
                    <label>Fuel Consumption </label>
                    <input type="number" name = "consumption" min="0" placeholder="Fuel Consumption" required>
                </div>

                <div>
                    <button class="btn2" type="submit" name ="submit"><b>Submit</b></button>
                </div>
        
            </form>

        </div>
        </section>
</section>

<?php
$footer = new Footer();
?>