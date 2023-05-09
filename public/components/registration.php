<?php

class Registration{

    public function __construct($user_role, $data){
        $this->$user_role($data);
    }

    public function dealer($data){
        echo '<div class="container">
        <div class="wrapper">
            <div class="logo">
                <img src="'.BASEURL.'/public/img/login.png" alt="company logo">
            </div>
            <div class="form">
                <form method="post" enctype="multipart/form-data" action="'.BASEURL.'/signup/dealersignup">
                    <h1>Signup</h1>
                    
                    <div>
                        
                        <div class="info">
                            <label for="" class="part">Personal Info</label>
                            <input name="name" type="text" placeholder="Business name" required><br>
                            <div class="address owner">
                                <input name="fname" class="half" type="text" placeholder="First name" required>
                                <input name="lname" class="half" type="text" placeholder="Last name" required><br>
                            </div>
                            <input name="email" type="text" placeholder="Email address" required><br>

                            <div class="address">
                                
                                <select id="city" name="city" class="half">
                                    <option value="-1" selected disabled hidden>Select your city</option>';
                                     
                                        foreach (CITIES as $city){
                                            echo "<option value=$city>$city</option>";
                                        }

                                echo '</select>
                                <input name="street" class="half" type="text" placeholder="Address Street" required>
                            </div>

                            <input name="contactno" type="text" placeholder="Contact number" maxlength="10">
                            <div class="address bank">
                                <select id="city2" name="bank" class="half">
                                    <option value="-1" selected disabled hidden>Select your Bank</option>';

                                        foreach (BANKS as $bank){
                                            echo "<option value=$bank>$bank</option>";
                                        }

                                echo '</select>
                                <input name="branch" class="half" type="text" placeholder="Bank Branch" required><br>
                            </div>
                            <input name="account_no" class="half" type="number" placeholder="Bank Account No" required><br>

                            <label for="image">
                                <svg width="20" height="20" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M29.0299 2.44482H5.69661C3.85567 2.44482 2.36328 3.93721 2.36328 5.77816V29.1115C2.36328 30.9524 3.85567 32.4448 5.69661 32.4448H29.0299C30.8709 32.4448 32.3633 30.9524 32.3633 29.1115V5.77816C32.3633 3.93721 30.8709 2.44482 29.0299 2.44482Z" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11.5303 14.1113C12.911 14.1113 14.0303 12.992 14.0303 11.6113C14.0303 10.2306 12.911 9.11133 11.5303 9.11133C10.1496 9.11133 9.03027 10.2306 9.03027 11.6113C9.03027 12.992 10.1496 14.1113 11.5303 14.1113Z" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M32.363 22.4447L24.0296 14.1113L5.69629 32.4447" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                &nbsp; Upload your photo
                            </label>
                            <input name="image" id="image" type="file" value="Upload Your Image">
                            
                            <label for="" class="part">Store Capacity</label>
                            <div class="capacity">';
                                    $result = $data['productresult'];
                                    while($product = mysqli_fetch_assoc($result)){
                                        $productid = $product['product_id'];
                                        $productname = $product['name'];
                                        echo '<div class="span">
                                                    <p>'.$productname.' :</p>
                                                    <input class="half" name="'.$productid.'" type="number" min=0 placeholder="Store Capacity">
                                                </div>';
                                    }

                            echo '</div>
                            
                            <select id="distributor_id" name="distributor">
                                <option value="-1" selected disabled hidden>Select a distributor</option>';
                                
                                    $result = $data['distributorresult'];
                                    while($distributor = mysqli_fetch_assoc($result)){
                                        $distributor_id = $distributor['distributor_id'];
                                        $distributor_city = $distributor['city'];
                                        $distributor_name = $distributor['first_name'].' '.$distributor['last_name'];
                                        $option = "$distributor_city - $distributor_name";
                                        echo "<option value=$distributor_id>$option</option>";
                                    } 
                                
                            echo '</select>
                        </div>
                    </div>
                    <button type="submit" name="submit"onsubmit="main();">Register</button><br>
                </form>
            </div>
        </div>
    </div>';
    }

    public function customer($data){
        echo '<div class="container">
        <div class="wrapper">
            <div class="logo">
                <img src="'.BASEURL.'/public/img/login.png" alt="company logo">
            </div>
            <div class="form">
                <form method="post" enctype="multipart/form-data" action="'.BASEURL.'/signup/customersignup">
                    <h1>Signup</h1>
                    <div>
                        
                        <div class="info">
                                <label for="" class="part">Personal Info</label>
                                <div class="address owner">
                                    <input name="fname" class="half" type="text" placeholder="First name" required>
                                    <input name="lname" class="half" type="text" placeholder="Last name" required><br>
                                </div>
                                <input name="email" type="text" placeholder="Email address" required><br>

                                <div class="address password">
                                    <input name="password" class="half" type="password" placeholder="Password" required><br>
                                    <input name="confirmpassword" class="half" type="password" placeholder="Confirm password" required><br>
                                </div>

                                <div class="address">
                                    
                                    <select id="city" name="city" class="half">
                                        <option value="-1" selected disabled hidden>Select your city</option>';
                                        
                                            foreach (CITIES as $city){
                                                echo "<option value=$city>$city</option>";
                                            }
                                        
                                    echo '</select>
                                    <input name="street" class="half" type="text" placeholder="Address Street" required>
                                </div>

                                <input name="contactno" type="text" placeholder="Contact number" maxlength="10">
                                <input type="text" placeholder="Electricity Bill Number" name="ebill" required maxlength="10">

                                <label for="image">
                                    <svg width="20" height="20" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M29.0299 2.44482H5.69661C3.85567 2.44482 2.36328 3.93721 2.36328 5.77816V29.1115C2.36328 30.9524 3.85567 32.4448 5.69661 32.4448H29.0299C30.8709 32.4448 32.3633 30.9524 32.3633 29.1115V5.77816C32.3633 3.93721 30.8709 2.44482 29.0299 2.44482Z" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M11.5303 14.1113C12.911 14.1113 14.0303 12.992 14.0303 11.6113C14.0303 10.2306 12.911 9.11133 11.5303 9.11133C10.1496 9.11133 9.03027 10.2306 9.03027 11.6113C9.03027 12.992 10.1496 14.1113 11.5303 14.1113Z" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M32.363 22.4447L24.0296 14.1113L5.69629 32.4447" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    &nbsp; Upload your photo
                                </label>
                                <input name="image" id="image" type="file" value="Upload Your Image">
                                
                                <div class="selecttype">
                                    <div class="tiltle"><label>Type:</label></div>
                                    <div class="radio">
                                        <div>
                                            <input type="radio" value="Domestic" id="Domestic" name="cus_type" class="radio_input" >
                                            <label for="Domestic">Domestic</label>
                                        
            
                                        </div>
                                        <div>
                                            
                                            <input type="radio" value="Small Scale Business" id="Small_scale"  name="cus_type" class="radio_input" >
                                            <label for="Small_scale">Small Scale Business</label>
                                        </div>
                                        <div>
                                            
                                            <input type="radio" value="Large Scale Business" id="Large_scale"  name="cus_type" class="radio_input">
                                            <label for="Large_scale">Large Scale Business</label>
                                        </div>
                                    </div> 
                                </div>

                  

                        </div>
                       
                    </div>
                    <button type="submit" name="submit"onsubmit="main(); ">Register</button><br>
                    <p>Already Registered? <a href="'.BASEURL.'/signin/user">Login now</a></p>
                
                </form>
            </div>
        </div>
    </div>';
    }

    public function distributor($data){
        echo '<div class="container">
        <div class="wrapper">
            <div class="logo">
                <img src="'.BASEURL.'/public/img/login.png" alt="company logo">
            </div>
            <div class="form">
                <form action="'.BASEURL.'/signup/distributorsignup" method="post" enctype="multipart/form-data">
                    <h1>Signup</h1>
                    <div> 
                        <div class="info">
                            <label for="" class="part">Personal Info</label>

                            <div class="address owner">
                                <input name="fname" class="half" type="text" placeholder="First name" required>
                                <input name="lname" class="half" type="text" placeholder="Last name" required><br>
                            </div>

                            <input name="email" type="text" placeholder="Email address" required><br>

                            <input name="contact" type="text" placeholder="Contact Number" maxlength="10" required><br>

                            <div class="address">
                                
                                <select id="city" name="city" class="half">
                                    <option value="-1" selected disabled hidden>Select your city</option>';
                                    
                                        foreach (CITIES as $city){
                                            echo "<option value=$city>$city</option>";
                                        }
                                    
                                echo '</select>

                                <input name="street" class="half" type="text" placeholder="Street" required>
                            </div>

                            <label>Yard Capacity</label>
                                <div class="capacity">';
                                    
                                    $result = $data['productresult'];
                                    while($product = mysqli_fetch_assoc($result)) {
                                        $productid = $product['product_id'];
                                        $productname = $product['name'];
                                        echo '<div class="span"> 
                                                <p>'.$productname.':</p>
                                                <input class="half" name="'.$productid.'" type= "number" min="0" placeholder="store capacity">
                                            </div>';
                                    }
                                    
                                echo '</div>

                            <label for="image">
                                <svg width="20" height="20" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M29.0299 2.44482H5.69661C3.85567 2.44482 2.36328 3.93721 2.36328 5.77816V29.1115C2.36328 30.9524 3.85567 32.4448 5.69661 32.4448H29.0299C30.8709 32.4448 32.3633 30.9524 32.3633 29.1115V5.77816C32.3633 3.93721 30.8709 2.44482 29.0299 2.44482Z" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11.5303 14.1113C12.911 14.1113 14.0303 12.992 14.0303 11.6113C14.0303 10.2306 12.911 9.11133 11.5303 9.11133C10.1496 9.11133 9.03027 10.2306 9.03027 11.6113C9.03027 12.992 10.1496 14.1113 11.5303 14.1113Z" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M32.363 22.4447L24.0296 14.1113L5.69629 32.4447" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                &nbsp; Upload your photo
                            </label>
                            <input name="image" id="image" type="file" value="Upload Your Image">
                            
                        </div>
                    </div>

                    <button type="submit" name="submit" onsubmit="main();">Register</button><br>
                </form>
            </div>
        </div>
    </div>';
    }

    public function company($data){
        echo '<div class="container">
        <div class="wrapper">
            <div class="logo">
                <img src="'.BASEURL.'/public/img/login.png" alt="company logo">
            </div>
            <div class="form" >
                <form action="'.BASEURL.'/signup/companySignUp" method="post" enctype="multipart/form-data" id="companySignUp" class="companySignUp">
                    <h1>Signup</h1>
                        <p></p>
                        <a>
                        <svg width="25" height="25" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.6682 32.2388C25.9525 32.2388 32.6682 25.523 32.6682 17.2388C32.6682 8.9545 25.9525 2.23877 17.6682 2.23877C9.38391 2.23877 2.66818 8.9545 2.66818 17.2388C2.66818 25.523 9.38391 32.2388 17.6682 32.2388Z" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22.1682 12.7388L13.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.1682 12.7388L22.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        </a>
                    <div style="margin-bottom:0%">
                        
                        <div class="info">
                            <label for="" class="part">Company Info</label>
                            <div class="address owner">
                                <input name="Companyname" type="text" placeholder="Company name" id="companyname"required>
                            </div>
                            <div id="companynameerr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                            <div class="address password">
                                <input name="fname" class="half" type="text" placeholder="First name" style="width:42.5%;margin-right:0px" id="fname"required><br>
                                <input name="lname" class="half" type="text" placeholder="Last name" style="width:42.5%;margin-right:0px;margin-left:5%" id="lname" required><br>
                            </div>
                            <div class="address password">
                                <div id="fnameerr" style="width:42.5%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                                <div id="lnameerr" style="width:42.5%;margin-right:0px;margin-left:5%;text-align:center;color:red;font-size:smaller"></div>
                            </div>
                            <input name="email" type="email" placeholder="Email address" id="email" required><br>
                            <div id="emailerr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>

                            <div class="address password">
                                <input name="password" class="half" type="password" placeholder="Password" style="width:42.5%;margin-right:0px" id="password" required><br>
                                <input name="confirmpassword" class="half" type="password" placeholder="Confirm password" style="width:42.5%;margin-right:0px;margin-left:5%" id="confirmpassword" required><br>
                            </div>
                            <div id="passworderr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                            <div class="address">
                                    <select id="city" name="city" class="half" data-dropup-auto="false" style="width:42.5%;margin-right:0px">
                                        <option  value="-1" selected disabled hidden>Select your city</option>';
                                        
                                            foreach (CITIES as $city){
                                                echo "<option value=$city>$city</option>";
                                            }
                                        
                                    echo '</select>
                                <input name="street" id="street" class="half" type="text" placeholder="Street" style="width:42.5%;margin-right:0px;margin-left:5%" required>
                            </div>
                            <div id="addresserr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                            <label for="image">
                                <svg width="20" height="20" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M29.0299 2.44482H5.69661C3.85567 2.44482 2.36328 3.93721 2.36328 5.77816V29.1115C2.36328 30.9524 3.85567 32.4448 5.69661 32.4448H29.0299C30.8709 32.4448 32.3633 30.9524 32.3633 29.1115V5.77816C32.3633 3.93721 30.8709 2.44482 29.0299 2.44482Z" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11.5303 14.1113C12.911 14.1113 14.0303 12.992 14.0303 11.6113C14.0303 10.2306 12.911 9.11133 11.5303 9.11133C10.1496 9.11133 9.03027 10.2306 9.03027 11.6113C9.03027 12.992 10.1496 14.1113 11.5303 14.1113Z" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M32.363 22.4447L24.0296 14.1113L5.69629 32.4447" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                &nbsp; Upload your photo
                            </label>
                            <input name="image" id="image" type="file" value="Upload Company logo">
                            <div class="address password">
                            <div id="imageerr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                            </div>
                        </div>
                    </div>
                    <input type="button" name="Sign Up" value="Sign Up" class="submit" onClick="CompanySignUp()" style="background-color: var(--button-blue);font-family: \'Poppins\', sans-serif;font-size:1.1em;color:white;cursor:pointer"><br>
                    <p>Already Registered? <a href="'.BASEURL.'/signin/user" style="font-family: \'Poppins\', sans-serif">Login now</a></p>
                </form>
            </div>
        </div>
    </div>';
    }

    public function delivery($data){
        echo '<div class="container">
        <div class="wrapper">
            <div class="logo">
                <img src="'.BASEURL.'/public/img/login.png" alt="company logo">
            </div>
            <div class="form" >
                <form action="'.BASEURL.'/signup/DeliverySignup" method="post" enctype="multipart/form-data" id="deliverySignUp" class="companySignUp">
                    <h1>Signup</h1>
                        <p></p>
                        <a>
                        <svg width="25" height="25" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.6682 32.2388C25.9525 32.2388 32.6682 25.523 32.6682 17.2388C32.6682 8.9545 25.9525 2.23877 17.6682 2.23877C9.38391 2.23877 2.66818 8.9545 2.66818 17.2388C2.66818 25.523 9.38391 32.2388 17.6682 32.2388Z" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22.1682 12.7388L13.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.1682 12.7388L22.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        </a>
                    <div style="margin-bottom:0%">
                        
                        <div class="info">
                            <label for="" class="part">Delivery person Info</label>
                            <div class="address password">
                                <input name="fname" class="half" type="text" placeholder="First name" style="width:42.5%;margin-right:0px" id="fname" required><br>
                                <input name="lname" class="half" type="text" placeholder="Last name" style="width:42.5%;margin-right:0px;margin-left:5%" id="lname" required><br>
                            </div>
                            <div class="address password">
                                <div id="fnameerr" style="width:42.5%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                                <div id="lnameerr" style="width:42.5%;margin-right:0px;margin-left:5%;text-align:center;color:red;font-size:smaller"></div>
                            </div>
                            <input name="email" type="text" placeholder="Email address" id="email" required><br>
                            <div id="emailerr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                            <input name="cno" type="text" placeholder="Contact no" id="cno" required><br>
                            <div id="cnoerr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                            <div class="address password">
                                <input name="password" class="half" type="password" placeholder="Password" style="width:42.5%;margin-right:0px" id="password" required><br>
                                <input name="confirmpassword" class="half" type="password" placeholder="Confirm password" style="width:42.5%;margin-right:0px;margin-left:5%" id="confirmpassword" required><br>
                            </div>
                            <div id="passworderr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                            <div class="address">
                                    <select id="city" name="city" class="half" data-dropup-auto="false" style="width:42.5%;margin-right:0px">
                                        <option value="-1" selected disabled hidden>Select your city</option>';

                                        foreach (CITIES as $city){
                                                echo "<option value=$city>$city</option>";
                                            }

                            echo '</select>
                                <input id="street" name="street" class="half" type="text" placeholder="Street" style="width:42.5%;margin-right:0px;margin-left:5%" required>
                            </div>
                            <div id="addresserr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                            <label for="image">
                                <svg width="20" height="20" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M29.0299 2.44482H5.69661C3.85567 2.44482 2.36328 3.93721 2.36328 5.77816V29.1115C2.36328 30.9524 3.85567 32.4448 5.69661 32.4448H29.0299C30.8709 32.4448 32.3633 30.9524 32.3633 29.1115V5.77816C32.3633 3.93721 30.8709 2.44482 29.0299 2.44482Z" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11.5303 14.1113C12.911 14.1113 14.0303 12.992 14.0303 11.6113C14.0303 10.2306 12.911 9.11133 11.5303 9.11133C10.1496 9.11133 9.03027 10.2306 9.03027 11.6113C9.03027 12.992 10.1496 14.1113 11.5303 14.1113Z" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M32.363 22.4447L24.0296 14.1113L5.69629 32.4447" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                &nbsp; Upload your photo
                            </label>
                            <input name="image" id="image" type="file" value="Upload Company logo">
                            <div id="imageerr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                            <label for="" class="part">Vehicle Info</label>
                            <div class="address password">
                            <select id="vtype" name="vehicletype" class="half" style="width:42.5%;margin-right:0px">
                                        <option value="-1" selected disabled hidden>Select vehicle type</option>';
                                        
                                            foreach (VEHICLES as $city){
                                                echo "<option value=$city>$city</option>";
                                            }
                                        
                                    echo '</select>
                                <input id="vno" name="vno" class="half" type="text" placeholder="Vehicle no" style="width:42.5%;margin-right:0px;margin-left:5%" required><br>
                            </div>
                            <div class="address password">
                                <div id="vtypeerr" style="width:42.5%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                                <div id="vnoerr" style="width:42.5%;margin-right:0px;margin-left:5%;text-align:center;color:red;font-size:smaller"></div>
                            </div>
                            <div class="address password">
                                <input id="weight" name="weight" class="half" type="text" placeholder="Weight limit" style="width:42.5%;margin-right:0px" required><br>
                                <input id="costperkm" name="costperkm" class="half" type="text" placeholder="Cost per KM" style="width:42.5%;margin-right:0px;margin-left:5%" required><br>
                            </div>
                            <div class="address password">
                                <div id="weighterr" style="width:42.5%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                                <div id="costperkmerr" style="width:42.5%;margin-right:0px;margin-left:5%;text-align:center;color:red;font-size:smaller"></div>
                            </div>
                        </div>
                            
                    </div>
                    <input type="button" name="Sign Up" value="Sign Up" class="submit" onClick="DeliverySignUp()" style="background-color: var(--button-blue);font-family: \'Poppins\', sans-serif;font-size:1.1em;color:white;cursor:pointer"><br>
                    <p>Already Registered? <a href="'.BASEURL.'/signin/user" style="font-family: \'Poppins\', sans-serif">Login now</a></p>
                </form>
            </div>
        </div>
    </div>';
    }
}