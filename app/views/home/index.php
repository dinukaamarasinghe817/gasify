<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gasify</title>
    <link rel="icon" href="$base/public/icons/favicon.ico">
    <link rel="stylesheet" href="<?php echo BASEURL?>/public/css/style.css">
</head>
<body>
    <section id="header">
        <a href="#"><img src="<?php echo BASEURL ?>/public/img/logo.png" class="logo" alt="logo"></a>

        <div>
            <ul id="navbar">
                <li><a href="#hero" class="active">Home</a></li>
                <li><a href="#product">Shop</a></li>
                <!-- <li><a href="blog.html">Blog</a></li> -->
                <!-- <li><a href="#footer">About</a></li> -->
                <li><a href="#footer">Contact Us</a></li>
            </ul>
        </div>

        <div >
            <ul id="signup">
                <li><a href="<?php echo BASEURL; ?>/signin/user">Login</a></li>
                <li><a href="<?php echo BASEURL; ?>/signup/user">Signup</a></li>
            </ul>
        </div>
    </section>

    <section id="hero">
    <h4>Place your reservation</h4>
        <h2>with latest price</h2>
        <h1>On all products</h1>
        <p>Save your valuable time with online reservation!</p>
        <button onclick="location.href='#product';">Shop Now</button>
    </section>

    <section id="feature" class="section-p1">
        <h2>Our Services</h2>
        <p>It's All About Your Satisfaction</p>
        <div class="fe-container">
            <div class="fe-box">
                <img src="<?php echo BASEURL ?>/public/img/features/f2.png" alt="">
                <h6>Home Delivery</h6>
            </div>
            <div class="fe-box">
                <img src="<?php echo BASEURL ?>/public/img/features/f5.png" alt="">
                <h6>Happy Sell</h6>
            </div>
            <div class="fe-box">
                <img src="<?php echo BASEURL ?>/public/img/features/f4.png" alt="">
                <h6>Card/Slip Payments</h6>
            </div>
            <div class="fe-box">
                <img src="<?php echo BASEURL ?>/public/img/features/f1.png" alt="">
                <h6>Early Notifications</h6>
            </div>
            <div class="fe-box">
                <img src="<?php echo BASEURL ?>/public/img/features/f3.png" alt="">
                <h6>Save Money</h6>
            </div>
            <div class="fe-box">
                <img src="<?php echo BASEURL ?>/public/img/features/f6.png" alt="">
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
        <p>All products of all brands with lates price</p>
        <div class="pro-container">
            <div class="pro">
                <img src="<?php echo BASEURL ?>/public/img/products/f1.png" alt="">
                <div class="des">
                    <span>litro</span>
                    <h5>Buddy 2.3 Kg (Re-fill)</h5>
                    <!-- <div class="star">
                        <img src="<?php echo BASEURL ?>/public/icons/star.svg" alt="">
                        <img src="<?php echo BASEURL ?>/public/icons/star.svg" alt="">
                        <img src="<?php echo BASEURL ?>/public/icons/star.svg" alt="">
                        <img src="<?php echo BASEURL ?>/public/icons/star.svg" alt="">
                        <img src="<?php echo BASEURL ?>/public/icons/star.svg" alt="">
                    </div> -->
                    <div class="star">(22) sold</div>
                    <h4>Rs. 815.00</h4>
                </div>
            </div>
            <div class="pro">
                <img src="<?php echo BASEURL ?>/public/img/products/f2.png" alt="">
                <div class="des">
                    <span>litro</span>
                    <h5>Budget 5 Kg (Re-fill)</h5>
                    <div class="star">(22) sold</div>
                    <h4>Rs. 1750.00</h4>
                </div>
            </div>
            <div class="pro">
                <img src="<?php echo BASEURL ?>/public/img/products/f3.png" alt="">
                <div class="des">
                    <span>litro</span>
                    <h5>Regular 12.5 Kg (Re-fill)</h5>
                    <div class="star">(22) sold</div>
                    <h4>Rs. 4360.00</h4>
                </div>
            </div>
            <div class="pro">
                <img src="<?php echo BASEURL ?>/public/img/products/f4.png" alt="">
                <div class="des">
                    <span>litro</span>
                    <h5>Regulator Pack</h5>
                    <div class="star">(22) sold</div>
                    <h4>Rs. 1875.00</h4>
                </div>
            </div>
            <div class="pro">
                <img src="<?php echo BASEURL ?>/public/img/products/f5.png" alt="">
                <div class="des">
                    <span>laugfs</span>
                    <h5>Buddy 2 Kg (Re-fill)</h5>
                    <div class="star">(22) sold</div>
                    <h4>Rs. 795.00</h4>
                </div>
            </div>
            <div class="pro">
                <img src="<?php echo BASEURL ?>/public/img/products/f6.png" alt="">
                <div class="des">
                    <span>laugfs</span>
                    <h5>Budget 5 Kg (Re-fill)</h5>
                    <div class="star">(22) sold</div>
                    <h4>Rs. 2120.00</h4>
                </div>
            </div>
            <div class="pro">
                <img src="<?php echo BASEURL ?>/public/img/products/f7.png" alt="">
                <div class="des">
                    <span>laugfs</span>
                    <h5>Regular 12.5 Kg (Re-fill)</h5>
                    <div class="star">(22) sold</div>
                    <h4>Rs. 5300.00</h4>
                </div>
            </div>
            <div class="pro">
                <img src="<?php echo BASEURL ?>/public/img/products/f8.png" alt="">
                <div class="des">
                    <span>laugfs</span>
                    <h5>Regulator Pack</h5>
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
            <h4>Hurry up for Sign UP</h4>
            <p><span>Get E-mail updates about your orders.</span></p>
        </div>
        <div class="form">
            <input type="email" placeholder="Your E-mail address" disabled>
            <button class="normal" onclick="location.href='signup.php';">Signup</button>
        </div>
    </section>

    <footer id="footer" class="section-p1">
        <div class="col">
            <img src="<?php echo BASEURL ?>/public/img/logo.png" class="logo" alt="">
            <h4>Contact</h4>
            <p><strong>Address: </strong> 43 Highlevel Road, Godagama, Homagama</p>
            <p><strong>Phone: </strong> +94 112 175 268 / +94 714 872 852</p>
            <p><strong>Hours: </strong> 10:00 - 16:00, Mon - Fri</p>
            <div class="follow">
                <h4>Follow us</h4>
                <div class="icon">
                    <img src="<?php echo BASEURL ?>/public/icons/facebook.svg" alt="">
                    <img src="<?php echo BASEURL ?>/public/icons/instagram.svg" alt="">
                    <img src="<?php echo BASEURL ?>/public/icons/twitter.svg" alt="">
                    <img src="<?php echo BASEURL ?>/public/icons/linkedin.svg" alt="">
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
            <!-- <h4>Install App</h4>
            <p>From App Store or Google Play</p>
            <div class="row">
                <img src="<?php echo BASEURL ?>/public/img/pay/app.jpg" alt="">
                <img src="<?php echo BASEURL ?>/public/img/pay/play.jpg" alt="">
            </div> -->
            <p>Secured Payment Gateways</p>
            <img src="<?php echo BASEURL ?>/public/img/pay/pay.png" alt="">
        </div>

        <div class="copyright">
            <p>© 2022, University of Colombo, School of Computing</p>
        </div>
    </footer>
    <!-- <script src="<?php echo BASEURL ?>public/js/script.js"></script> -->
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

        function ajaxcall(){
            let xhr = new XMLHttpRequest(); //new xml object
            xhr.open('POST', "<?php echo BASEURL?>/ajax/index", true);
            xhr.onload = ()=>{
                if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
                    let data = xhr.response;
                    console.log(data);
                    let para = document.getElementById('uniqueidentifier');
                    para.innerHTML = data;
                }
            }
            xhr.send();
        }
    </script>
</body>
</html>