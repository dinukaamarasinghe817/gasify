<?php
$header = new Header("customer/view_dealers");
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        $bodyheader = new BodyHeader($data);
    ?>

    <div class="under_topbar">
        <div class="subtitle">
            <h3>Dealers</h3>
        </div>
        <!-- drop downs -->
        <div class="drop_down">
            <!-- brand dropdown -->
            <div class="brand_dropdown">
                <select name="brand" id="brand" class="branddropdown dropdowndate" onchange="get_select_value('brand','city');">
                    <!-- Default display all brands -->
                    <option value="-1" selected>All Brands</option>
                    <?php 
                        // take all gas companies from database and display in dropdown
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
            <!-- city dropdown -->
            <div class="city_drapdown">
                <select name="city" id="city" class="citydropdown dropdowndate" onchange="get_select_value('brand','city');">
                    <!--Display defualt city as customer home city  -->
                    <option value="<?php echo $data['mycity'];?>" selected hidden ><?php echo $data['mycity'];?></option>
                    <option value = "-1" >All Cities</option></option>
                    <?php 
                        //take colombo district cities in created array in functions.php              
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
                        //if no dealers found selected city and brand
                        if(mysqli_num_rows($result)==0){
                            echo ' <tr><td></td><td></td><td><strong>No Dealers Found!</strong></td><td></td><td></td></tr>';
                        }
                        //display all relevant Dealers
                        while($dealer = mysqli_fetch_assoc($result)){   
                            //dealer profile details  
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
            var brand_selected_value = document.getElementById(branddropdown_id).value; //get  selected brand from dropdown(company_id)
            var city_selected_value = document.getElementById(citydropdown_id).value; // get selected city from dropdown
          
            console.log(brand_selected_value);
            console.log(city_selected_value);
            
            event.preventDefault();
            var formData = new FormData();
            let xhr = new XMLHttpRequest(); //new xml object
            //call controller function with parameters(company_id,city)
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