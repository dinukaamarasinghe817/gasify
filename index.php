<?php
//include_once 'model/main.php';
    session_start();
    if(isset($_SESSION['unique_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'dealer'){
        header('Location: view/Dealer/dashboard.php');
    }else if(isset($_SESSION['customer_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'customer'){
        header('Location: view/Customer/dashboard.php');
    }else if(isset($_SESSION['distributor_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'distributor'){
        header('Location: view/Distributor/dashboard.php');
    }else if(isset($_SESSION['userID']) && isset($_SESSION['role']) && $_SESSION['role'] == 'company'){
        header('Location: view/Company/delivery.php');
    }else if(isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
        header('Location: view/Admin/dashboard.php');
    }else if(isset($_SESSION['userID']) && isset($_SESSION['role']) && $_SESSION['role'] == 'delivery'){
        header('Location: view/Delivery/delivery.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gasify</title>
    <link rel="icon" href="public/icons/favicon.ico">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section id="header">
        <a href="#"><img src="public/img/logo.png" class="logo" alt="logo"></a>

        <div>
            <ul id="navbar">
                <li><a href="#" class="active">Home</a></li>
                <li><a href="#">fsdsfdsfds</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>

        <div >
            <ul id="signup">
                <li><a href="signin.php">Login</a></li>
                <li><a href="signup.php">Signup</a></li>
            </ul>
        </div>
    </section>

    <section id="hero">
        <h4>Place your reservation</h4>
        <h2>with latest price</h2>
        <h1>On all products</h1>
        <p>Save your valuable time with online reservation!</p>
        <button>Shop Now</button>
    </section>

    <section id="feature" class="section-p1">
        <h2>Our Services</h2>
        <p>It's All About Your Satisfaction</p>
        <div class="fe-container">
            <div class="fe-box">
                <img src="public/img/features/f2.png" alt="">
                <h6>Home Delivery</h6>
            </div>
            <div class="fe-box">
                <img src="public/img/features/f5.png" alt="">
                <h6>Happy Sell</h6>
            </div>
            <div class="fe-box">
                <img src="public/img/features/f4.png" alt="">
                <h6>Card/Slip Payments</h6>
            </div>
            <div class="fe-box">
                <img src="public/img/features/f1.png" alt="">
                <h6>Early Notifications</h6>
            </div>
            <div class="fe-box">
                <img src="public/img/features/f3.png" alt="">
                <h6>Save Money</h6>
            </div>
            <div class="fe-box">
                <img src="public/img/features/f6.png" alt="">
                <h6>24/7 Support</h6>
            </div>
        </div>
    </section>

    <section id="tx-banner">
        <div class="banner-box">
            <h1>2+</h1>
            <h2>Major Brands</h2>
            <button class="details">Details</button>
        </div>
        <div class="banner-box">
            <h1>12+</h1>
            <h2>Distribution Points</h2>
            <button class="details">Details</button>
        </div>
        <div class="banner-box">
            <h1>112+</h1>
            <h2>Dealer Points</h2>
            <button class="details">Details</button>
        </div>
        <!-- <section id="tx-banner-content"> -->
            <div class="info">
                <button>X</button>
                <table>
                        <tr>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Address</th>
                        </tr>
                        <?php
                        $companies = $data['company'];
                        foreach($companies as $company){
                            echo '
                            <tr>
                                <td>'.$company["name"].'</td>
                                <td>'.$company["email"].'</td>
                                <td>'.$company["address"].'</td>
                            </tr>
                            ';
                        }
                        ?>
                </table>
            </div>
            <div class="info">
                <button>X</button>
                <table>
                        <tr>
                            <th>Distributor Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Address</th>
                        </tr>
                        <?php
                        $distributors = $data['distributor'];
                        foreach($distributors as $distributor){
                            echo '
                            <tr>
                                <td>'.$distributor["name"].'</td>
                                <td>'.$distributor["email"].'</td>
                                <td>'.$distributor["contact"].'</td>
                                <td>'.$distributor["address"].'</td>
                            </tr>
                            ';
                        }
                        ?>
                </table>
            </div>
            <div class="info">
                <button>X</button>
                <table>
                        <tr>
                            <th>Dealer Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Address</th>
                        </tr>
                        <?php
                        $dealers = $data['dealer'];
                        foreach($dealers as $dealer){
                            echo '
                            <tr>
                                <td>'.$dealer["name"].'</td>
                                <td>'.$dealer["email"].'</td>
                                <td>'.$dealer["contact"].'</td>
                                <td>'.$dealer["address"].'</td>
                            </tr>
                            ';
                        }
                        ?>
                </table>
            </div>
        <!-- </section> -->
    </section>


    <section id="product" class="section-p1">
        <h2>Featured Products</h2>
        <p>Summer Collection New Modern Design</p>
        <div class="pro-container">
            <div class="pro">
                <img src="public/img/products/f1.png" alt="">
                <div class="des">
                    <span>litro</span>
                    <h5>Buddy 2.3 Kg (Re-fill)</h5>
                    <!-- <div class="star">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                    </div> -->
                    <div class="star">(22) sold</div>
                    <h4>Rs. 815.00</h4>
                </div>
            </div>
            <div class="pro">
                <img src="public/img/products/f2.png" alt="">
                <div class="des">
                    <span>litro</span>
                    <h5>Budget 5 Kg (Re-fill)</h5>
                    <!-- <div class="star">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                    </div> -->
                    <div class="star">(22) sold</div>
                    <h4>Rs. 1750.00</h4>
                </div>
            </div>
            <div class="pro">
                <img src="public/img/products/f3.png" alt="">
                <div class="des">
                    <span>litro</span>
                    <h5>Regular 12.5 Kg (Re-fill)</h5>
                    <!-- <div class="star">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                    </div> -->
                    <div class="star">(22) sold</div>
                    <h4>Rs. 4360.00</h4>
                </div>
            </div>
            <div class="pro">
                <img src="public/img/products/f4.png" alt="">
                <div class="des">
                    <span>litro</span>
                    <h5>Regulator Pack</h5>
                    <!-- <div class="star">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                    </div> -->
                    <div class="star">(22) sold</div>
                    <h4>Rs. 1875.00</h4>
                </div>
            </div>
            <div class="pro">
                <img src="public/img/products/f5.png" alt="">
                <div class="des">
                    <span>laugfs</span>
                    <h5>Buddy 2 Kg (Re-fill)</h5>
                    <!-- <div class="star">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                    </div> -->
                    <div class="star">(22) sold</div>
                    <h4>Rs. 795.00</h4>
                </div>
            </div>
            <div class="pro">
                <img src="public/img/products/f6.png" alt="">
                <div class="des">
                    <span>laugfs</span>
                    <h5>Budget 5 Kg (Re-fill)</h5>
                    <!-- <div class="star">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                    </div> -->
                    <div class="star">(22) sold</div>
                    <h4>Rs. 2120.00</h4>
                </div>
            </div>
            <div class="pro">
                <img src="public/img/products/f7.png" alt="">
                <div class="des">
                    <span>laugfs</span>
                    <h5>Regular 12.5 Kg (Re-fill)</h5>
                    <!-- <div class="star">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                    </div> -->
                    <div class="star">(22) sold</div>
                    <h4>Rs. 5300.00</h4>
                </div>
            </div>
            <div class="pro">
                <img src="public/img/products/f8.png" alt="">
                <div class="des">
                    <span>laugfs</span>
                    <h5>Regulator Pack</h5>
                    <!-- <div class="star">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                        <img src="public/icons/star.svg" alt="">
                    </div> -->
                    <div class="star">(22) sold</div>
                    <h4>Rs. 2810.00</h4>
                </div>
            </div>
        </div>
    </section>

    <section id="banner" class="section-m1">
        <h4>Refund Services</h4>
        <h2> <span>80% </span> ~ Money back guarantee on cancellation</h2>
        <button class="normal">Explore More</button>
    </section>

    <section id="sm-banner" class="section-p1">
        <div class="banner-box">
            <h4>trusted delivery,</h4>
            <h2># home delivery</h2>
            <span>Just place the order and wait to here your door bell</span>
            <button class="transparent">Learn More</button>
        </div>
        <div class="banner-box">
            <h4>your preference,</h4>
            <h2># pickup facilities</h2>
            <span>Just place the order and collect whenever you free</span>
            <button class="transparent">Learn More</button>
        </div>
        <div class="info">
            <ul>
                <li></li>
            </ul>
        </div>
    </section>

    <section id="newsletter" class="section-p1 section-m1">
        <div class="newsletter">
            <h4>Sign Up For Newsletters</h4>
            <p>Get E-mail updates about out latest shop and <span>special offers.</span></p>
        </div>
        <div class="form">
            <input type="email" placeholder="Your E-mail address">
            <button class="normal">Signup</button>
        </div>
    </section>

    <footer class="section-p1">
        <div class="col">
            <img src="public/img/logo.png" class="logo" alt="">
            <h4>Contact</h4>
            <p><strong>Address: </strong> 43 Highlevel Road, Godagama, Homagama</p>
            <p><strong>Phone: </strong> +94 112 175 268 / +94 714 872 852</p>
            <p><strong>Hours: </strong> 10:00 - 16:00, Mon - Fri</p>
            <div class="follow">
                <h4>Follow us</h4>
                <div class="icon">
                    <img src="public/icons/facebook.svg" alt="">
                    <img src="public/icons/instagram.svg" alt="">
                    <img src="public/icons/twitter.svg" alt="">
                    <img src="public/icons/linkedin.svg" alt="">
                </div>
            </div>
        </div>

        <div class="col">
            <h4>About</h4>
            <a href="#">About us</a>
            <a href="#">Delivery Information</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Contact Us</a>
        </div>

        <div class="col install">
            <h4>Install App</h4>
            <p>From App Store or Google Play</p>
            <div class="row">
                <img src="public/img/pay/app.jpg" alt="">
                <img src="public/img/pay/play.jpg" alt="">
            </div>
            <p>Secured Payment Gateways</p>
            <img src="public/img/pay/pay.png" alt="">
        </div>

        <div class="copyright">
            <p>© 2022, University of Colombo, School of Computing</p>
        </div>
    </footer>
    <script>
        
        let bannerbox = document.querySelectorAll('#tx-banner .banner-box .details');
        let bannercontent = document.querySelectorAll('#tx-banner .info');

        // console.log(bannerbox);

        bannerbox.forEach((banner, index)=>{
            banner.addEventListener('click', function(event){
                // bannercontent[index].style.display = 'flex';
                bannercontent[index].classList.add('active');
            });
        });

        bannercontent.forEach(function (banner){
            let close = banner.querySelector('button');
            close.addEventListener('click', function(){
                banner.style.display = 'none';
                banner.classList.remove('active');
                banner.style.display = 'flex';
            });
        });
        

    </script>
</body> 
</html>