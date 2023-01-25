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
                echo "Vehicle Number : ".'<br><br>';
            ?>

            <form>
                <div class="part1">
                    <label>Weight Limit</label>                    
                    <!-- <input type="number" name="capacity" required> -->
                    <?php 
                    $output = '
                        <table>
                            <tr>
                                <th>Product Name</th>
                                <th>Capacity</th>
                            </tr>';

                            $products = $data['product'];
                            echo(count($products));

                            foreach($products as $product) {
                               

                                $row1 = $product['productinfo'];
                                $output .= '
                                    <tr>
                                        <td>'.$row1['name'].'</td>
                                        <td>'.$row1['capacity'].'</td> 
                                    </tr>';         
                            }
                            $output .= '</table>';
                            echo $output;
                           
                    ?>

                </div>

                <div class="part1">
                    <label>Fuel Consumption</label>
                    <input type="number" name="fuel" required>
                </div>
            </form>

           

            <div class="beginbtn">
                <button class="btn3"><b>Update</b></button>
            </div>
                
        </div>
    </section>
</section>

<?php
$footer = new Footer();
?>

