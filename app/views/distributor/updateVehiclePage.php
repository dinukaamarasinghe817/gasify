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
            // $products = $data['products'];
            // $row1 = $products['productinfo'];
            
            // $number = $row1['vehicle_no'];
            $upproducts = $data['updateproduct'];
            $vehicle_no = $upproducts['vehicle_no'];
            echo "Vehicle Number : $vehicle_no ".'<br><br>';

            ?>

            <form action="<?php echo BASEURL;?>/vehicles/updateVehicle/<?php echo $vehicle_no ?>" method="POST">

            <?php 
                $output = '';
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
                        <tbody>


                        
                        ';

                    
                    $upproducts = $data['updateproduct'];
                    $products = $upproducts['products'];
                    // echo count($products);
                    foreach($products as $product) {
                        $row1 = $product;
                        // $capacities = $product['capacities'];
                      
                        $output .= '
                            <tr>
                                <td>'.$row1['product_name'].'</td>
                                <td><input type="number" name="'.$row1['product_id'].'" value='.$row1['capacity'].' min=0 required></td>
                            </tr>';
                    }
                    $output .= '
                    
                        </tbody>
                    </table>

                    <label>Fuel Consumption :</label>
                    <input type="number" name="fuel" value='.$upproducts['fuel_consumption'].' min=0 required>
                </div>

                <div class="beginbtn">
                    <button class="btn3" name="update" type="submit" onclick="document.location.href=\''.BASEURL .'/vehicles/viewvehicle\'"><b>Update</b></button>
                </div>
                </form>';
                echo $output;
            
            ?>


               
          
             
            

        </div>
    </section>
</section>

<?php
$footer = new Footer();
?>