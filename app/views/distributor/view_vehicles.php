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

        <?php
        echo "Your Distributor ID - $user_id".'<br><br>';
        echo "Your Vehicles' Details : "; 
        
        ?>

        <div class="main2">
            <!-- <table class="table1">
                <tr>
                    <th>Vehicle Number</th>
                    <th>Vehicle Type</th>
                    <th>Weight Limit</th>
                    <th>Fuel Consumption</th>
                    <th>Availability</th>
                    <th></th>
                </tr>
            </table> -->
            <?php

                $output = '<table class="table1">
                <tr>
                <th>Vehicle Number</th>
                <th>Vehicle Type</th>
                <th>Weight Limit</th>
                <th>Fuel Consumption</th>
                <th>Availability</th>
                <th></th>
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
                                    $output .= '<td><button class="btn4" style="background-color: B4AAFF;"><b>Release</b></button></td>';
                                }else{
                                    $output .= '<td><button type="button" class="btn4" onclick="deleteVehicle('.$row2['vehicle_no'].')" style="background-color: red;"><b>Remove</b></button></td>';
                                }
                                $output .=  '
                                        </tr>';
                }
                // if(mysqli_num_rows($query)>0) {
                //     $row = mysqli_fetch_assoc($query);
            
                //     // $query2=mysqli_query($conn, "SELECT * FROM distributor_vehicle WHERE distributor_id = '{$dis_id}' ");
                //     $query2= $data['query2'];
            
                //     if(mysqli_num_rows($query2)>0) {
                //         while($row2 = mysqli_fetch_assoc($query2)) {
                //             $vehicle_no = $row2['vehicle_no'];
                            
                //             // get the details from product details
                //             // $query3 = mysqli_query($conn, "SELECT * FROM product WHERE company_id = '{$row['company_id']}' and product_id = '{$product_id}'");
                //             $query3 = mysqli_query($conn, "SELECT DISTINCT d.capacity AS capacity, p.name AS product_name FROM distributor_vehicle_capacity d INNER JOIN product p ON d.product_id = p.product_id WHERE d.distributor_id = '{$dis_id}' AND d.vehicle_no = '{$vehicle_no}'");
            
                //             if(mysqli_num_rows($query3)>0) {
                //                 $output .= '<tr>
                //                                 <td>'.$vehicle_no.'</td>
                //                                 <td>'.$row2['type'].'</td>
                //                                 <td>
                //                                 <table class="table2">
                //                                     <tr>
                //                                         <th>Product Name</th>
                //                                         <th>Capacity</th>
                //                                     </tr>';
                                                
                //                 while($row3 = mysqli_fetch_assoc($query3)){
                //                     $output .= '
                //                         <tr>
                //                             <td>'.$row3['product_name'].'</td>
                //                             <td>'.$row3['capacity'].'</td>
                //                         </tr>
                //                     ';
                //                 }
            
                //                 $output .= '</table>
                //                             </td>
                //                             <td>'.$row2['fuel_consumption'].'</td>
                //                             <td>'.$row2['availability'].'</td>
                //                             ';
                //                 if($row2['availability'] == 'No'|| $row2['availability'] == 'NO' || $row2['availability'] == 'no' ){
                //                     $output .= '<td><button class="btn4" style="background-color: B4AAFF;"><b>Release</b></button></td>';
                //                 }else{
                //                     $output .= '<td><button type="button" class="btn4" onclick="deleteVehicle('.$vehicle_no.')" style="background-color: red;"><b>Remove</b></button></td>';
                //                 }
                //                 $output .=  '
                //                         </tr>';                            
                //             }
                //         }
                //     }
                // }
            
                $output .= '</table>';
                echo $output;
            ?>
        </div>
    </section>
</section>

<?php
$footer = new Footer();
?>