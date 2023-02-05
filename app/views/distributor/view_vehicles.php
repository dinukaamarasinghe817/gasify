<?php
$header = new Header("vehicles");
$sidebar = new Navigation('distributor',$data['navigation']);

// session_start();
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
            //  echo "Your Distributor ID - $user_id".'<br><br>';
             echo "Your Vehicles' Details : ".'<br><br>'; 

                $output = '<table class="table1">
                <tr>
                    <th>Vehicle Number</th>
                    <th>Vehicle Type</th>
                    <th>Weight Limit</th>
                    <th>Fuel Consumption</th>
                    <th>Availability</th>
                   
                </tr>';
                // $query = mysqli_query($conn,"SELECT * FROM distributor_vehicle WHERE distributor_id = '{$dis_id}'");
                
                $vehicles = $data['vehicles'];

                foreach($vehicles as $vehicle){
                    $row2 = $vehicle['vehicleinfo'];
                    $capacities = $vehicle['capacities'];
                    $output .= '<tr>
                                    <td>'.$row2['vehicle_no'].'</td>
                                    <td>'.$row2['type'].'</td>
                                    <td>
                                    <table class="table2">
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Capacity</th>
                                        </tr>';
                    foreach($capacities as $capacity){
                        $row3 = $capacity;
                        $output .= '
                                        <tr>
                                            <td>'.$row3['product_name'].'</td>
                                            <td>'.$row3['capacity'].'</td>
                                        </tr>
                                    ';
                    }
                    $output .= '</table>
                                            </td>
                                            <td>'.$row2['fuel_consumption'].'</td>
                                            <td>'.$row2['availability'].'</td>
                                            ';
                                if($row2['availability'] == 'No'|| $row2['availability'] == 'NO' || $row2['availability'] == 'no' ){
                                    $output .= '<td><button type="button" class="btn4" style="background-color: B4AAFF;">Release</button></td>';
                                }else{
                                    $output .= '<td><button type="button" class="btn4" style="background-color: red" onclick="deleteVehicle('.$row2['vehicle_no'].')";">Remove</button></td>';
                                    // $output .= '<td><button type="button" class="btn4" style="background-color: red" onclick="document.location.href='../vehicles/removeVehicle';"><b>Remove</b></button></td>';
                                }
                                // $output .= '<td><button type="button" class="btn4" style="background-color: #875899" onclick="document.location.href="../vehicles/updateVehiclePage";">Update</button></td>';
                                $output .= '<td><button type="button" class="btn4" style="background-color: #9c6109";">Update</button></td>';
                                
                                $output .=  '
                                        </tr>';
                }
            
                $output .= '</table>';
                echo $output;
            ?>
        </div>
    </section>
</section>

<?php
$footer = new Footer();
?>