<?php
    // if(isset($data['toast'])){
    //     $error = new Prompt('toast',$data['toast']);
    //     echo '<script>
    //         showToast();
    //     </script>';
    // }
    $header = new Header("login",$data);
?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>/public/css/login.css">
    <title>Gasify Customer</title>
</head>
<body> -->
    <div class="container">
        <div class="wrapper">
            <div class="logo">
                <img src="<?php echo BASEURL; ?>/public/img/login.png" alt="company logo">
            </div>
            <div class="form">
                <form method="post" enctype="multipart/form-data" action="<?php echo BASEURL;?>/signup/customersignup">
                    <h1>Signup</h1>
                    <div>
                        
                        <div class="info">
                                <label for="" class="part">Personal Info</label>
                                <!-- <input name="name" type="text" placeholder="Name" required><br> -->
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
                                        <option value="-1" selected disabled hidden>Select your city</option>
                                        <?php 
                                            // include_once '../../model/functions/functions.php';
                                            foreach (CITIES as $city){
                                                echo "<option value=$city>$city</option>";
                                            }
                                        ?>
                                    </select>
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
                    <!-- <input type="submit" name='submit'> -->
                    <button type="submit" name="submit"onsubmit="main(); ">Register</button><br>
                    <p>Already Registered? <a href="<?php echo BASEURL;?>/signin/user">Login now</a></p>
                
                </form>
            </div>
        </div>
    </div>
    

<?php
$footer = new Footer("signin");
?>