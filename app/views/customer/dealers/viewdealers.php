<?php
$header = new Header("customer/view_dealers");
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new Body('allmyreservation', $data);
        
    ?>

    <div class="under_topbar">
        <div class="subtitle">
            <h3>Dealers</h3>
        </div>

         <!-- drop down -->
         <div class="drop_down">
            <div class="brand_dropdown">
                <select name="brand" id="brand" class="branddropdown dropdowndate" >
                    <option value="-1" selected disabled hidden>Select Gas Brand</option>
                    <?php 

                        if(isset($data["brands"])){
                            $result1 = $data["brands"];
                            while($brands = mysqli_fetch_assoc($result1)){           
                                $name = $brands["name"];
                                echo "<option value = $name> $name </option>";
                            }
                        }
                    ?>
            
                </select>

            </div>
            <div class="city_drapdown">
                
                <select name="brand" id="brand" class="citydropdown dropdowndate" >
                    <option value="-1" selected disabled hidden>Select City</option>
                    <?php 
                        $cities = ['Navala', 'Rajagiriya', 'Angoda', 'Athurugiriya', 'Battaramulla', 'Biyagama', 'Boralesgamuwa', 'Dehiwala', 'Kadawatha', 'Kelaniya', 'Kaduwela', 'Kalubowila', 'Kandana', 'Kesbewa', 'Kiribathgoda', 'Kolonnawa', 'Koswatte', 'Kotikawatta', 'Kottawa', 'Gothatuwa', 'Hokandara', 'Homagama', 'Ja-Ela', 'Maharagama', 'Malabe', 'Moratuwa', 'Mount Lavinia', 'Pannipitiya', 'Pelawatte', 'Peliyagoda', 'Piliyandala', 'Ragama', 'Ratmalana', 'Thalawathugoda', 'Wattala'];
                        sort($cities);              
                        foreach (CITIES as $city){
                            echo "<option value=$city>$city</option>";
                        }
                    ?>
                   
            
                </select>
            </div>
         </div>
        
         <!-- table -->
         <div class="table">
                <table>
                    <tr id="first_row"><th>Dealer</th><th>Brand</th><th>Street</th><th>Contact No</th><th></th></tr>
                    <?php

                        if(isset($data["dealers"])){
                            $result = $data["dealers"];
                            while($dealer = mysqli_fetch_assoc($result)){
                                    $url = BASEURL.'/profile/preview/dealer/'.$dealer['dealer_id'].'/profile/customer/viewdealerprofile';
                                    echo ' <tr><td>'.$dealer["d_name"].'</td><td>'.$dealer["c_name"].'</td><td>'.$dealer["address"].'</td><td>'.$dealer["contact_no"].'</td><td><button type="submit" class="More_details" onclick = "location.href=\''.$url.'\'">More Details</button></td></tr>';
                            }
                       
                        }
                    ?>
                   
                    </table>
                    
                </div>

        
        
    </div>
    
</section>

<?php
$footer = new Footer();
?>