<?php
$header = new Header("vehicles");
$sidebar = new Navigation('distributor',$data['navigation']);

$user_id = $_SESSION['user_id'];
 ?>

<section class="body">
    <?php 
    // call the default header for your interface
    $bodyheader = new BodyHeader($data);
    ?>
 
    <section class="body-content">
        <h2>Vehicles</h2>

        <?php 
          $result = new Vehicles_Comp("view");
        ?>

        <div class="main2">
            <?php
             echo "Your Vehicles' Details : ".'<br><br>'; 

                $output = '
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Vehicle Number</th>
                            <th>Vehicle Type (axels)</th>
                            <th>Fuel Consumption (L/Km) </th>
                            <th>Availability</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>';
                
                $vehicles = $data['vehicles'];

                foreach($vehicles as $vehicle){
                    $row2 = $vehicle['vehicleinfo'];
                    $capacities = $vehicle['capacities'];
                    $output .= '
                                <tr>
                                    <td>'.$row2['vehicle_no'].'</td>
                                    <td>'.$row2['type'].'</td>';
                    //                 <td><table class="table2">
                    //                     <tr>
                    //                         <th>Product Name</th>
                    //                         <th>Capacity</th>
                    //                     </tr>';
                    // foreach($capacities as $capacity){
                    //     $row3 = $capacity;
                    //     $output .= '
                    //                     <tr>
                    //                         <td>'.$row3['product_name'].'</td>
                    //                         <td>'.$row3['capacity'].'</td>
                    //                     </tr>
                    //                 ';
                    // }
                    // $output .= '</table></td>
                                    $output .= '
                                            <td>'.$row2['fuel_consumption'].' L</td>
                                            <td>'.$row2['availability'].'</td>';
                                if($row2['availability'] == 'No'|| $row2['availability'] == 'NO' || $row2['availability'] == 'no' ){
                                    // $output .= '<td><button type="button" class="btn4" style="background-color: B4AAFF" onclick="document.location.href=\''/BASEURL.'/vehicles/releasing/'.$row2['vehicle_no'].'\'">Release</button></td>';
                                    $output .= '<td><button type="button" class="btn4" style="background-color: B4AAFF" onclick="document.location.href=\''.BASEURL.'/vehicles/releasing/'.$row2['vehicle_no'].'\'">Release</button></td>';
                                }else{
                                    // $output .= '<td><button type="button" class="btn4" style="background-color: red" onclick="deleteVehicle('.$row2['vehicle_no'].')";">Remove</button></td>';
                                    $output .= '<td><button type="button" class="btn4" style="background-color: red" onclick="document.location.href=\''.BASEURL .'/vehicles/removeVehicle/'.$row2['vehicle_no'].'\'">Remove</button></td>';
                                }
                                $output .= '<td><button type="button" class="btn4" style="background-color: #9c6109" onclick="document.location.href=\''.BASEURL .'/vehicles/updateVehiclePage/'.$row2['vehicle_no'].'\'">Update</button></td>';                                                              
                                
                                $output .=  '
                                        </tr>';
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