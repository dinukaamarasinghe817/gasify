<?php
    // session_start();
    // if(isset($_SESSION['unique_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'dealer'){
    //     header('Location: dashboard.php');
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>/public/css/login.css">
    <title>Gasify Dealer</title>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div class="logo">
                <img src="<?php echo BASEURL; ?>/public/img/login.png" alt="company logo">
            </div>
            <div class="form">
                <form method="post" enctype="multipart/form-data" action="<?php echo BASEURL;?>/signup/dealersignup">
                    <h1>Signup</h1>
                    <?php
                        // echo $data['error'];
                        if(isset($data['error']) && $data['error'] != 'success'){
                            $base = BASEURL;
                            echo '<div class="error-txt">
                                    <p>'.$data['error'].'</p>
                                    <a onclick="errorclose();">
                                    <svg width="25" height="25" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.6682 32.2388C25.9525 32.2388 32.6682 25.523 32.6682 17.2388C32.6682 8.9545 25.9525 2.23877 17.6682 2.23877C9.38391 2.23877 2.66818 8.9545 2.66818 17.2388C2.66818 25.523 9.38391 32.2388 17.6682 32.2388Z" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M22.1682 12.7388L13.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.1682 12.7388L22.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    </a>
                                </div>
                                <script src="'.BASEURL.'/public/js/Dealer/signup.js"></script>';
                        }
                    ?>
                    
                    <div>
                        
                        <div class="info">
                            <label for="" class="part">Personal Info</label>
                            <input name="name" type="text" placeholder="Business name" ><br>
                            <input name="email" type="text" placeholder="Email address" ><br>

                            <div class="address password">
                                <input name="password" class="half" type="password" placeholder="Password" ><br>
                                <input name="confirmpassword" class="half" type="password" placeholder="Confirm password" ><br>
                            </div>

                            <div class="address">
                                
                                    <select id="city" name="city" class="half">
                                        <option value="-1" selected disabled hidden>Select your city</option>
                                        <?php 
                                            $cities = ['Navala', 'Rajagiriya', 'Angoda', 'Athurugiriya', 'Battaramulla', 'Biyagama', 'Boralesgamuwa', 'Dehiwala', 'Kadawatha', 'Kelaniya', 'Kaduwela', 'Kalubowila', 'Kandana', 'Kesbewa', 'Kiribathgoda', 'Kolonnawa', 'Koswatte', 'Kotikawatta', 'Kottawa', 'Gothatuwa', 'Hokandara', 'Homagama', 'Ja-Ela', 'Maharagama', 'Malabe', 'Moratuwa', 'Mount Lavinia', 'Pannipitiya', 'Pelawatte', 'Peliyagoda', 'Piliyandala', 'Ragama', 'Ratmalana', 'Thalawathugoda', 'Wattala'];
                                            sort($cities);
                                            foreach ($cities as $city){
                                                echo "<option value=$city>$city</option>";
                                            }
                                        ?>
                                    </select>
                                <input name="street" class="half" type="text" placeholder="Address Street" >
                            </div>

                            <input name="contactno" type="text" placeholder="Contact number" maxlength="10">
                            <input class="acc_no" name="acc_no" type="number" placeholder="Payhere Merchant ID">

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
                            <div class="capacity">
                                <?php
                                    // include_once "../../model/Dealer/products.php";
                                    // echo var_dump($data['productresult']);
                                    if(isset($data['productresult'])){
                                        $productresult = $data['productresult'];
                                        while($product = mysqli_fetch_assoc($productresult)){
                                        // foreach(productresult as $product){
                                            $productid = $product['product_id'];
                                            $productname = $product['name'];
                                            echo '<div class="span">
                                                        <p>'.$productname.' :</p>
                                                        <input class="half" name="'.$productid.'" type="number" min=0 placeholder="Store Capacity">
                                                    </div>';
                                        }
                                    }
                                ?>
                            </div>
                            
                            <select id="distributor_id" name="distributor">
                                <option value="-1" selected disabled hidden>Select a distributor</option>
                                <?php 
                                    // include_once "../../model/Dealer/distributors.php";
                                    if(isset($data['distributorresult'])){
                                        $distributorresult = $data['distributorresult'];
                                        while($distributor = mysqli_fetch_assoc($distributorresult)){
                                            $distributor_id = $distributor['distributor_id'];
                                            $distributor_city = $distributor['city'];
                                            $distributor_firstname = $distributor['first_name'];
                                            $distributor_lastname = $distributor['last_name'];
                                            $option = "$distributor_city - $distributor_firstname $distributor_lastname";
                                            echo "<option value=$distributor_id>$option</option>";
                                        } 
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- <input type="submit" name='submit'> -->
                    <button type="submit" name="submit"onsubmit="main();">Register</button><br>
                    <p>Already Registered? <a href="<?php echo BASEURL;?>/signin/dealer">Login now</a></p>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>