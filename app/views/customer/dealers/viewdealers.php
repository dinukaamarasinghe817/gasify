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
                <select name="brand" id="brand" class="branddropdown dropdowndate" onchange="get_select_value('brand','city');">
                    <option value="-1" selected disabled hidden >Select Gas Brand</option>
                    <?php 

                        if(isset($data["brands"])){
                            $result1 = $data["brands"];
                            while($brands = mysqli_fetch_assoc($result1)){           
                                $name = $brands["name"];
                                $company_id = $brands["company_id"];
                                echo "<option value = $company_id > $name </option>";
                            }
                        }
                    ?>
            
                </select>

            </div>
            <div class="city_drapdown">
                
                <select name="city" id="city" class="citydropdown dropdowndate" onchange="get_select_value('brand','city');">
                    <option value="<?php echo $data['mycity'];?>" selected hidden ><?php echo $data['mycity'];?></option>
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
            <table class="styled-table">
                <thead><tr id="first_row"><th>Dealer</th><th>Brand</th><th>Street</th><th>Contact No</th><th></th></tr></thead><tbody>
                <?php

                    if(isset($data["dealers"])){
                        $result = $data["dealers"];
                        while($dealer = mysqli_fetch_assoc($result)){
                                $url = BASEURL.'/profile/preview/dealer/'.$dealer['dealer_id'].'/profile/customer/viewdealerprofile';
                                echo ' <tr><td>'.$dealer["d_name"].'</td><td>'.$dealer["c_name"].'</td><td>'.$dealer["address"].'</td><td>'.$dealer["contact_no"].'</td><td><button type="submit" class="More_details" onclick = "location.href=\''.$url.'\'">More Details</button></td></tr>';
                        }
                    
                    }
                ?>
                </tbody>   
            </table>
        </div>

        
        
    </div>



    <script>
        const page = document.querySelector('.table table');
       
        function get_select_value(branddropdown_id=null,citydropdown_id=null){
            var brand_selected_value = document.getElementById(branddropdown_id).value;
            var city_selected_value = document.getElementById(citydropdown_id).value;
           

            if (city_selected_value == -1){
                city_selected_value = null;
                
            }
            if (brand_selected_value == -1){
                brand_selected_value = null;

            }

            console.log(brand_selected_value);
            console.log(city_selected_value);
            
            event.preventDefault();
            var formData = new FormData();
            let xhr = new XMLHttpRequest(); //new xml object
            var url = 'http://localhost/mvc/Dealers/selected_brand_dealers/'+ brand_selected_value +'/' + city_selected_value;
            console.log(url);
            xhr.open('POST', url , true);
            xhr.onload = ()=>{
                if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
                     let data = xhr.response;
                if(data){
                     page.innerHTML = data;
    
                }
                }
            }
            xhr.send(formData);
            

}


    </script>
    
</section>

<?php
$footer = new Footer();
?>