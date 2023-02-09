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
                echo "Vehicle Number : AX2103 ".'<br><br>';
            ?>

            <form>
                <div class="part1">
                    <label>Weight Limit</label>                    
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Capacity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Buddy (Refill)</td>
                                <td><input type="number" name="capacity" value=250 min=0 required></td>
                            </tr>
                            <tr>
                                <td>Budget (Refill)</td>
                                <td><input type="number" name="capacity" value=300 min=0 required></td>
                            </tr>
                            <tr>
                                <td>Regular (Refill)</td>
                                <td><input type="number" name="capacity" value=100 min=0 required></td>
                            </tr>
                        </tbody>
                    </table>

                    <?php 
                    // $output = '
                    //     <table>
                    //         <tr>
                    //             <th>Product Name</th>
                    //             <th>Capacity</th>
                    //         </tr>

                    //         <tr>';
                            
                            // $products = $data['product'];
                            // echo(count($products));

                            // foreach($products as $product) {
                               

                            //     $row1 = $product['productinfo'];
                            //     $output .= '
                            //         <tr>
                            //             <td>'.$row1['name'].'</td>
                            //             <td>'.$row1['capacity'].'</td> 
                            //         </tr>';         
                            // }
                            // $output .= '</table>';
                            // echo $output;    
                    ?>

                </div>

                <div class="part1">
                    <label>Fuel Consumption</label>
                    <input type="number" name="fuel" required>
                </div>
            </form>

            <div class="beginbtn">
                <!-- <button class="btn3" a href="<?php echo BASEURL?> /vehicles/viewvehicle"><b>Update</b></button> -->
                <button class="btn3"><b>Update</b></button>
            </div>
                
        </div>
    </section>
</section>

<?php
$footer = new Footer();
?>

