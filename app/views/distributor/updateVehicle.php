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
                echo "Your Vehicle List :".'<br><br>';

                $output = '<table class="table1">
                <tr>
                    <th>Vehicle Number</th>
                
                </tr>';

                $vehicles = $data['vehicles'];
                foreach($vehicles as $vehicle) {
                    $row1 = $vehicle['listinfo'];
                
                    $output .= '<tr>
                                    <td>'.$row1['number'].'</td>
                                    <td><button class="btn3">Select</button></td>
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

