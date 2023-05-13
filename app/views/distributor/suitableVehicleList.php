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
                            <th>Fuel cost(L)</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                $vehicles = $data['suitablevehiclelist'];
                $po_id = $data['po_id'];
                // var_dump($vehicles);
                if(count($vehicles) > 0){
                    foreach($vehicles as $vehicle){
                        $row2 = $vehicle['vehicleinfo'];
                        $capacities = $vehicle['capacities'];
                        $output .= '
                                    <tr>
                                        <td>'.$row2['vehicle_no'].'</td>
                                        <td>'.$row2['type'].' </td>
                                        <td>'.$row2['cost'].' L</td>
                                        ';

                                    // if($row2['availability'] == 'No'|| $row2['availability'] == 'NO' || $row2['availability'] == 'no' ){
                                        $output .= '<td><button type="button" style="background-color: B4AAFF class="btn4" onclick="document.location.href=\''.BASEURL.'/orders/selectedVehicle/'.$po_id.'/'.$row2['vehicle_no'].'\'">Assign</button></td>';
                                    // }                              
                                    $output .=  '
                                            </tr>';
                    }
                }else{
                    $output .= '<tr><td colspan="4" style="text-align: center;">No vehicles found</td></tr>';
                }
            
                $output .= '</tbody></table>';
                echo $output;
            ?>
        </div>
    </section>
</section>


<?php
$footer = new Footer();
?>

