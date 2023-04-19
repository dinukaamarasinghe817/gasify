<?php
    // if(isset($data['toast'])){
    //     $error = new Prompt('toast',$data['toast']);
    //     echo '<script>
    //         showToast();
    //     </script>';
    // }
    $header = new Header("login",$data);
?>
    <div class="container">
        <div class="wrapper">
            <div class="logo">
                <img src="<?php echo BASEURL; ?>/public/img/login.png" alt="company logo">
            </div>
            <div class="form" >
                <form action="#" method="post" enctype="multipart/form-data" id="companySignUp" class="companySignUp">
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
                                <input name="Companyname" type="text" placeholder="Company name" required>
                            </div>
                            <div class="address password">
                                <input name="fname" class="half" type="text" placeholder="First name" style="width:42.5%;margin-right:0px" required><br>
                                <input name="lname" class="half" type="text" placeholder="Last name" style="width:42.5%;margin-right:0px;margin-left:5%" required><br>
                            </div>
                            <input name="email" type="text" placeholder="Email address" required><br>

                            <div class="address password">
                                <input name="password" class="half" type="password" placeholder="Password" style="width:42.5%;margin-right:0px" required><br>
                                <input name="confirmpassword" class="half" type="password" placeholder="Confirm password" style="width:42.5%;margin-right:0px;margin-left:5%" required><br>
                            </div>
                            <div class="address">
                                    <select id="city" name="city" class="half" data-dropup-auto="false" style="width:42.5%;margin-right:0px">
                                        <option value="-1" selected disabled hidden>Select your city</option>
                                        <?php 
                                            // include_once '../../model/functions/functions.php';
                                            foreach (CITIES as $city){
                                                echo "<option value=$city>$city</option>";
                                            }
                                        ?>
                                    </select>
                                <input name="street" class="half" type="text" placeholder="Street" style="width:42.5%;margin-right:0px;margin-left:5%" required>
                            </div>
                            <label for="image">
                                <svg width="20" height="20" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M29.0299 2.44482H5.69661C3.85567 2.44482 2.36328 3.93721 2.36328 5.77816V29.1115C2.36328 30.9524 3.85567 32.4448 5.69661 32.4448H29.0299C30.8709 32.4448 32.3633 30.9524 32.3633 29.1115V5.77816C32.3633 3.93721 30.8709 2.44482 29.0299 2.44482Z" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11.5303 14.1113C12.911 14.1113 14.0303 12.992 14.0303 11.6113C14.0303 10.2306 12.911 9.11133 11.5303 9.11133C10.1496 9.11133 9.03027 10.2306 9.03027 11.6113C9.03027 12.992 10.1496 14.1113 11.5303 14.1113Z" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M32.363 22.4447L24.0296 14.1113L5.69629 32.4447" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                &nbsp; Upload your photo
                            </label>
                            <input name="imageupload" id="image" type="file" value="Upload Company logo">
                            
                        </div>
                    </div>
                    <input type="submit" name="Sign Up" value="Sign Up" class="submit" onClick="CompanySignUp()" style="background-color: var(--button-blue);font-family: 'Poppins', sans-serif;font-size:1.1em;color:white;cursor:pointer"><br>
                    <p>Already Registered? <a href="login.php" style="font-family: 'Poppins', sans-serif">Login now</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="../../controller/Company/companyLogin.js"></script>
    
<?php
$footer = new Footer("signin");
?>
