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
          $result = new Vehicles_Comp("update");
        ?>

        <div class="main2">
            <?php
            $products = $data['products'];
            // foreach($products as $product) {
                $row1 = $product['productinfo'];
              
            // }
            
            $number = $row1['vehicle_no'];
            echo "Vehicle Number : $number ".'<br><br>';
            // echo "Vehicle Number :  ".'<br><br>';

            ?>

            <form action="<?php echo BASEURL;?>/vehicles/updateVehiclePage" method="POST">

            <?php 
                echo '
                <div class="part1">
                    <label>Weight Limit: </label>
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Capacity</th>
                            </tr>
                        </thead>
                        <tbody>';
                    
                    $products = $data['products'];
                    foreach($products as $product) {
                        $row1 = $product['productinfo'];
                        $row2 = $product['newcapacities'];
                        $output = '
                            <tr>
                                <td>'.$row1['product_id'].'</td>
                                <td><input type="number" name="capacity" value='.$row2['capacity'].' min=0 required></td>
                            </tr>';
                    }
                    $output .= '
                        </tbody>
                    </table>

                    <label>Fuel Consumption :</label>
                    <input type="number" name="fuel" min=0 required>
                </div>
            </form>

                <div class="beginbtn">
                    <button class="btn3" name="update" onclick="document.location.href=\''.BASEURL .'/vehicles/viewvehicle\'"><b>Update</b></button>
                </div>';
                echo $output;
            
            ?>


               
          
             
            

        </div>
    </section>
</section>

<?php
$footer = new Footer();
?>