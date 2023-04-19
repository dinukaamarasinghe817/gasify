<?php 
    // session_start();
    // if(isset($_SESSION['distributor_id']) && isset($_SESSION['role']) && $_SESSION['role']=='distributor') {
    //     header('Location: dashboard.php');
    //     // header('Location: ../../index.php');

    // }
    $header = new Header("login", $data); 
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link href="styles/register.css" rel="stylesheet">
    
    <title>Gasify Distributor Registration</title>
</head>
<body> -->
    <div class="container">
        <div class="wrapper">
            <div class="logo">
                <img src="images/img.jpg" alt="distributor photo">
            </div>
            <div class="form">
                <form action="<?php echo BASEURL;?>/signup/distributorsignup" method="post" enctype="multipart/form-data">
                    <h1>Signup</h1>
                    <!-- <div class="error-txt">
                        <p></p>
                        <a>
                        <svg width="25" height="25" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.6682 32.2388C25.9525 32.2388 32.6682 25.523 32.6682 17.2388C32.6682 8.9545 25.9525 2.23877 17.6682 2.23877C9.38391 2.23877 2.66818 8.9545 2.66818 17.2388C2.66818 25.523 9.38391 32.2388 17.6682 32.2388Z" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22.1682 12.7388L13.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.1682 12.7388L22.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        </a>
                    </div> -->

                    <div> 
                        <div class="info">
                            <!-- here comes all your inputs, I left some, so you can get an idea -->
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

                            <input name="contact" type="tel" placeholder="Contact Number" required><br>

                            <div class="address">
                                
                                <select id="city" name="city" class="half">
                                    <option value="-1" selected disabled hidden>Select your city</option>
                                    
                                    <?php 
                                        foreach (CITIES as $city){
                                            echo "<option value=$city>$city</option>";
                                        }
                                    ?> 
                                    
                                    <?php 
                                    // $city = ['Navala', 'Rajagiriya', 'Angoda', 'Athurugiriya', 'Battaramulla', 'Biyagama', 'Boralesgamuwa', 'Dehiwala', 'Kadawatha', 'Kelaniya', 'Kaduwela', 'Kalubowila', 'Kandana', 'Kesbewa', 'Kiribathgoda', 'Kolonnawa', 'Koswatte', 'Kotikawatta', 'Kottawa', 'Gothatuwa', 'Hokandara', 'Homagama', 'Ja-Ela', 'Maharagama', 'Malabe', 'Moratuwa', 'Mount Lavinia', 'Pannipitiya', 'Pelawatte', 'Peliyagoda', 'Piliyandala', 'Ragama', 'Ratmalana', 'Thalawathugoda', 'Wattala'];
                                    // sort($city);
                                    // foreach($city as $city) {
                                    //     echo "<option value = $city>$city</option>";
                                    // }
                                    ?>
                                </select>

                                <input name="street" class="half" type="text" placeholder="Street" required>
                            </div>

                            <!-- <div class="field"> -->
                            <label>Yard Capacity</label>
                                <div class="capacity">
                                    <?php 
                                        // include_once "../../model/distributor/products.php";
                                        // $result = $data['productresult'];
                                        // while($product = mysqli_fetch_assoc($result)) {
                                        //     $productid = $product['product_id'];
                                        //     $productname = $product['name'];
                                        //     echo '<div class="span"> 
                                        //             <p>'.$productname.':</p>
                                        //             <input class="half" name="'.$productid.'" type= "number" min="0" placeholder="store capacity">
                                        //         </div>';
                                        // }
                                        echo 'product name :
                                        <input class="half" placeholder="store capacity">
                                        '
                                    ?>
                                </div>
                            <!-- </div> -->

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
                    <p>Already Registered? <a href="<?php echo BASEURL;?>/signin/distributor">Login now</a></p>
                </form>
            </div>
        </div>
    </div>

<?php
$footer = new Footer("signin");
?>