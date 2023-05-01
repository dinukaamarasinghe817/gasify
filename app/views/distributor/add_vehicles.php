<?php
$header = new Header("vehicles");
$sidebar = new Navigation('distributor',$data['navigation']);

$user_id = $_SESSION['user_id'];

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
                <div class="err-txt1">
                    <?php
                        if(isset($data['error'])){
                            echo '<p>'.$data['error'].'</p>';
                        }
                    ?>
                </div>

                <div class="part1">
                    <label>Vehicle Number </label>               
                    <input type="text" name="vehiclenum" placeholder="Vehicle Number" required>
                </div>

                <div class="part1">
                    <label>Vehicle Type  </label>
                    <!-- <option value="-1" selected disabled hidden>Select vehicle type</option> -->
                    <!-- <input type="text" name="type" placeholder="Vehicle Type" required> -->
                    <select name="type">
                        <!-- <option value="-1" selected disabled hidden class="optiontxt" name="type">Select vehicle type</option> -->
                        <option value="-1" selected disabled hidden class="optiontxt">Select vehicle type</option>

                        <?php
                            $type = ['2 axels', '3 axels', '4 axels', '5 axels', '6 axels'];
                            foreach($type as $type) {
                                echo "<option value=$type>$type</option>";
                            }
                        ?>

                    </select>
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
                    <!-- <button class="btn2" type="submit" name ="submit" onclick="openPopup();"><b>Submit</b></button> -->
                </div>
            </form>

                    
                    <!-- popup box -->
                    <!-- <div class="popup" id="popup">
                        <?php echo '
                        <img src="'.BASEURL.'/public/img/tick.png" alt="tick img" class="img"> ';
                        ?>
                       
                        <p>Your vehicle successfully added!!</p>
                        <button type="button" onclick="closePopup();">OK</button>
                    </div> -->
        </div>
        </section>
</section>

<?php
$footer = new Footer("distributor");
?>