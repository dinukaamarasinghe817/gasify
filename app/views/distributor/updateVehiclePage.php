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
          $result = new Vehicles_Comp("view");
        ?>

        <div class="main2">
            <?php
            $upproducts = $data['updateproduct'];
            $vehicle_no = $upproducts['vehicle_no'];
            echo "Vehicle Number : $vehicle_no ".'<br><br>';

            ?>

            <form action="<?php echo BASEURL;?>/vehicles/updateVehicle/<?php echo $vehicle_no ?>" method="POST">

            <?php 
                $output = '
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

                    
                    $upproducts = $data['updateproduct'];
                    $products = $upproducts['products'];
                    foreach($products as $product) {
                        $row1 = $product;                      
                        $output .= '
                            <tr>
                                <td>'.$row1['product_name'].'</td>
                                <td><input type="number" name="'.$row1['product_id'].'" value='.$row1['capacity'].' min=0 required disabled></td>
                            </tr>';
                    }
                    $output .= '
                    
                        </tbody>
                    </table>

                    <label>Fuel Consumption (L/Km) :</label>
                    <input type="number" name="fuel" value='.$upproducts['fuel_consumption'].' min=0 required>
                </div>

                <div class="beginbtn">
                    <button class="btn3 edit" name="update" onclick="edit();"><b>Edit</b></button>
                    <div class="back"><a href="'.BASEURL.'/vehicles/viewvehicle" >Back</a></div>
                </div>
                
                </form>';
                echo $output;
            
            ?>


               
          
             
            

        </div>
    </section>
</section>

<script>

    document.querySelector("form").addEventListener("submit", function(event) {
        event.preventDefault(); // prevent default form submission behavior
    });

    function edit(){
        let btn = document.querySelector('form .beginbtn');
        btn.querySelector('button.edit').onclick = function(){
            console.log("clicked");
            btn.innerHTML = `<button class="btn3" name="update" type="submit" onclick="this.form.submit()"><b>Update</b></button>`;
            let inputs = document.querySelectorAll('form input');
            for(var i = 0; i < inputs.length; i++){
                inputs[i].disabled = false;
            }
        }
    }

</script>

<?php
$footer = new Footer();
?>