<?php
$header = new Header("vehicles");
$sidebar = new Navigation('distributor', $data['navigation']);
$user_id = $_SESSION['user_id'];
?>

<section class="body">
    <?php 
    // call the default header for your interface
    $bodyheader = new BodyHeader($data);
    ?>
 
    <section class="body-content">
        <h2>Suitable Vehicles for Gas Orders</h2>

        <?php 
        //   $result = new Vehicles_Comp("view");
        ?>

        <div class="main2">
            <?php
             echo "Vehicles List: ".'<br><br>'; 

                $output = '
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Vehicle Number</th>
                            <th>Vehicle Type(axels)</th>
                            <th>Fuel Consumption(L/Km)</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                $vehicles = $data['suitablevehiclelist'];

                foreach($vehicles as $vehicle){
                    $row2 = $vehicle['vehicleinfo'];
                    $capacities = $vehicle['capacities'];
                    $output .= '
                                <tr>
                                    <td>'.$row2['vehicle_no'].'</td>
                                    <td>'.$row2['type'].' </td>
                                    <td>'.$row2['fuel_consumption'].' L</td>';
                                    $output .= '<td><button type="button" style="background-color: B4AAFF class="btn4" onclick="document.location.href=\''.BASEURL.'/orders/dis_placed_pending\'">Assign</button></td>';                             
                                $output .=  '
                                </tr>';
                }
            
                $output .= '
                    </tbody>
                </table>';
                echo $output;
            ?>
        </div>
    </section>
</section>


<?php
$footer = new Footer();
?>

