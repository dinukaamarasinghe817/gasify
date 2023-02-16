<?php

$header = new Header("customer/customer_brand_city_dealer",$data);
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        if(isset($data['toast'])){
            $error = new Prompt('toast',$data['toast']);

        }
    ?>

    <div class="under_topbar">
        <div class="subtitle">
           <h3>Place Reservation</h3>
        </div> 
        <div class="middle">
            <form action="<?php echo BASEURL; ?>/Orders/get_brand_city_dealer" method="post">
                <div class="top">
                    <div class="brand">
                        <div class="img">
                            <svg width="106" height="166" viewBox="0 0 106 166" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M53 99.6C38.9435 99.6 25.4628 94.3532 15.5233 85.0139C5.58391 75.6746 0 63.0078 0 49.8C0 36.5922 5.58391 23.9254 15.5233 14.5861C25.4628 5.24677 38.9435 0 53 0C67.0565 0 80.5372 5.24677 90.4767 14.5861C100.416 23.9254 106 36.5922 106 49.8C106 63.0078 100.416 75.6746 90.4767 85.0139C80.5372 94.3532 67.0565 99.6 53 99.6ZM53 74.7C60.0282 74.7 66.7686 72.0766 71.7383 67.407C76.708 62.7373 79.5 56.4039 79.5 49.8C79.5 43.1961 76.708 36.8627 71.7383 32.193C66.7686 27.5234 60.0282 24.9 53 24.9C45.9718 24.9 39.2314 27.5234 34.2617 32.193C29.292 36.8627 26.5 43.1961 26.5 49.8C26.5 56.4039 29.292 62.7373 34.2617 67.407C39.2314 72.0766 45.9718 74.7 53 74.7ZM88.3333 97.525V166L53 132.8L17.6667 166V97.525C28.0205 104.343 40.357 108 53 108C65.643 108 77.9795 104.343 88.3333 97.525Z" fill=""/>
                            </svg>
                        </div>
                        <div class="title">Brand</div>
                        <div class="drop-down">
                            <div class="brand_dropdown">
                                <select name="brand" id="brand" class="branddropdown dropdowndate" onchange = "get_select_value('brand','city','dealer');">
                                    <option value="-1" selected disabled hidden>Select Gas Brand</option>
                                    <?php 

                                        if(isset($data["brands"])){
                                            $result1 = $data["brands"];
                                            while($brands = mysqli_fetch_assoc($result1)){           
                                                $name = $brands["name"];
                                                $c_id = $brands["company_id"];

                                                echo "<option class = 'company_id' value = $c_id id= $c_id> $name </option>";
                                            }
                                        }
                                    ?>
                            
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="city">
                        <div class="img">
                            <svg width="106" height="166" viewBox="0 0 106 154" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M53 154C53 154 0 83.699 0 53.9C-1.03713e-07 46.8218 1.37089 39.8128 4.03439 33.2734C6.69788 26.7339 10.6018 20.792 15.5233 15.7869C20.4448 10.7819 26.2875 6.81162 32.7178 4.10289C39.148 1.39416 46.0399 0 53 0C59.9601 0 66.852 1.39416 73.2822 4.10289C79.7125 6.81162 85.5552 10.7819 90.4767 15.7869C95.3982 20.792 99.3021 26.7339 101.966 33.2734C104.629 39.8128 106 46.8218 106 53.9C106 83.699 53 154 53 154ZM53 69.3C57.0161 69.3 60.8678 67.6775 63.7076 64.7894C66.5475 61.9014 68.1429 57.9843 68.1429 53.9C68.1429 49.8157 66.5475 45.8986 63.7076 43.0106C60.8678 40.1225 57.0161 38.5 53 38.5C48.9839 38.5 45.1322 40.1225 42.2924 43.0106C39.4525 45.8986 37.8571 49.8157 37.8571 53.9C37.8571 57.9843 39.4525 61.9014 42.2924 64.7894C45.1322 67.6775 48.9839 69.3 53 69.3Z" fill=""/>
                            </svg>
                        </div>
                        <div class="title">City</div>
                        <div class="drop-down">
                            <div class="city_drapdown">
                                <select name="city" id="city" class="citydropdown dropdowndate" onchange = "get_select_value('brand','city','dealer');">
                                <?php
                                    if(isset($data["city"])){
                                        $result1 = $data["city"];
                                        while($customer_city = mysqli_fetch_assoc($result1)){           
                                            $customer_current_city = $customer_city["city"];
                                            echo "<option value = '$customer_current_city' id=$customer_current_city selected hidden>$customer_current_city</option>";
                                        }
                                    }
                                    
                                    
                                        // $cities = ['Navala', 'Rajagiriya', 'Angoda', 'Athurugiriya', 'Battaramulla', 'Biyagama', 'Boralesgamuwa', 'Dehiwala', 'Kadawatha', 'Kelaniya', 'Kaduwela', 'Kalubowila', 'Kandana', 'Kesbewa', 'Kiribathgoda', 'Kolonnawa', 'Koswatte', 'Kotikawatta', 'Kottawa', 'Gothatuwa', 'Hokandara', 'Homagama', 'Ja-Ela', 'Maharagama', 'Malabe', 'Moratuwa', 'Mount Lavinia', 'Pannipitiya', 'Pelawatte', 'Peliyagoda', 'Piliyandala', 'Ragama', 'Ratmalana', 'Thalawathugoda', 'Wattala'];
                                        // sort($cities);              
                                        foreach (CITIES as $city){
                                        if($city != $data['city']){

                                                echo "<option value=$city id=$city >$city</option>";
                                        }
                                        }
                                    ?>
                                
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="dealer">
                        <div class="img">
                            <svg width="106" height="166" viewBox="0 0 124 111" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M31 27.75C31 20.3902 34.2661 13.3319 40.0797 8.12779C45.8933 2.92365 53.7783 0 62 0C70.2217 0 78.1067 2.92365 83.9203 8.12779C89.7339 13.3319 93 20.3902 93 27.75V38.85C93 46.2098 89.7339 53.2681 83.9203 58.4722C78.1067 63.6763 70.2217 66.6 62 66.6C53.7783 66.6 45.8933 63.6763 40.0797 58.4722C34.2661 53.2681 31 46.2098 31 38.85V27.75ZM0 92.574C18.8388 82.8063 40.2293 77.6746 62 77.7C84.568 77.7 105.772 83.0835 124 92.574V111H0V92.574Z" fill=""/>
                            </svg>
                        </div>
                        <div class="title">Dealer</div>
                        <div class="drop-down">
                            <div class="dealer_dropdown">
                                <select name="dealer" id="dealer" class="dealerdropdown dropdowndate" onchange = "get_dealer_value('dealer');">
                                    <option value="-1" selected disabled hidden>Select Dealer</option>
                                    <?php 

                                        if(isset($data["dealers"])){
                                            $result1 = $data["dealers"];
                                            
                                            while($dealers = mysqli_fetch_assoc($result1)){ 
                                                $name = $dealers["d_name"];
                                                $dealer_id = $dealers["dealer_id"];
                                                echo "<option value = $dealer_id id= $dealer_id> $name </option>";
                                            }

                                            
                                        }
                                    ?>
                            
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bottom">
                    <button type="submit" class="btn">Next</button>
                </div>
                
                
            </form>
        </div>

        <!-- <div class="bottom"> -->
            
            <!-- <a href="<?php echo BASEURL; ?>/Products/select_products" class="btn">Next</a> -->
            <!-- <button type="submit" onclick="check_values('brand','city','dealer');">Next</button> -->
        <!-- </div> -->
        
    </div>


    <script>

        const page = document.querySelector('.dealer');
        const middle = document.querySelector('body');


        function get_select_value(branddropdown_id=null,citydropdown_id=null,dealerdropdown_id=null){

            var brand_selected_value = document.getElementById(branddropdown_id).value;
            var city_selected_value = document.getElementById(citydropdown_id).value;
            var dealer_selected_value = document.getElementById(dealerdropdown_id).value;

            if (brand_selected_value == -1){
                brand_selected_value = null;

            }
            if (dealer_selected_value == -1){
                dealer_selected_value = null;
                
            }

            // console.log(brand_selected_value);
            // console.log(city_selected_value);
            // console.log(dealer_selected_value);
            
            event.preventDefault();
            var formData = new FormData();
            let xhr = new XMLHttpRequest(); //new xml object
            var url = 'http://localhost/mvc/Orders/filter_dealers/'+brand_selected_value +'/' + city_selected_value + '/' + dealer_selected_value;
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

        function get_dealer_value(dealerdropdown_id = null){
            var dealer_selected_value = document.getElementById(dealerdropdown_id).value;
            if (dealer_selected_value == -1){
                dealer_selected_value = null;
            }
            console.log(dealer_selected_value);

        }
        


        // function check_values(branddropdown_id=null,citydropdown_id=null,dealerdropdown_id=null){
        //     var brand_selected_value = document.getElementById(branddropdown_id).id;
        //     var city_selected_value = document.getElementById(citydropdown_id).value;
        //     var dealer_selected_value = document.getElementById(dealerdropdown_id).value;

        //     event.preventDefault();
        //     var formData = new FormData();
        //     let xhr = new XMLHttpRequest(); //new xml object
        //     var url = 'http://localhost/mvc/Products/select_products/'+brand_selected_value;
        //     console.log(url);
        //     xhr.open('POST', url , true);
        //     xhr.onload = ()=>{
        //         if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
        //              let data = xhr.response;
        //         if(data){
        //              middle.innerHTML = data;
    
        //         }
        //         }
        //     }
        //     xhr.send(formData);
        // }

       

        

    </script>
</section>