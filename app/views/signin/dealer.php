<?php
    // session_start();
    // if(isset($_SESSION['unique_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'dealer'){
    //     header('Location: home/index');
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASEURL ?>/public/css/login.css">
    <title>Gasify Dealer</title>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div class="logo">
                <img src="<?php echo BASEURL; ?>/public/img/login.png" alt="company logo">
            </div>
            <div class="form">
                <form action="<?php echo BASEURL;?>/signin/dealersignin" method="post">
                    <h1>Login</h1>
                    <?php 
                        if(isset($data['error']) && $data['error'] != 'success'){
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
                    
                    <div class="info">
                    <input name="email" type="text" placeholder="Email Address"><br>
                    <input name="password" type="password" placeholder="Password"><br>
                    <p class="forgotpwd" ><a href = "forgotpwd.php" >Forgot password?</a><br></p>
                    </div>
                    <button type="submit" name="submit">Login</button><br>
                    <p>Not Registered? <a href="<?php echo BASEURL;?>/signup/dealer">Create Account</a></p>
                </form>
            </div>
        </div>
    </div>
    <script src="<?php echo BASEURL;?>/public/js/Dealer/signin.js"></script>
</body>
</html>